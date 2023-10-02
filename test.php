<?php
require __DIR__ . "/functions/functions.php";
require __DIR__ . '/vendor/autoload.php';

use Carbon\Carbon;

Carbon::setLocale('id');
$carbon = Carbon::now('Asia/Jakarta');
$waktuSekarang = $carbon->format('H:i');
$jamSekarang = (int)explode(':', $waktuSekarang)[0];
$menitSekarang = (int)explode(':', $waktuSekarang)[1];

$daftarBulan = [];
for ($i = 1; $i <= 12; $i++) {
    $daftarBulan[] = $carbon->month($i)->translatedFormat('F');
}

// Tampilkan daftar bulan
foreach ($daftarBulan as $bulan) {
    echo $bulan . "\n";
}
