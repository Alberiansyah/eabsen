<?php
require __DIR__ . "/../functions/functions.php";
require __DIR__ . '/../vendor/autoload.php';

use Carbon\Carbon;

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

Carbon::setLocale('id');
$koridor = $_GET['koridor'];
$today = Carbon::now('Asia/Jakarta')->toDateString();
$getDay = Carbon::parse($today)->isoFormat('dddd');
$query = tampilData("SELECT karyawan.*, absen.*
                        FROM absen
                        INNER JOIN karyawan ON karyawan.id_karyawan = absen.id_karyawan 
                        WHERE (DATE(absen.absen_pagi) = '$today' OR DATE(absen.absen_sore) = '$today')
                        AND karyawan.kategori = '$koridor'
                        ");

// Buat objek spreadsheet
$spreadsheet = new Spreadsheet();

// Buat worksheet
$worksheet = $spreadsheet->getActiveSheet();
$worksheet->setTitle('Data Kehadiran');

// Isi header tabel
$worksheet->setCellValue('A1', 'No');
$worksheet->setCellValue('B1', 'Nama');
$worksheet->setCellValue('C1', 'Pagi');
$worksheet->setCellValue('D1', 'Sore');
$worksheet->setCellValue('E1', 'Jumlah Kehadiran');

// Isi data dari tabel
$data = 2; // Mulai dari baris kedua
$no = 1;

foreach ($query as $row) {
    // Inisialisasi counter sebelum penggunaannya
    $counter = 0;

    $worksheet->setCellValue('A' . $data, $no++);
    $worksheet->setCellValue('B' . $data, $row->nama);
    $worksheet->setCellValue('C' . $data, $row->absen_pagi !== null ? Carbon::parse($row->absen_pagi)->translatedFormat('d F Y H:i:s') : '');
    $worksheet->setCellValue('D' . $data, $row->absen_sore !== null ? Carbon::parse($row->absen_sore)->translatedFormat('d F Y H:i:s') : '');

    // Hitung jumlah kehadiran
    if ($row->absen_pagi !== null) {
        $counter++;
    }
    if ($row->absen_sore !== null) {
        $counter++;
    }

    $worksheet->setCellValue('E' . $data, $counter);

    // Set batas (border) untuk sel-sel dalam kolom A sampai E
    for ($col = 'A'; $col <= 'E'; $col++) {
        $worksheet->getStyle($col . $data)->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);

        // Otomatis melebarkan lebar sel
        $worksheet->getColumnDimension($col)->setAutoSize(true);
    }

    $data++;
}

// Set warna latar belakang untuk baris kepala (thead)
$worksheet->getStyle('A1:E1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID);
$worksheet->getStyle('A1:E1')->getFill()->getStartColor()->setARGB('FFC0C0C0'); // Ganti dengan kode warna yang Anda inginkan

// Set ulang data ke 2 untuk baris pertama dalam tbody
$data = 2;
foreach ($query as $row) {
    // ...

    $data++;
}

// Buat objek Writer Excel
$writer = new Xlsx($spreadsheet);

// Keluarkan file Excel
$filename = 'Rekap Absen ' . $getDay . '.xlsx'; // Nama file Excel yang akan dihasilkan
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="' . $filename . '"');
header('Cache-Control: max-age=0');
$writer->save('php://output');
exit;
