<?php
require 'vendor/autoload.php'; // Memasukkan autoload.php dari Carbon

use Carbon\Carbon;

// Mengatur lokasi ke Bahasa Indonesia
Carbon::setLocale('id');

// Mendefinisikan tanggal awal
$tanggalAwal = Carbon::create(2023, 1, 1);

// Inisialisasi array untuk menyimpan data berdasarkan bulan
$dataPerBulan = [];

// Loop untuk menghasilkan tanggal dan bulan
while ($tanggalAwal->year <= Carbon::now()->year) {
    $tanggalString = $tanggalAwal->toDateString();
    $bulan = $tanggalAwal->translatedFormat('F'); // Mendapatkan nama bulan

    // Menambahkan tanggal ke array yang sesuai dengan bulannya
    $dataPerBulan[$bulan][] = $tanggalString;

    $tanggalAwal->addDay(); // Menambahkan 1 hari ke tanggal
}

foreach ($dataPerBulan as $bulan => $tanggal) {
    if ($bulan === "Januari") { // Pengecekan apakah bulan adalah Januari
        echo "Bulan: " . $bulan . "<br>";
        foreach ($tanggal as $tgl) {
            echo $tgl . "<br>";
        }
        echo "<br>";
    }
}




// Menampilkan data yang telah dikelompokkan berdasarkan bulan
// foreach ($dataPerBulan as $bulan => $tanggal) {
//     echo "Bulan: " . $bulan . "<br>";
//     foreach ($tanggal as $tgl) {
//         echo $tgl . "<br>";
//     }
//     echo "<br>";
// }
