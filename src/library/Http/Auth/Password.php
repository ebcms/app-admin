<?php

declare(strict_types=1);

namespace App\Ebcms\Admin\Http\Auth;

use App\Ebcms\Admin\Http\Common;
use App\Ebcms\Admin\Interfaces\AccountInterface;
use Psr\Http\Message\ResponseInterface;
use Ebcms\Request;

class Password extends Common
{
    public function post(
        Request $request,
        AccountInterface $accountModel
    ): ResponseInterface {
        if ($accountModel->setPassword($accountModel->getLoginId(), $request->post('password'))) {
            return $this->success('修改成功！');
        } else {
            return $this->failure('操作失败！');
        }
    }
}
