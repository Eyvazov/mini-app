<?php

namespace App\Controllers;

use App\Core\{Controller, Csrf};


class AuthController extends Controller
{

    public function login()
    {
        if (!Csrf::check($this->req->input('csrf'))) return $this->res->status(400)->send('Bad CSRF');
        $email = trim((string)$this->req->input('email'));
        $pass = (string)$this->req->input('password');
        if ($email === 'admin@example.com' && $pass === '123456') {
            $_SESSION['auth'] = true;
            return $this->res->redirect('list');
        }
        $_SESSION['flash_error'] = 'Email və ya şifrə yanlışdır';
        $_SESSION['auth'] = false;
        return $this->res->redirect('list');
    }

    public function logout()
    {
        session_destroy();
        return $this->res->redirect(BASE_URL);
    }
}