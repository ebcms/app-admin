<?php

declare(strict_types=1);

namespace App\Ebcms\Admin\Traits;

use Ebcms\App;
use Psr\Http\Message\ResponseFactoryInterface;
use Psr\Http\Message\ServerRequestInterface;

trait RestfulTrait
{

    final public function handle(
        ServerRequestInterface $request,
        ResponseFactoryInterface $response_factory
    ) {
        $method = strtolower($request->getMethod());
        if (in_array($method, ['get', 'put', 'post', 'delete', 'head', 'patch', 'options']) && is_callable([$this, $method])) {
            return App::getInstance()->execute([$this, $method]);
        } else {
            return $response_factory->createResponse(405);
        }
    }
}
