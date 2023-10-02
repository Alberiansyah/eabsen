<?php
require 'vendor/autoload.php'; // Memasukkan autoload.php dari Carbon

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
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <table border="1">
        <tr>
            <th>Tanggal</th>
            <th>Tanggal</th>
            <th>IN</th>
            <th>OUT</th>
        </tr>

        <?php foreach ($dataPerBulan as $bulan => $tanggal) : ?>
            <?php if ($bulan === "Januari") : ?>
                <?php foreach ($tanggal as $tgl) : ?>
                    <tr>
                        <td></td>
                        <td><?= $tgl ?></td>
                        <td></td>
                        <td></td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        <?php endforeach; ?>
        <tr></tr>
    </table>

</body>

</html>