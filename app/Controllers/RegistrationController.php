<?php

namespace App\Controllers;

use App\Core\{Controller, Csrf};
use App\Models\Registration;
use App\Services\Mailer;

class RegistrationController extends Controller
{
    public function index()
    {
        return $this->view('registration/index', ['csrf' => Csrf::token()]);
    }

    public function store()
    {
        header('Content-Type: application/json; charset=utf-8');

        if (!Csrf::check($_POST['csrf'] ?? null)) {
            return $this->res->json(['status' => 'error', 'message' => 'Invalid CSRF token', 'fields' => []]);
        }

        $full = trim($_POST['full_name'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $comp = trim($_POST['company'] ?? '');
        $fields = [];

        if ($full === '') {
            $fields['full_name'] = 'required';
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $fields['email'] = 'invalid';
        }

        if ($fields) {
            return $this->res->json(['status' => 'error', 'message' => 'Validation Error', 'fields' => $fields]);
        }

        $pdo = $this->pdo();

        if (Registration::existsByEmail($pdo, $email)) {
            return $this->res->json([
                'status' => 'error',
                'message' => 'Email artıq mövcuddur!',
                'fields' => ['email' => 'unique'],
            ]);
        }

        Registration::create($pdo, $full, $email, $comp ?: null);

        (new Mailer($this->config))->notifyAdmin('Yeni Qeydiyyat',
            sprintf('Ad Soyad: %s<br>Email: %s<br>Şirkət: %s',
                htmlspecialchars($full), htmlspecialchars($email), htmlspecialchars($comp))
        );

        return $this->res->json(['status' => 'success', 'message' => 'Qeydiyyat Tamamlandı']);
    }

    public function listPage()
    {
        if (empty($_SESSION['auth'])) {
            return $this->view('auth/login', ['csrf' => Csrf::token()]);
        }

        return $this->view('registrations/list', [
            'base_url' => $this->config['app']['base_url'] ?? '',
        ]);
    }
}