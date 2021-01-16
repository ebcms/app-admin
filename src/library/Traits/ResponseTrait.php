<?php

declare(strict_types=1);

namespace App\Ebcms\Admin\Traits;

use Ebcms\ResponseFactory;
use Psr\Http\Message\ResponseInterface;
use Ebcms\Template;

trait ResponseTrait
{

    final public function html(string $string): ResponseInterface
    {
        $response = (new ResponseFactory)->createResponse(200);
        $response->getBody()->write($string);
        return $response;
    }

    final public function json(string $data): ResponseInterface
    {
        $response = (new ResponseFactory)->createResponse(200);
        $response->getBody()->write($data);
        return $response->withHeader('Content-Type', 'application/json');
    }

    final public function redirect(string $url, int $code = 302): ResponseInterface
    {
        $response = (new ResponseFactory)->createResponse($code);
        return $response->withHeader('Location', $url);
    }

    final public function success(
        string $message,
        string $url = 'javascript:history.back(-1);',
        $data = '',
        string $tpl = null
    ): ResponseInterface {
        $res = [
            'code' => 1,
            'message' => $message,
            'url' => $url,
            'data' => $data,
        ];
        $response = (new ResponseFactory)->createResponse(200);
        if ($this->_isAjax()) {
            $response->getBody()->write(json_encode($res));
            return $response->withHeader('Content-Type', 'application/json');
        } else {
            $response->getBody()->write((new Template)->renderFromString($tpl ?: $this->_getTpl(), $res));
            return $response;
        }
    }

    final public function failure(
        string $message,
        string $url = 'javascript:history.back(-1);',
        $data = '',
        string $tpl = null
    ): ResponseInterface {
        $res = [
            'code' => 0,
            'message' => $message,
            'url' => $url,
            'data' => $data,
        ];
        $response = (new ResponseFactory)->createResponse(200);
        if ($this->_isAjax()) {
            $response->getBody()->write(json_encode($res));
            return $response->withHeader('Content-Type', 'application/json');
        } else {
            $response->getBody()->write((new Template)->renderFromString($tpl ?: $this->_getTpl(), $res));
            return $response;
        }
    }

    final public function notice(
        string $message,
        $status_code = 200,
        string $url = 'javascript:history.back(-1);',
        string $tpl = null
    ): ResponseInterface {
        $res = [
            'code' => 0,
            'message' => $message,
            'url' => $url,
        ];
        $response = (new ResponseFactory)->createResponse($status_code);
        if ($this->_isAjax()) {
            $response->getBody()->write(json_encode($res));
            return $response->withHeader('Content-Type', 'application/json');
        } else {
            $response->getBody()->write((new Template)->renderFromString($tpl ?: $this->_getTpl(), $res));
            return $response;
        }
    }

    final private function _isAjax(): bool
    {
        if (isset($_SERVER["HTTP_X_REQUESTED_WITH"]) && strtolower($_SERVER["HTTP_X_REQUESTED_WITH"]) == "xmlhttprequest") {
            return true;
        } else {
            return false;
        }
    }

    final private function _getTpl(): string
    {
        return <<<'str'
<!DOCTYPE html>
<html lang="zh-CN">

<head>
    <meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no" />
    <title>{$message?:'Success!'}</title>
</head>

<body style="overflow: hidden;background:#fff;">
    <div style="margin: 0 20px;background:#fdfdfd;">
        <div style="font-size:120px;font-weight:bold;">{$code?":)":":("}</div>
        <div style="margin: 20px auto;font-size: 38px;font-weight: bold;">{$message?:'Success!'}</div>
        <div style="margin: 10px auto;font-size: 30px;">
            <a id="jump" href="#" style="font-weight:bold;font-size:20px;text-decoration:none;"><span id="time"></span><small>s</small></a>
        </div>
    </div>
    <script>
        var num = 3;
        document.getElementById("jump").href="{:$url?:'javascript:history.back(-1)'}";
        document.getElementById("time").innerHTML = num;
        setInterval(function () {
            num -= 1;
            if (num <= 0) {
                if (document.all) {
                    document.getElementById("jump").click();
                } else {
                    var e = document.createEvent("MouseEvents");
                    e.initEvent("click", true, true);
                    document.getElementById("jump").dispatchEvent(e);
                }
            } else {
                document.getElementById("time").innerHTML = num;
            }
        }, 1000);
    </script>
</body>

</html>
str;
    }
}
