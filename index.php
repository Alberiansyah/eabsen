<?php
require __DIR__ . "/connections/connections.php";
require __DIR__ . "/functions/has-login.php";
date_default_timezone_set('Asia/Jakarta');
$waktuSekarang = date('H:i');
$jamSekarang = (int)explode(':', $waktuSekarang)[0];
$menitSekarang = (int)explode(':', $waktuSekarang)[1];
// Waktu absensi pagi: 06:00 - 09:00
$pagiMulai = 6;
$pagiBerakhir = 9;

// Waktu absensi sore: 16:30 - 18:00
$soreMulai = 11;
$soreBerakhir = 18;

?>
<?php require __DIR__ . '/wp-layouts/header.php' ?>
<div class="container d-flex flex-column justify-content-center align-items-center" style="height: 30vh;">
    <div class="d-flex justify-content-center p-5 mt-5">
        <h2>Selamat Datang</h2>
    </div>
    <div class="d-flex justify-content-center">
        <?php if (($jamSekarang >= $pagiMulai && $jamSekarang < $pagiBerakhir && !($jamSekarang == $pagiBerakhir && $menitSekarang >= 0 && $menitSekarang <= 30)) || ($jamSekarang >= $soreMulai && $jamSekarang < $soreBerakhir && !($jamSekarang == $soreBerakhir && $menitSekarang >= 0 && $menitSekarang <= 30))) : ?>
            <a href="karyawan/koridor"><button class="btn btn-lg btn-primary m-3 mx-5"><i class="fas fa-users"></i> Karyawan</button></a>
            <a href="admin/index"><button class="btn btn-lg btn-primary m-3 mx-5"><i class="fa fa-user"></i> Admin</button></a>
        <?php else : ?>
            <a href="cek-waktu"><button class="btn btn-lg btn-primary m-3 mx-5"><i class="fas fa-users"></i> Karyawan</button></a>
            <a href="admin/index"><button class="btn btn-lg btn-primary m-3 mx-5"><i class="fa fa-user"></i> Admin</button></a>
        <?php endif; ?>
    </div>
</div>

<?php require __DIR__ . '/wp-layouts/footer.php' ?>

</body>

</html>