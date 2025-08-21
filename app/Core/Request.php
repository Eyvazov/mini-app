<?php

namespace App\Core;

class Request
{

    public static function capture(): self
    {
        return new self;
    }

    public function method(): string
    {
        return $_SERVER['REQUEST_METHOD'] ?? 'GET';
    }

    public function path(): string
    {
        $basePath = '/mini-app';
        $path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        if (str_starts_with($path, $basePath)) {
            $path = substr($path, strlen($basePath));
        }
        return '/' . trim($path, '/');
    }

    public function input(string $key, $default = null)
    {
        return $_POST[$key] ?? $_GET[$key] ?? $default;
    }

    public function all(): array
    {
        return array_merge($_GET, $_POST);
    }

    public function query(string $key, $default = null)
    {
        return $_GET[$key] ?? $default;
    }

}