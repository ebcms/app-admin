<?php

declare(strict_types=1);

namespace App\Ebcms\Admin\Http\Auth;

use App\Ebcms\Admin\Http\Common;
use App\Ebcms\Admin\Interfaces\AccountInterface;
use Ebcms\Router;
use Psr\Http\Message\ResponseInterface;
use Ebcms\RequestFilter;
use Ebcms\Session;
use Ebcms\Template;

class Login extends Common
{

    public function get(
        Template $template
    ): ResponseInterface {
        $html = $template->renderFromFile('auth/login@ebcms/admin');
        return $this->html($html);
    }

    public function post(
        Router $router,
        RequestFilter $input,
        AccountInterface $accountModel,
        Session $session
    ): ResponseInterface {
        $captcha = $_POST['captcha'];
        if (!$captcha || $captcha != $session->get('admin_captcha')) {
            return $this->failure('验证码无效！');
        }
        $session->delete('admin_captcha');

        if (!$accountModel->loginByName($input->post('account'), $input->post('password'))) {
            return $this->failure('认证失败！');
        }

        if ($login_redirect = $session->get('login_redirect')) {
            $session->delete('login_redirect');
        } else {
            $login_redirect = $router->buildUrl('/ebcms/admin/index');
        }

        return $this->redirect($login_redirect);
    }
}
