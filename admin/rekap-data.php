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
$dataKoridor = ["Koridor 1", "Koridor 2", "Koridor 3", "Koridor 4", "Koridor 5", "Bandros", 'Pegawai Administrasi'];
$dataLink = ["subkoridor-1", "subkoridor-2", "subkoridor-3", "subkoridor-4", "subkoridor-5", "Bandros", 'pegawai-administrasi'];
$query = tampilData("SELECT * FROM karyawan");
?>
<?php require __DIR__ . '/../wp-layouts/header.php' ?>
<div class="container mt-5">
    <div class="row d-flex justify-content-center">
        <div class="col-xl-10 col-lg-10 col-md-12 col-sm-12">
            <div class="card p-5" style="height: auto;">
                <div class="row">
                    <div class="col-6 col-md-4 p-3 text-center">
                        <a href="subkoridor-1"><button class="btn btn-lg btn-primary btn-block">Koridor 1</button></a>
                    </div>
                    <div class="col-6 col-md-4 p-3 text-center">
                        <a href="subkoridor-2"><button class="btn btn-lg btn-primary btn-block">Koridor 2</button></a>
                    </div>
                    <div class="col-6 col-md-4 p-3 text-center">
                        <a href="subkoridor-3"><button class="btn btn-lg btn-primary btn-block">Koridor 3</button></a>
                    </div>
                    <div class="col-6 col-md-4 p-3 text-center">
                        <a href="subkoridor-4"><button class="btn btn-lg btn-primary btn-block">Koridor 4</button></a>
                    </div>
                    <div class="col-6 col-md-4 p-3 text-center">
                        <a href="subkoridor-5"><button class="btn btn-lg btn-primary btn-block">Koridor 5</button></a>
                    </div>
                    <div class="col-6 col-md-4 p-3 text-center">
                        <a href="bandros"><button class="btn btn-lg btn-primary btn-block">Bandros</button></a>
                    </div>
                    <div class="col-12 p-3 text-center">
                        <a href="pegawai-administrasi"><button class="btn btn-lg btn-primary btn-block">Pegawai Administrasi</button></a>
                    </div>
                </div>
            </div>
            <div class="card-footer mt-5">
                <div class="row">
                    <div class="col text-start">
                        <a href="<?= $hostToRoot ?>admin/home"><button class="btn btn-primary"><i class="fas fa-arrow-left"></i> Kembali</button></a>
                    </div>
                    <div class="col text-end">
                        <a href="<?= $hostToRoot ?>admin/logout"><button class="btn btn-primary"><i class="fas fa-sign-out-alt"></i> Logout</button></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>



<?php require __DIR__ . '/../wp-layouts/footer.php' ?>