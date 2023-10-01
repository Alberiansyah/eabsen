<?php
require __DIR__ . "/../functions/functions.php";
require __DIR__ . "/../functions/session-check.php";
date_default_timezone_set('Asia/Jakarta');
$waktuSekarang = date('H:i');
$jamSekarang = (int)explode(':', $waktuSekarang)[0];
$menitSekarang = (int)explode(':', $waktuSekarang)[1];
// Waktu absensi pagi: 06:00 - 09:00
$pagiMulai = 6;
$pagiBerakhir = 9;

// Waktu absensi sore: 16:30 - 18:00
$soreMulai = 16;
$soreBerakhir = 24;

$query = tampilData("SELECT * FROM karyawan");
?>
<?php require __DIR__ . '/../wp-layouts/header.php' ?>

<div class="container mt-5">
    <div class="row d-flex justify-content-center">
        <div class="col-xl-10 col-lg-10 col-md-12 col-sm-12">
            <div class="card p-5" style="height: 300px;">
                <div class="row text-center">
                    <h2>Halo, <?= $_SESSION['nama'] ?> selamat datang kembali.</h2>
                </div>
                <div class="text-center position-absolute bottom-0 start-50 translate-middle-x mb-5">
                    <a href="rekap-data"><button class="btn btn-primary m-3 mx-5"><i class="fas fa-table"></i> Rekap Data</button></a>
                </div>
            </div>
        </div>
        <div class="text-end m-5">
            <a href="<?= $hostToRoot ?>admin/logout"><button class="btn btn-primary"><i class="fas fa-sign-out-alt"></i> Logout</button></a>
        </div>
    </div>
</div>

<?php require __DIR__ . '/../wp-layouts/footer.php' ?>