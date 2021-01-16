<?php

declare(strict_types=1);

namespace App\Ebcms\Admin\Model;

use App\Ebcms\Admin\Interfaces\AccountInterface;
use Ebcms\App;
use Ebcms\Session;

class Account implements AccountInterface
{

    public function getAccountIdByName(string $name): int
    {
        if ($name == 'admin') {
            return 1;
        }
        return 0;
    }

    public function getAccountById(int $id): ?array
    {
        if ($id == 1) {
            return [
                'id' => 1,
                'name' => 'admin',
            ];
        }
        return null;
    }

    public function setPassword(int $id, string $password): bool
    {
        if ($id == 1) {
            $password_lock = App::getInstance()->getAppPath() . '/config/ebcms/admin/password.lock';
            if (!is_dir(dirname($password_lock))) {
                mkdir(dirname($password_lock), 0755, true);
            }
            file_put_contents($password_lock, $this->makePasswordString($password));
            return true;
        }
        return false;
    }

    public function loginById(int $id, string $password): bool
    {
        if ($this->verifyPassword($id, $password)) {
            $this->getSession()->set('admin_login_id', $id);
            return true;
        }
        return false;
    }

    public function loginByName(string $name, string $password): bool
    {
        if ($id = $this->getAccountIdByName($name)) {
            if ($this->verifyPassword($id, $password)) {
                $this->getSession()->set('admin_login_id', $id);
                return true;
            }
        }
        return false;
    }

    public function logout(): bool
    {
        $this->getSession()->delete('admin_login_id');
        return true;
    }

    public function isLogin(): bool
    {
        return $this->getLoginId() ? true : false;
    }

    public function getLoginId(): int
    {
        return ((int)$this->getSession()->get('admin_login_id')) ?: 0;
    }

    private function verifyPassword(int $id, string $password): bool
    {
        if ($id == 1) {
            if ($this->makePasswordString($password) == $this->getPasswordString($id)) {
                return true;
            }
        }
        return false;
    }

    private function makePasswordString(string $password): string
    {
        return md5($password . ' love ebcms forever!');
    }

    private function getPasswordString(int $id): ?string
    {
        if ($id == 1) {
            $password_lock = App::getInstance()->getAppPath() . '/config/ebcms/admin/password.lock';
            if (file_exists($password_lock)) {
                return file_get_contents($password_lock) ?: $this->makePasswordString('123456');
            }
            return $this->makePasswordString('123456');
        }
        return null;
    }

    private function getSession(): Session
    {
        return App::getInstance()->execute(function (
            Session $session
        ) {
            return $session;
        });
    }
}
