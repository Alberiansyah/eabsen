<?php
require __DIR__ . "/functions/functions.php";
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
            <th rowspan="4">No</th>
            <th rowspan="4">Nama</th>
        </tr>
        <tr>
            <?php foreach ($dataPerBulanNama as $bulan => $tanggal) : ?>
                <?php if ($bulan === "Oktober") : ?>
                    <?php foreach ($tanggal as $tgl) : ?>
                        <td colspan="2"><?= $tgl ?></td>
                    <?php endforeach; ?>
                <?php endif; ?>
            <?php endforeach; ?>
        </tr>
        <tr>
            <?php foreach ($dataPerBulan as $bulan => $tanggal) : ?>
                <?php if ($bulan === "Oktober") : ?>
                    <?php foreach ($tanggal as $tgl) : ?>
                        <td colspan="2"><?= $tgl ?></td>
                    <?php endforeach; ?>
                <?php endif; ?>
            <?php endforeach; ?>
        </tr>
        <tr>
            <?php foreach ($dataPerBulan as $bulan => $tanggal) : ?>
                <?php if ($bulan === "Oktober") : ?>
                    <?php foreach ($tanggal as $tgl) : ?>
                        <td rowspan="1">IN</td>
                        <td rowspan="1">OUT</td>
                    <?php endforeach; ?>
                <?php endif; ?>
            <?php endforeach; ?>
        </tr>
        <?php foreach ($dataPerRow as $row) : ?>
            <tr>
                <td><?= $row['no'] ?></td>
                <td><?= $row['nama'] ?></td>

                <!-- Loop untuk tanggal -->
                <?php foreach ($dataPerBulan['Oktober'] as $tgl) : ?>
                    <td>
                        <?php
                        // Mengecek apakah tanggal absen pagi ada di data per baris
                        if (isset($row[$tgl])) {
                            echo $row['absen_pagi'];
                        }
                        ?>
                    </td>
                    <td>
                        <?php
                        // Mengecek apakah tanggal absen sore ada di data per baris
                        if (isset($row[$tgl])) {
                            echo $row['absen_sore'];
                        }
                        ?>
                    </td>
                <?php endforeach; ?>
            </tr>
        <?php endforeach; ?>
    </table>

    <?php require __DIR__ . '/wp-layouts/footer.php' ?>
</body>

</html>