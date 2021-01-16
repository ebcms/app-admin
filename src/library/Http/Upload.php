<?php

declare(strict_types=1);

namespace App\Ebcms\Admin\Http;

use Ebcms\Config;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\UploadedFileInterface;

class Upload extends Common
{
    public function post(
        ServerRequestInterface $request,
        Config $config
    ) {
        foreach ($request->getUploadedFiles() as $key => $file) {
            /**
             * @var UploadedFileInterface $file
             */
            $ext = pathinfo($file->getClientFilename(), PATHINFO_EXTENSION);
            $type = $file->getClientMediaType();

            if (!in_array($ext, explode(',', $config->get('upload.exts@ebcms.admin', 'jpg,png,gif,zip')))) {
                return $this->failure('不支持的上传类型！');
            }
            if (!in_array($type, explode(',', $config->get('upload.types@ebcms.admin', 'image/gif,image/jpeg,image/jpg,image/pjpeg,image/x-png,image/png,application/x-zip,application/zip,application/x-zip-compressed')))) {
                return $this->failure('不支持的上传类型！');
            }

            $filename = uniqid();
            $path = './uploads/' . date('Y/m-d');
            if (!is_dir($path)) {
                mkdir($path, 0755, true);
            }
            $file->moveTo($path . '/' . $filename . '.' . $ext);

            return $this->success('上传成功！', '', [
                'src' => $this->getRoot() . substr($path, 1) . '/' . $filename . '.' . $ext,
                'extension' => $ext,
                'filename' => $file->getClientFilename(),
                'size' => $file->getSize(),
                'type' => $file->getClientMediaType(),
            ]);
        }
    }

    private function getRoot(): string
    {
        if (
            (!empty($_SERVER['REQUEST_SCHEME']) && $_SERVER['REQUEST_SCHEME'] == 'https')
            || (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on')
            || (!empty($_SERVER['SERVER_PORT']) && $_SERVER['SERVER_PORT'] == '443')
        ) {
            $schema = 'https';
        } else {
            $schema = 'http';
        }

        $script_name = '/' . implode('/', array_filter(explode('/', $_SERVER['SCRIPT_NAME'])));
        $root = strlen(dirname($script_name)) > 1 ? dirname($script_name) : '';

        return $schema . '://' . $_SERVER['HTTP_HOST'] . $root;
    }
}
