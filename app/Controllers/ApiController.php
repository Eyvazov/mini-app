<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Models\Registration;

class ApiController extends Controller
{
    public function datatable()
    {
        if (empty($_SESSION['auth'])) return $this->res->json([
            "draw" => 0,
            "recordsTotal" => 0,
            "recordsFiltered" => 0,
            "data" => []
        ]);
        $draw = (int)($_GET['draw'] ?? 0);
        $start = max(0, (int)($_GET['start'] ?? 0));
        $length = max(1, min(100, (int)($_GET['length'] ?? 10))); // limit
        $search = trim($_GET['search']['value'] ?? '');
        $orderIdx = (int)($_GET['order'][0]['column'] ?? 0);
        $orderDir = (($_GET['order'][0]['dir'] ?? 'asc') === 'desc') ? 'DESC' : 'ASC';
        $whitelist = Registration::$columns;
        $orderCol = $whitelist[$orderIdx] ?? 'id';
        [$total, $filtered] = Registration::counts($this->pdo(), $search ?: null);
        $data = Registration::datatable($this->pdo(), $search ?: null, $orderCol, $orderDir, $start, $length);

        return $this->res->json([
            'draw' => $draw,
            'recordsTotal' => $total,
            'recordsFiltered' => $filtered,
            'data' => $data
        ]);
    }
}
