<?php
require __DIR__ . "/../functions/functions.php";
require __DIR__ . '/../vendor/autoload.php';

use Carbon\Carbon;

// Mengatur lokasi ke Bahasa Indonesia
Carbon::setLocale('id');

// Mendefinisikan tanggal awal
$tanggalAwal = Carbon::create(2023, 1, 1);

// Inisialisasi array untuk menyimpan data berdasarkan bulan
$dataPerBulan = [];
$dataPerBulanNama = [];

// Loop untuk menghasilkan tanggal dan bulan
while ($tanggalAwal->year <= Carbon::now()->year) {
    $tanggalString = $tanggalAwal->translatedFormat('d F Y');
    $tanggalStringNama = $tanggalAwal->translatedFormat('D');
    $bulan = $tanggalAwal->translatedFormat('F'); // Mendapatkan nama bulan

    // Menambahkan tanggal ke array yang sesuai dengan bulannya
    $dataPerBulan[$bulan][] = $tanggalString;
    $dataPerBulanNama[$bulan][] = $tanggalStringNama;

    $tanggalAwal->addDay(); // Menambahkan 1 hari ke tanggal
}
// foreach ($dataPerBulan as $bulan => $tanggal) {
//     if ($bulan === "Januari") { // Pengecekan apakah bulan adalah Januari
//         echo "Bulan: " . $bulan . "<br>";
//         foreach ($tanggal as $tgl) {
//             echo $tgl . "<br>";
//         }
//         echo "<br>";
//     }
// }
$no = 1;
$query = tampilData("SELECT karyawan.*, absen.*
                        FROM karyawan
                        INNER JOIN absen ON absen.id_karyawan = karyawan.id_karyawan
                        AND karyawan.kategori = 'Koridor 1'
                     ");
$dataPerRow = [];

foreach ($query as $data) {
    // Membuat key unik untuk setiap karyawan
    $key = $data->id_karyawan;

    // Mengecek apakah key sudah ada dalam array dataPerRow
    if (!isset($dataPerRow[$key])) {
        // Jika belum, inisialisasi data per baris untuk karyawan ini
        $dataPerRow[$key] = [
            'no' => $no++,
            'nama' => $data->nama,
            'absen_pagi' => Carbon::parse($data->absen_pagi)->translatedFormat('H:i'),
            'absen_sore' => Carbon::parse($data->absen_sore)->translatedFormat('H:i'),
        ];
    }

    // Menambahkan tanggal absen pada array data per baris
    $tanggalAbsenPagi = Carbon::parse($data->absen_pagi)->translatedFormat('d F Y');
    $tanggalAbsenSore = Carbon::parse($data->absen_sore)->translatedFormat('d F Y');

    // Menambahkan tanggal absen ke dalam array data per baris
    $dataPerRow[$key][$tanggalAbsenPagi] = $tanggalAbsenPagi;
    $dataPerRow[$key][$tanggalAbsenSore] = $tanggalAbsenSore;
}


use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

// Membuat spreadsheet baru
$spreadsheet = new Spreadsheet();

// Mengaktifkan lembar kerja pertama (index 0)
$spreadsheet->setActiveSheetIndex(0);
$sheet = $spreadsheet->getActiveSheet();

// Mengisi data header
$sheet->setCellValue('A1', 'No');
$sheet->setCellValue('B1', 'Nama');

// Mengisi data tanggal dari $dataPerBulanNama ke dalam kolom-kolom
$columnIndex = 3; // Dimulai dari kolom C
foreach ($dataPerBulanNama['Oktober'] as $tgl) {
    $sheet->setCellValueByColumnAndRow($columnIndex, 1, $tgl);
    $sheet->setCellValueByColumnAndRow($columnIndex + 1, 1, $tgl);
    $columnIndex += 2;
}

// Mengisi data dari $dataPerRow ke dalam spreadsheet
$rowIndex = 2; // Dimulai dari baris ke-2
foreach ($dataPerRow as $row) {
    $sheet->setCellValue('A' . $rowIndex, $row['no']);
    $sheet->setCellValue('B' . $rowIndex, $row['nama']);

    // Mengisi data absen pagi dan sore
    $columnIndex = 3; // Dimulai dari kolom C
    foreach ($dataPerBulan['Oktober'] as $tgl) {
        if (isset($row[$tgl])) {
            $sheet->setCellValueByColumnAndRow($columnIndex, $rowIndex, $row['absen_pagi']);
            $sheet->setCellValueByColumnAndRow($columnIndex + 1, $rowIndex, $row['absen_sore']);
        }
        $columnIndex += 2;
    }

    $rowIndex++;
}

// Membuat objek Writer untuk menyimpan spreadsheet dalam format Excel (Xlsx)
$writer = new Xlsx($spreadsheet);

// Menyimpan spreadsheet ke dalam file Excel
$writer->save('data_absensi.xlsx');

echo "Data telah berhasil disimpan dalam format Excel.";
