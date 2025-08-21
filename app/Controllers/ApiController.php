<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Models\Registration;

class ApiController extends Controller
{
    public function datatable()
    {
        if (empty($_SESSION['auth'])) {
            return $this->res->json([
                'draw' => 0,
                'recordsTotal' => 0,
                'recordsFiltered' => 0,
                'data' => []
            ]);

            $draw = (int)($this->req->input('draw') ?? 0);
            $start = max(0, (int)($this->req->input('start') ?? 0));
            $length = max(1, min(100, (int)($this->req->input('length') ?? 10)));
            $search = trim($this->req->input('search.value') ?? '');
            $orderIdx = (int)($this->req->input('order.0.column') ?? 0);
            $orderDir = (($this->req()->input('order.0.dir') ?? 'asc') === 'desc') ? 'DESC' : 'ASC';
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
}