<?php

declare(strict_types=1);

namespace App\Ebcms\Admin\Http;

use App\Ebcms\Admin\Traits\ResponseTrait;
use App\Ebcms\Admin\Traits\RestfulTrait;
use Ebcms\Hook;

abstract class Common
{
    use RestfulTrait;
    use ResponseTrait;

    public function __construct(
        Hook $hook
    ) {
        $hook->emit('app.ebcms.admin.init');
    }
}
