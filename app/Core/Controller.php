<?php

namespace App\Core;

abstract class Controller
{
    public function __construct(protected array $config, protected Request $req, protected Response $res)
    {
    }

    protected function view(string $tpl, array $data = []): void
    {
        View::render($tpl, $data);
    }

    protected function pdo()
    {
        return DB::pdo($this->config);
    }
}