<?php

declare(strict_types=1);

namespace App\Ebcms\Admin\Model;

use Ebcms\App;
use LogicException;

class Config
{
    private $app;

    public function __construct(App $app)
    {
        $this->app = $app;
    }

    public function save(array $data)
    {
        foreach ($data as $vendor => $projects) {
            if (is_array($projects)) {
                foreach ($projects as $project => $configs) {
                    if (is_array($configs)) {
                        foreach ($configs as $filename => $config) {
                            $path = $this->app->getAppPath() . '/config/' . $vendor . '/' . $project;
                            if (!is_dir($path)) {
                                mkdir($path, 0755, true);
                            }
                            if (is_array($config)) {
                                if (is_file($path . '/' . $filename . '.php')) {
                                    $tmp = include $path . '/' . $filename . '.php';
                                    if (!$this->checkSimpleValue($tmp)) {
                                        throw new LogicException('配置文件：' . $path . '/' . $filename . '.php' . ' 存在标量和数组以外的数据类型，无法完成更新！');
                                    }
                                    if (is_array($tmp)) {
                                        $config = array_merge($tmp, $config);
                                    }
                                }
                            }
                            file_put_contents($path . '/' . $filename . '.php', '<?php return ' . var_export($config, true) . ';');
                        }
                    }
                }
            }
        }
    }

    private function checkSimpleValue($data)
    {
        if (is_scalar($data)) {
            return true;
        }
        if (is_array($data)) {
            foreach ($data as $value) {
                if (!$this->checkSimpleValue($value)) {
                    return false;
                }
            }
            return true;
        }
        return false;
    }
}
