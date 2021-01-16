<?php

use App\Ebcms\Admin\Interfaces\AccountInterface;
use App\Ebcms\Admin\Middleware\Auth;
use App\Ebcms\Admin\Model\Account;
use Ebcms\App;
use Ebcms\Container;
use Ebcms\RequestHandler;

App::getInstance()->execute(function (
    App $app,
    Container $container,
    RequestHandler $requestHandler
) {
    if (!$container->has(AccountInterface::class)) {
        $container->set(AccountInterface::class, function () use ($container): AccountInterface {
            return $container->get(Account::class);
        });
    }
    if (!in_array($app->getRequestClass(), ['\App\Ebcms\Admin\Http\Auth\Login'])) {
        $requestHandler->lazyMiddleware(Auth::class);
    }
});
