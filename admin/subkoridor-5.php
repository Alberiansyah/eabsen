<?php
require __DIR__ . "/../functions/functions.php";
require __DIR__ . '/../vendor/autoload.php';

use Carbon\Carbon;

Carbon::setLocale('id');
$today = Carbon::now('Asia/Jakarta')->toDateString();
$query = tampilData("SELECT karyawan.*, absen.*
                     FROM karyawan
                     INNER JOIN absen ON absen.id_karyawan = karyawan.id_karyawan
                     WHERE DATE(absen.absen_pagi) = '$today' OR DATE(absen.absen_sore) = '$today'");
$no = 1;
?>
<?php require __DIR__ . '/../wp-layouts/header.php' ?>

<div class="container">
    <div class="row d-flex justify-content-center">
        <div class="col-xl-10 col-lg-10 col-md-12 col-sm-12">
            <div class="row">
                <div class="card">
                    <div class="card-body d-flex justify-content-between align-items-center">
                        <h5 class="card-title mb-4">Data Koridor 1</h5>
                        <div class="d-flex">
                            <button class="btn btn-sm btn-primary btn-indent"><i class="fas fa-file-pdf"></i></button>
                            <button class="btn btn-sm btn-primary btn-indent"><i class="fas fa-file-excel"></i></button>
                            <button class="btn btn-sm btn-primary btn-indent"><i class="fa fa-print"></i></button>
                        </div>
                    </div>
                    <div class="container mb-3">
                        <div class="table-responsive"> <!-- Tambahkan class table-responsive pada div ini -->
                            <table class="table table-bordered table-hover">
                                <tr>
                                    <th>No</th>
                                    <th>Nama</th>
                                    <th>Pagi</th>
                                    <th>Sore</th>
                                    <th>Jumlah Kehadiran</th>
                                </tr>
                                <?php foreach ($query as $data) :
                                ?>
                                    <tr>
                                        <td><?= $no++ ?></td>
                                        <td><?= $data->nama ?></td>
                                        <td><?= $data->absen_pagi !== null ? Carbon::parse($data->absen_pagi)->translatedFormat('j F Y H:i:s') : '' ?></td>
                                        <td><?= $data->absen_sore !== null ? Carbon::parse($data->absen_sore)->translatedFormat('j F Y H:i:s') : '' ?></td>
                                        <?php
                                        $counter = 0;
                                        if ($data->absen_pagi !== null) {
                                            $counter++;
                                        }
                                        if ($data->absen_sore !== null) {
                                            $counter++;
                                        }
                                        ?>
                                        <td><?= $counter ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </table>
                        </div>
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

</body>

</html>