<?php
require __DIR__ . "/../functions/functions.php";
require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . "/../functions/session-check.php";

use Carbon\Carbon;

Carbon::setLocale('id');
$koridor = "Koridor 1";
$today = Carbon::now('Asia/Jakarta')->toDateString();
$getYear = Carbon::parse($today)->translatedFormat('Y');
// Mendefinisikan tanggal awal
$tanggalAwal = Carbon::create($getYear, 1, 1);

$dataBulan = [];

for ($i = 0; $i < 12; $i++) {
    // Menambahkan bulan ke dalam array
    $dataBulan[] = $tanggalAwal->copy()->addMonths($i)->translatedFormat('F');
}

$query = tampilData("SELECT karyawan.*, absen.*
                        FROM absen
                        INNER JOIN karyawan ON karyawan.id_karyawan = absen.id_karyawan 
                        WHERE (DATE(absen.absen_pagi) = '$today' OR DATE(absen.absen_sore) = '$today')
                        AND karyawan.kategori = '$koridor'
                        ");
$countQuery = count($query);
$no = 1;
?>
<?php require __DIR__ . '/../wp-layouts/header.php' ?>
<div class="container">
    <div class="row d-flex justify-content-center">
        <div class="col-xl-10 col-lg-10 col-md-12 col-sm-12">
            <div class="container">
                <div class="row">
                    <div class="card">
                        <div class="card-body d-flex justify-content-between align-items-center">
                            <span class="d-none" id="koridor"><?= $koridor ?></span>
                            <h5 class="card-title mb-4">Data rekap <?= $koridor ?>, <?= Carbon::parse($today)->isoFormat('dddd'); ?> <?= Carbon::parse($today)->translatedFormat('d F Y'); ?></h5>
                            <div class="d-flex">
                                <a href="cetak-subkoridor?koridor=<?= $koridor ?>" target="_blank" class="screen-only" title="Rekap PDF Per-hari"><button class="btn btn-sm btn-primary btn-indent"><i class="fas fa-file-pdf"></i></button></a>
                                <a href="excel-subkoridor?koridor=<?= $koridor ?>" target="_blank" class="screen-only" id="to-excel" title="Rekap Excel Per-hari"><button class="btn btn-sm btn-primary btn-indent"><i class="fas fa-file-excel"></i></button></a>
                                <a href="#" id="printButton" target="_blank" class="screen-only" title="Print"><button class="btn btn-sm btn-primary btn-indent"><i class="fa fa-print"></i></button></a>
                            </div>
                        </div>
                        <div class="container mb-3 screen-only">
                            <div class="row">
                                <div class="col-xl-3 col-lg-3 col-md-12 col-sm-12 mb-2">
                                    <div class="form-group">
                                        <select id="listBulan" class="form-control">
                                            <option value="">-- Pilih Bulan --</option>
                                            <?php foreach ($dataBulan as $data) : ?>
                                                <option value="<?= $data ?>"><?= $data ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-xl-3 col-lg-3 col-md-12 col-sm-12 mb-2">
                                    <div class="form-group">
                                        <a id="pilihBulan" disabled><button class="btn btn-xs btn-primary" disabled>Pilih</button></a>
                                    </div>
                                </div>
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
                                    </tr>
                                    <?php if ($countQuery < 1) : ?>
                                        <tr>
                                            <td colspan="4" style="text-align: center;">Belum terdapat data.</td>
                                        </tr>
                                    <?php endif; ?>
                                    <?php foreach ($query as $data) :
                                    ?>
                                        <tr>
                                            <td><?= $no++ ?></td>
                                            <td><?= $data->nama ?></td>
                                            <td><?= $data->absen_pagi !== null ? Carbon::parse($data->absen_pagi)->translatedFormat('d F Y H:i:s') : '' ?></td>
                                            <td><?= $data->absen_sore !== null ? Carbon::parse($data->absen_sore)->translatedFormat('d F Y H:i:s') : '' ?></td>
                                        </tr>
                                    <?php endforeach; ?>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer mt-5 mb-5">
                        <div class="row">
                            <div class="col text-start">
                                <a href="<?= $hostToRoot ?>admin/rekap-data" class="screen-only"><button class="btn btn-primary"><i class="fas fa-arrow-left"></i> Kembali</button></a>
                            </div>
                            <div class="col text-end">
                                <a href="<?= $hostToRoot ?>admin/logout" class="screen-only"><button class="btn btn-primary"><i class="fas fa-sign-out-alt"></i> Logout</button></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php require __DIR__ . '/../wp-layouts/footer.php' ?>
<script>
    $(document).ready(function() {
        $('#printButton').click(function() {
            window.print();
        });
    });

    let pilihBulan = $("#pilihBulan");
    let koridor = $("#koridor").text();
    $("#listBulan").on("change", function() {
        if ($(this).val() === '') {
            pilihBulan.find("button").prop("disabled", true);
            pilihBulan.prop("target", "_blank").removeAttr("href", "href");
        } else {
            pilihBulan.find("button").prop("disabled", false);
            pilihBulan.prop("target", "_blank").prop("href", "to-excel?bulan=" + $(this).val() + "&koridor=" + koridor);
        }
    });
</script>
</body>

</html>