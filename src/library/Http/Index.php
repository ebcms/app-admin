<?php

declare(strict_types=1);

namespace App\Ebcms\Admin\Http;

use Ebcms\App;
use Ebcms\Config;
use SplPriorityQueue;
use Ebcms\Request;
use Ebcms\Template;

class Index extends Common
{
    public function get(
        App $app,
        Config $config,
        Request $request,
        Template $template
    ) {
        if ($request->get('tpl') == 'main') {
            $readme_file = $app->getAppPath() . '/README.md';
            $json_file = $app->getAppPath() . '/composer.json';
            $html = $template->renderFromFile('main@ebcms/admin', [
                'readme' => file_exists($readme_file) ? file_get_contents($readme_file) : '',
                'package' => file_exists($json_file) ? json_decode(file_get_contents($json_file), true) : [],
            ]);
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
