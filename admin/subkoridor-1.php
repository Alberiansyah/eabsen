<?php
require __DIR__ . "/../functions/functions.php";
require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . "/../functions/session-check.php";

use Carbon\Carbon;

Carbon::setLocale('id');
$today = Carbon::now('Asia/Jakarta')->toDateString();
// $query = tampilData("SELECT karyawan.*, absen.*
// FROM karyawan
// INNER JOIN absen ON absen.id_karyawan = karyawan.id_karyawan
// WHERE DATE(absen.absen_pagi) = '$today' OR DATE(absen.absen_sore) = '$today'
// AND karyawan.kategori = 'Koridor 1'
//                      ");
$query = tampilData("SELECT karyawan.*, absen.*
                     FROM karyawan
                     INNER JOIN absen ON absen.id_karyawan = karyawan.id_karyawan
                     WHERE DATE(absen.absen_pagi) = '$today' OR DATE(absen.absen_sore) = '$today'");
$countQuery = count($query);
$no = 1;
?>
<?php require __DIR__ . '/../wp-layouts/header.php' ?>

<div class="container">
    <div class="row d-flex justify-content-center">
        <div class="col-xl-10 col-lg-10 col-md-12 col-sm-12">
            <div class="row">
                <div class="card">
                    <div class="card-body d-flex justify-content-between align-items-center">
                        <h5 class="card-title mb-4">Data rekap Koridor 1, <?= Carbon::parse($today)->isoFormat('dddd'); ?> <?= Carbon::parse($today)->translatedFormat('d F Y'); ?></h5>
                        <div class="d-flex">
                            <a href="cetak-subkoridor-1" target="_blank" class="screen-only" title="Rekap PDF Per-hari"><button class="btn btn-sm btn-primary btn-indent"><i class="fas fa-file-pdf"></i></button></a>
                            <a href="excel-subkoridor-1" target="_blank" class="screen-only" id="to-excel" title="Rekap Excel Per-hari"><button class="btn btn-sm btn-primary btn-indent"><i class="fas fa-file-excel"></i></button></a>
                            <a href="to-excel?bulan=<?= Carbon::parse($today)->translatedFormat('F') ?>" target="_blank" class="screen-only" title="Rekap Excel Per-bulan"><button class="btn btn-sm btn-primary btn-indent"><i class="fas fa-file-excel"></i></button></a>
                            <a href="#" id="printButton" target="_blank" class="screen-only" title="Print"><button class="btn btn-sm btn-primary btn-indent"><i class="fa fa-print"></i></button></a>
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
                                <?php if ($countQuery < 1) : ?>
                                    <tr>
                                        <td colspan="5" style="text-align: center;">Belum terdapat data.</td>
                                    </tr>
                                <?php endif; ?>
                                <?php foreach ($query as $data) :
                                ?>
                                    <tr>
                                        <td><?= $no++ ?></td>
                                        <td><?= $data->nama ?></td>
                                        <td><?= $data->absen_pagi !== null ? Carbon::parse($data->absen_pagi)->translatedFormat('d F Y H:i:s') : '' ?></td>
                                        <td><?= $data->absen_sore !== null ? Carbon::parse($data->absen_sore)->translatedFormat('d F Y H:i:s') : '' ?></td>
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
        <div class="text-end m-5 screen-only">
            <a href="<?= $hostToRoot ?>admin/logout"><button class="btn btn-primary"><i class="fas fa-sign-out-alt"></i> Logout</button></a>
        </div>
    </div>
</div>

<?php require __DIR__ . '/../wp-layouts/footer.php' ?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.17.4/xlsx.full.min.js"></script>
<script>
    $(document).ready(function() {
        $('#printButton').click(function() {
            window.print();
        });
    });
</script>
</body>

</html>