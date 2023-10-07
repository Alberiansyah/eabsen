<?php
require __DIR__ . "/../functions/functions.php";
require __DIR__ . "/../functions/has-login.php";
require __DIR__ . '/../vendor/autoload.php';

use Carbon\Carbon;

$carbon = Carbon::now('Asia/Jakarta');
$waktuSekarang = $carbon->format('H:i');

$jamSekarang = (int)explode(':', $waktuSekarang)[0];
$menitSekarang = (int)explode(':', $waktuSekarang)[1];
// Waktu absensi pagi: 06:00 - 09:00
$pagiMulai = 6;
$pagiBerakhir = 9;

// Waktu absensi sore: 16:30 - 18:00
$soreMulai = 16;
$soreBerakhir = 18;

if (($jamSekarang >= $pagiMulai && $jamSekarang < $pagiBerakhir && !($jamSekarang == $pagiBerakhir && $menitSekarang >= 0 && $menitSekarang <= 30)) || ($jamSekarang >= $soreMulai && $jamSekarang < $soreBerakhir && !($jamSekarang == $soreBerakhir && $menitSekarang >= 0 && $menitSekarang <= 30))) {
} else {
    header('Location: ../index');
    exit;
}
?>
<?php require __DIR__ . '/../wp-layouts/header.php' ?>
<div class="container d-flex justify-content-center mt-5">
    <div class="col-6">
        <div class="row">
            <div class="accordion accordion-flush" id="accordionFlushExample">
                <div class="accordion-item">
                    <h2 class="accordion-header">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseOne" aria-expanded="false" aria-controls="flush-collapseOne">
                            Pilih Nomor Koridor
                        </button>
                    </h2>
                    <div id="flush-collapseOne" class="accordion-collapse collapse" data-bs-parent="#accordionFlushExample">
                        <a href="subkoridor-1">
                            <div class="accordion-body rounded-0 text-center">
                                Koridor 1 (Cibiru - Cibereum)
                            </div>
                        </a>
                    </div>
                    <div id="flush-collapseOne" class="accordion-collapse collapse" data-bs-parent="#accordionFlushExample">
                        <a href="subkoridor-2">
                            <div class="accordion-body rounded-0 text-center">
                                Koridor 2 (Cibereum - Cicaheum)
                            </div>
                        </a>
                    </div>
                    <div id="flush-collapseOne" class="accordion-collapse collapse" data-bs-parent="#accordionFlushExample">
                        <a href="subkoridor-3">
                            <div class="accordion-body rounded-0 text-center">
                                Koridor 3 (Cicaheum - Sarijadi)
                            </div>
                        </a>
                    </div>
                    <div id="flush-collapseOne" class="accordion-collapse collapse" data-bs-parent="#accordionFlushExample">
                        <a href="subkoridor-4">
                            <div class="accordion-body rounded-0 text-center">
                                Koridor 4 (Leuwipanjang - Antapani)
                            </div>
                        </a>
                    </div>
                    <div id="flush-collapseOne" class="accordion-collapse collapse" data-bs-parent="#accordionFlushExample">
                        <a href="subkoridor-5">
                            <div class="accordion-body rounded-0 text-center">
                                Koridor 5 (ST Hall Antapani)
                            </div>
                        </a>
                    </div>
                    <div id="flush-collapseOne" class="accordion-collapse collapse" data-bs-parent="#accordionFlushExample">
                        <a href="bandros">
                            <div class="accordion-body rounded-0 text-center">
                                Bandros
                            </div>
                        </a>
                    </div>
                    <div id="flush-collapseOne" class="accordion-collapse collapse" data-bs-parent="#accordionFlushExample">
                        <a href="pegawai-administrasi">
                            <div class="accordion-body rounded-0 text-center">
                                Pegawai Administrasi
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php require __DIR__ . '/../wp-layouts/footer.php' ?>