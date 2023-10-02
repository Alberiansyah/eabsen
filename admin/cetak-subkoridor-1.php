<?php
require __DIR__ . "/../functions/functions.php";
require __DIR__ . '/../vendor/autoload.php';

use Carbon\Carbon;
use Dompdf\Dompdf;

Carbon::setLocale('id');
$today = Carbon::now('Asia/Jakarta')->toDateString();
$query = tampilData("SELECT karyawan.*, absen.*
                     FROM karyawan
                     INNER JOIN absen ON absen.id_karyawan = karyawan.id_karyawan
                     WHERE DATE(absen.absen_pagi) = '$today' OR DATE(absen.absen_sore) = '$today'");
$countQuery = count($query);
$no = 1;
$options = new \Dompdf\Options();
$options->set('isPhpEnabled', true);
$dompdf = new Dompdf($options);
$html = '
<!DOCTYPE html>
<html>
<head>
    <title>Data Koridor 1</title>
    <style>
    table {
        width: 100%;
        border-collapse: collapse;
     }
  
     table, th, td {
        border: 1px solid black;
     }
  
     th, td {
        padding: 8px;
     }
  
     th {
        background-color: #f2f2f2;
     }
    </style>
</head>
<body>

<div class="text-center mt-5">
    <center>
        <img src="' . $hostToRoot . '/wp-content/logo.png" alt="Logo" width="100" height="100">
        <br>
        <div class="p-2">
            <h1>' . $title . '</h1>
            <p>PORTAL ABSENSI BLUD UPT ANGKUTAN KOTA BANDUNG</p>
        </div>
    </center>
</div>
    <div class="container">
    <center>
        <div class="row d-flex justify-content-center">
            <div class="col-xl-10 col-lg-10 col-md-12 col-sm-12">
                <div class="row">
                    <div class="card">
                        <div class="card-body d-flex justify-content-between align-items-center">
                            <h3 class="card-title mb-4">Data Koridor 1</h3>
                        </div>
                        <div class="container mb-3">
                            <div class="table-responsive">
                                <table border="1">
                                    <tr>
                                        <th>No</th>
                                        <th>Nama</th>
                                        <th>Pagi</th>
                                        <th>Sore</th>
                                        <th>Jumlah Kehadiran</th>
                                    </tr>';

if ($countQuery < 1) {
    $html .=
        '<tr>
        <td colspan="5" style="text-align: center;">Belum terdapat data.</td>
    </tr>';
}
foreach ($query as $data) {
    $html .= '<tr>
                <td>' . $no++ . '</td>
                <td>' . $data->nama . '</td>
                <td>' . ($data->absen_pagi !== null ? Carbon::parse($data->absen_pagi)->translatedFormat('j F Y H:i:s') : '') . '</td>
                <td>' . ($data->absen_sore !== null ? Carbon::parse($data->absen_sore)->translatedFormat('j F Y H:i:s') : '') . '</td>';

    $counter = 0;
    if ($data->absen_pagi !== null) {
        $counter++;
    }
    if ($data->absen_sore !== null) {
        $counter++;
    }

    $html .= '<td>' . $counter . '</td>
            </tr>';
}

$html .= '                      </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        </center>
    </div>
</body>
</html>
';

$dompdf->loadHtml($html);
$dompdf->set_option('isRemoteEnabled', true);
$dompdf->setPaper('A4', 'portrait');
$dompdf->render();
$dompdf->stream('subkoridor-1.pdf', array('Attachment' => 0));
