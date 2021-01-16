<?php

declare(strict_types=1);

namespace App\Ebcms\Admin\Http\Auth;

use App\Ebcms\Admin\Traits\ResponseTrait;
use App\Ebcms\Admin\Traits\RestfulTrait;
use Psr\Http\Message\ResponseFactoryInterface;
use Psr\Http\Message\ResponseInterface;
use Ebcms\Captcha;
use Ebcms\Session;

class Captcha
{

    use RestfulTrait;
    use ResponseTrait;

    public function get(
        Session $session,
        ResponseFactoryInterface $responseFactory,
        Captcha $captcha
    ): ResponseInterface {
        $code = mt_rand(1000, 9999);
        $session->set('admin_captcha', $code);
        $response = $responseFactory->createResponse(200);
        $response->getBody()->write($captcha->create((string)$code));
        return $response->withHeader('Content-Type', 'image/png');
    }
}
