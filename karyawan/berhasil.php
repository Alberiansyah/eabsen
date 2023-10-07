<?php
require __DIR__ . "/../functions/functions.php";
require __DIR__ . "/../functions/has-login.php";
date_default_timezone_set('Asia/Jakarta');
$waktuSekarang = date('H:i');
$jamSekarang = (int)explode(':', $waktuSekarang)[0];
$menitSekarang = (int)explode(':', $waktuSekarang)[1];
// Waktu absensi pagi: 06:00 - 09:00
$pagiMulai = 6;
$pagiBerakhir = 9;

// Waktu absensi sore: 16:30 - 18:00
$soreMulai = 16;
$soreBerakhir = 18;

$query = tampilData("SELECT * FROM karyawan");
?>
<?php require __DIR__ . '/../wp-layouts/header.php' ?>

<div class="container mt-5">
    <div class="row d-flex justify-content-center">
        <div class="col-xl-8 col-lg-8 col-md-12 col-sm-12">
            <div class="card bg-primary">
                <div class="row text-center p-5">
                    <h2>ABSEN TELAH BERHASIL</h2>
                </div>
            </div>
        </div>
        <div class="text-end m-5">
            <a href="<?= $hostToRoot ?>index"><button class="btn btn-primary">Kembali</button></a>
        </div>
    </div>
</div>

<?php require __DIR__ . '/../wp-layouts/footer.php' ?>