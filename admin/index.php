<?php
require __DIR__ . "/../connections/connections.php";
// var_dump($_SESSION);
// exit;
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
?>
<?php require __DIR__ . '/../wp-layouts/header.php' ?>

<div class="container mt-5">
    <div class="row d-flex justify-content-center">
        <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12">
            <div class="card">
                <form method="POST" action="login">
                    <div class="card-body">
                        <h6 id="waktu" class="text-center">Selamat datang, silahkan isi data sesuai ketentuan.</h6>
                        <div class="row">
                            <div class="form-group mt-3">
                                <label for="username" class="form-label">Username</label>
                                <input type="text" id="username" name="username" class="form-control <?php if (isset($_SESSION['gagal']) && $_SESSION['gagal']['status'] === false) echo 'is-invalid'; ?>" placeholder="Masukkan username anda">
                            </div>
                            <div class="form-group mt-3">
                                <label for="password" class="form-label">Password</label>
                                <div class="input-group">
                                    <input type="password" id="password" name="password" class="form-control <?php if (isset($_SESSION['gagal']) && $_SESSION['gagal']['status'] === false) echo 'is-invalid'; ?>" placeholder="Masukkan password anda">
                                    <button type="button" id="showPassword" class="btn btn-secondary"><i class="fa fa-eye" id="show"></i></button>
                                </div>
                                <?php if (isset($_SESSION['gagal']) && $_SESSION['gagal']['status'] === false) : ?>
                                    <div class="invalid-feedback d-block">
                                        <?php echo $_SESSION['gagal']['message']; ?>
                                    </div>
                                    <?php unset($_SESSION['gagal']); ?>
                                <?php endif; ?>
                            </div>

                            <div class="form-group mt-3 text-center">
                                <button type="submit" class="btn btn-primary"><i class="fas fa-sign-in-alt"></i> Masuk</button>
                            </div>
                        </div>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>

<?php require __DIR__ . '/../wp-layouts/footer.php' ?>
<script>
    $(document).ready(function() {
        $('#showPassword').click(function() {
            const passwordInput = $('#password');
            const icon = $(this).find("#show");
            if (passwordInput.attr('type') === 'password') {
                passwordInput.attr('type', 'text');
                icon.removeClass('fa-eye').addClass('fa-eye-slash');
            } else {
                passwordInput.attr('type', 'password');
                icon.removeClass('fa-eye-slash').addClass('fa-eye');
            }
        });
    });
</script>
</body>

</html>