<?php

namespace App\Core;

class View
{
    public static function render(string $tpl, array $data = []): void
    {
        extract($data, EXTR_SKIP);
        $viewFile = __DIR__ . '/../Views/' . $tpl . '.php';
        require __DIR__ . '/../Views/layout.php';
    }
}