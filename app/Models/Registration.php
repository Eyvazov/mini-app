<?php

namespace App\Models;

use PDO;
use App\Core\DB;

class Registration
{
    public static array $columns = ['id', 'full_name', 'email', 'company', 'created_at'];

    public static function existsByEmail(PDO $pdo, string $email): bool
    {
        $st = $pdo->prepare('SELECT 1 FROM registrations WHERE email=? LIMIT 1');
        $st->execute([$email]);
        return (bool)$st->fetchColumn();
    }

    public static function create(PDO $pdo, string $full, string $email, ?string $company): int
    {
        $st = $pdo->prepare('INSERT INTO registrations(full_name,email,company) VALUES(?,?,?)');
        $st->execute([$full, $email, $company]);
        return (int)$pdo->lastInsertId();
    }

    public static function counts(PDO $pdo, ?string $search): array
    {
        $total = (int)$pdo->query('SELECT COUNT(*) FROM registrations')->fetchColumn();
        if ($search) {
            $like = "%$search%";
            $st = $pdo->prepare('SELECT COUNT(*) FROM registrations WHERE full_name LIKE ? OR email LIKE ? OR company LIKE ?');
            $st->execute([$like, $like, $like]);
            $filtered = (int)$st->fetchColumn();
        } else {
            $filtered = $total;
        }
        return [$total, $filtered];
    }

    public function datatable(PDO $pdo, ?string $search, string $orderCol, string $orderDir, int $start, int $length): array
    {
        $where = '';
        $params = [];
        if ($search) {
            $where = 'WHERE full_name LIKE ? OR email LIKE ? OR company LIKE ?';
            $params = ["%$search%", "%$search%", "%$search%"];
        }

        $sql = "SELECT id,full_name,email,company,created_at FROM registrations $where ORDER BY $orderCol $orderDir LIMIT $start,$length";
        $st = $pdo->prepare($sql);
        $st->execute($params);
        return $st->fetchAll();
    }

    public static function exportAll(PDO $pdo, ?string $search, string $orderCol, string $orderDir): array
    {
        $where = '';
        $params = [];
        if ($search) {
            $where = 'WHERE ful_name LIKE ? OR email LIKE ? OR company LIKE ?';
            $params = ["%$search%", "%$search%", "%$search%"];
        }
        $sql = "SELECT id,full_name,email,company,created_at FROM registrations $where ORDER BY $orderCol $orderDir";
        $st = $pdo->prepare($sql);
        $st->execute($params);
        return $st->fetchAll();
    }
}