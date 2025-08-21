<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Models\Registration;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Dompdf\Dompdf;

class ExportController extends Controller
{
    private function commonFilters(): array
    {
        $search = '';
        if (isset($_GET['search']['value'])) {
            $search = is_string($_GET['search']['value']) ? trim($_GET['search']['value']) : '';
        } elseif (isset($_GET['search'])) {
            $search = is_string($_GET['search']) ? trim($_GET['search']) : '';
        }

        $idx = 0;
        if (isset($_GET['order'][0]['column'])) {
            $idx = (int)$_GET['order'][0]['column'];
        } elseif (isset($_GET['order_col'])) {
            $idx = (int)$_GET['order_col'];
        }

        $dir = 'ASC';
        if (isset($_GET['order'][0]['dir'])) {
            $dir = strtolower($_GET['order'][0]['dir']) === 'desc' ? 'DESC' : 'ASC';
        } elseif (isset($_GET['order_dir'])) {
            $dir = strtolower($_GET['order_dir']) === 'desc' ? 'DESC' : 'ASC';
        }

        $cols = \App\Models\Registration::$columns;
        $col = $cols[$idx] ?? 'id';

        return [$search, $col, $dir];
    }


    public function xlsx()
    {
        if (empty($_SESSION['auth'])) return $this->res->status(403)->send('Forbidden');
        [$search, $col, $dir] = $this->commonFilters();
        $rows = Registration::exportAll($this->pdo(), $search, $col, $dir);
        $sheet = new Spreadsheet();
        $ws = $sheet->getActiveSheet();
        $ws->fromArray(['ID', 'Ad Soyad', 'Email', 'Şirkət', 'Qeydiyyatdan Keçdiyi Tarix'], NULL,
            'A1');
        $r = 2;
        foreach ($rows as $row) {
            $ws->fromArray([$row['id'], $row['full_name'],
                $row['email'], $row['company'], $row['created_at']], NULL, 'A' . $r++);
        }

        header('Content-Type: application/vnd.openxmlformatsofficedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="registrations.xlsx"');
        (new Xlsx($sheet))->save('php://output');
        exit;
    }

    public function pdf()
    {
        if (empty($_SESSION['auth'])) return $this->res->status(403)->send('Forbidden');
        [$search, $col, $dir] = $this->commonFilters();
        $rows = Registration::exportAll($this->pdo(), $search, $col, $dir);
        $html = '<html>
         <head>
        <meta charset="UTF-8">
        <style>
            body { font-family: "DejaVu Sans", sans-serif; }
            table { border-collapse: collapse; width: 100%; }
            th, td { border: 1px solid #000; padding: 4px; text-align: left; }
        </style>
    </head>
    <body>';

        $html .= '<h3>Qeydiyyatlar</h3>
                    <table width="100%" border="1" cellspacing="0" cellpadding="4">'
            . '<tr>
                            <th>ID</th>
                            <th>Ad Soyad</th>
                            <th>Email</th>
                            <th>Şirkət</th>
                            <th>Qeydiyyatdan Keçdiyi Tarix</th>
                           </tr>';
        foreach ($rows as $r) {
            $html .= sprintf('<tr><td>%d</td><td>%s</td><td>%s</td><td>%s</td><td>%s</
td></tr>',
                $r['id'], htmlspecialchars($r['full_name']),
                htmlspecialchars($r['email']), htmlspecialchars((string)$r['company']),
                htmlspecialchars($r['created_at'])
            );
        }
        $html .= '</table>
                    </body>
                    </html>';
        $dompdf = new Dompdf();
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();
        $dompdf->stream('registrations.pdf', ['Attachment' => true]);
        exit;
    }
}