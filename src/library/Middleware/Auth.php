<?php

declare(strict_types=1);

namespace App\Ebcms\Admin\Middleware;

use App\Ebcms\Admin\Interfaces\AccountInterface;
use App\Ebcms\Admin\Traits\ResponseTrait;
use Ebcms\App;
use Ebcms\Router;
use Psr\Http\Message\ResponseFactoryInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Ebcms\Session;

class Auth implements MiddlewareInterface
{
    use ResponseTrait;

    public function process(
        ServerRequestInterface $request,
        RequestHandlerInterface $handler
    ): ResponseInterface {
        return App::getInstance()->execute(function (
            Router $router,
            AccountInterface $account,
            Session $session,
            ResponseFactoryInterface $responseFactory
        ) use ($request, $handler): ResponseInterface {
            if (!$account->isLogin()) {
                $session->set('login_redirect', $_SERVER['REQUEST_URI']);
                $response = $responseFactory->createResponse(302);
                return $response->withHeader('Location', $router->buildUrl('/ebcms/admin/auth/login'));
            }
            return $handler->handle($request);
        });
    }
}
