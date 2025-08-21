<?php

namespace App\Core;
class Response
{
    public function status(int $code): self
    {
        http_response_code($code);
        return $this;
    }

    public function json(array $data): void
    {
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode($data);
    }

    public function redirect(string $to): void
    {
        $base = $this->config['app']['base_url'] ?? '';
        $path = $to[0] === '/' ? $base . $to : $to;
        header('Location: ' . $path);
        exit;
    }

    public function send(string $html): void
    {
        echo $html;
    }
}