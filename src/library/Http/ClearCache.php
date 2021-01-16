<?php

declare(strict_types=1);

namespace App\Ebcms\Admin\Http;

use Psr\Http\Message\ResponseInterface;
use Psr\SimpleCache\CacheInterface;

class ClearCache extends Common
{
    public function post(
        CacheInterface $cache
    ): ResponseInterface {
        if ($cache->clear()) {
            return $this->success('清理成功！');
        }
        return $this->failure('清理失败！');
    }
}
