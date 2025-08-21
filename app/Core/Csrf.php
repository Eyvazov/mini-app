<?php

namespace App\Core;

class Csrf
{
    public static function token(): string
    {
        return $_SESSION['csrf'] ??= bin2hex(random_bytes(16));
    }

    public static function check(?string $t): bool
    {
        return $t && hash_equals($_SESSION['csrf'] ?? '', $t);
    }
}