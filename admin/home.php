<?php
require __DIR__ . "/../functions/functions.php";
require __DIR__ . "/../functions/session-check.php";

?>
<?php require __DIR__ . '/../wp-layouts/header.php' ?>
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-xl-10 col-lg-10 col-md-12 col-sm-12">
            <div class="card p-5" style="min-height: 300px;">
                <div class="row text-center">
                    <h2>Halo, <?= $_SESSION['nama'] ?> selamat datang kembali.</h2>
                </div>
                <div class="text-center position-absolute bottom-0 start-50 translate-middle-x mb-5">
                    <a href="rekap-data"><button class="btn btn-lg btn-primary m-3 mx-sm-5"><i class="fas fa-table"></i> Rekap Data</button></a>
                </div>
            </div>
            <div class="card-footer mt-5 mb-5">
                <div class="row">
                    <div class="col text-end">
                        <a href="<?= $hostToRoot ?>admin/logout"><button class="btn btn-primary"><i class="fas fa-sign-out-alt"></i> Logout</button></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<?php require __DIR__ . '/../wp-layouts/footer.php' ?>