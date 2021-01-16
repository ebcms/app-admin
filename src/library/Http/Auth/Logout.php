<?php

declare(strict_types=1);

namespace App\Ebcms\Admin\Http\Auth;

use App\Ebcms\Admin\Http\Common;
use App\Ebcms\Admin\Interfaces\AccountInterface;
use Ebcms\Router;
use Psr\Http\Message\ResponseInterface;

class Logout extends Common
{
    public function get(
        AccountInterface $account,
        Router $router
    ): ResponseInterface {
        if ($account->logout()) {
            return $this->redirect($_SERVER['HTTP_REFERER'] ?? $router->buildUrl('/ebcms/admin/index'));
        } else {
            return $this->failure('操作失败！');
        }
    }
}
