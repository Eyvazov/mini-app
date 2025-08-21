<?php

namespace App\Services;

use PHPMailer\PHPMailer\PHPMailer;
use Throwable;

class Mailer
{
    public function __construct(private array $cfg)
    {
    }

    public function notifyAdmin(string $subject, string $html): bool
    {
        $m = new PHPMailer(true);
        try {
            $m->isSMTP();
            $m->Host = $this->cfg['mail']['host'];
            $m->SMTPAuth = true;
            $m->Username = $this->cfg['mail']['user'];
            $m->Password = $this->cfg['mail']['pass'];
            $m->SMTPSecure = $this->cfg['mail']['secure'];
            $m->Port = $this->cfg['mail']['port'];
            $m->setFrom($this->cfg['mail']['user'], 'Mini App');
            $m->addAddress($this->cfg['mail']['admin']);
            $m->isHTML(true);
            $m->Subject = $subject;
            $m->Body = $html;
            $m->send();
            return true;
        } catch (\Throwable $e) {
            return false;
        }
    }
}