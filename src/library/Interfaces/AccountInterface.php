<?php

declare(strict_types=1);

namespace App\Ebcms\Admin\Interfaces;

interface AccountInterface
{
    public function getAccountById(int $id): ?array;
    public function getAccountIdByName(string $name): int;
    public function setPassword(int $id, string $password): bool;
    public function loginById(int $id, string $password): bool;
    public function loginByName(string $name, string $password): bool;
    public function logout(): bool;
    public function isLogin(): bool;
    public function getLoginId(): int;
}
