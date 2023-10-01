<?php
require __DIR__ . "/../functions/functions.php";
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
            <div class="card p-5" style="height: auto;">
                <div class="row">
                    <div class="col-4 p-3 text-center">
                        <a href="subkoridor-1"><button class="btn btn-primary btn-block">Koridor 1</button></a>
                    </div>
                    <div class="col-4 p-3 text-center">
                        <a href="subkoridor-2"><button class="btn btn-primary btn-block">Koridor 2</button></a>
                    </div>
                    <div class="col-4 p-3 text-center">
                        <a href="subkoridor-3"><button class="btn btn-primary btn-block">Koridor 3</button></a>
                    </div>
                    <div class="col-4 p-3 text-center">
                        <a href="subkoridor-4"><button class="btn btn-primary btn-block">Koridor 4</button></a>
                    </div>
                    <div class="col-4 p-3 text-center">
                        <a href="subkoridor-5"><button class="btn btn-primary btn-block">Koridor 5</button></a>
                    </div>
                    <div class="col-4 p-3 text-center">
                        <a href="subkoridor-6"><button class="btn btn-primary btn-block">Koridor 6</button></a>
                    </div>
                </div>
            </div>
        </div>

        <div class="text-end m-5">
            <a href="<?= $hostToRoot ?>admin/logout"><button class="btn btn-primary"><i class="fas fa-sign-out-alt"></i> Logout</button></a>
        </div>
    </div>
</div>

<?php require __DIR__ . '/../wp-layouts/footer.php' ?>