<?php

declare(strict_types=1);

namespace App\Ebcms\Admin\Http;

use Ebcms\App;
use Ebcms\Config;
use SplPriorityQueue;
use Ebcms\RequestFilter;
use Ebcms\Template;

class Index extends Common
{
    public function get(
        App $app,
        Config $config,
        RequestFilter $input,
        Template $template
    ) {
        if ($input->get('tpl') == 'main') {
            $html = $template->renderFromFile('main@ebcms/admin');
            return $this->html($html);
        } else {
            $menus = new SplPriorityQueue;
            foreach (array_keys($app->getPackages()) as $value) {
                $tmp = $config->get('admin_menus@' . $value);
                if (is_array($tmp)) {
                    foreach ($tmp as $value) {
                        $value = array_merge([
                            'title' => '',
                            'url' => '',
                            'icon' => '',
                            'badge' => '',
                            'priority' => 50
                        ], (array)$value);
                        if (
                            $value['title'] &&
                            $value['url'] &&
                            $value['icon']
                        ) {
                            $menus->insert($value, $value['priority']);
                        }
                    }
                }
            }
            return $template->renderFromFile('index@ebcms/admin', [
                'menus' => iterator_to_array($menus),
            ]);
        }
    }
}
