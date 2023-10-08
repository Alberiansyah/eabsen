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

$query = tampilData("SELECT * FROM karyawan WHERE kategori = 'Koridor 6'");
?>
<?php require __DIR__ . '/../wp-layouts/header.php' ?>

<div class="container mb-5">
    <div class="row d-flex justify-content-center">
        <div class="col-xl-8 col-lg-8 col-md-12 col-sm-12">
            <div class="card">
                <form method="POST" action="<?= $hostToRoot ?>functions/tambah-absen" enctype="multipart/form-data">
                    <div class="card-body">
                        <h5 id="waktu" class="text-center"></h5>
                        <div class="row">
                            <div class="col-xl-6">
                                <div class="form-group mt-3">
                                    <label for="id_karyawan" class="form-label">Nama</label>
                                    <select name="id_karyawan" id="id_karyawan" class="form-control" required>
                                        <option value="">-- Pilih Nama --</option>
                                        <?php foreach ($query as $data) : ?>
                                            <option value="<?= $data->id_karyawan ?>"><?= $data->nama ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="form-group mt-3">
                                    <label for="foto" class="form-label">Foto</label>
                                    <input type="file" name="foto" id="foto" class="form-control" accept="image/*" capture="camera" required>
                                </div>
                            </div>
                            <div class="col-xl-6">
                                <div class="form-group mt-3">
                                    <label for="jabatan" class="form-label">Jabatan</label>
                                    <select name="jabatan" id="jabatan" class="form-control" required readonly>
                                        <?php foreach ($query as $data) : ?>
                                            <option value="<?= $data->jabatan ?>" class="<?= $data->id_karyawan ?>"><?= $data->jabatan ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="form-group mt-3">
                                    <label for="keterangan" class="form-label">Keterangan</label>
                                    <select name="keterangan" id="keterangan" class="form-control" required>
                                        <option value="">-- Pilih Keterangan --</option>
                                        <option value="Hadir">Hadir</option>
                                        <option value="Izin">Izin</option>
                                        <option value="Sakit">Sakit</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group mt-3">
                                <label for="alasan" class="form-label">Alasan</label>
                                <textarea name="alasan" id="alasan" class="form-control" placeholder="Isi alasan untuk izin. (Hadir, dan sakit opsional)"></textarea>
                            </div>
                            <div class="form-group mt-3">
                                <input type="hidden" name="alamat" id="alamat" class="form-control">
                                <label for="preview" class="form-label">Lokasi</label>
                                <textarea name="preview" id="preview" class="form-control" placeholder="Ambil foto untuk mengambil lokasi" disabled></textarea>
                            </div>
                            <div class="form-group mt-3 text-center">
                                <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Simpan</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<?php require __DIR__ . '/../wp-layouts/footer.php' ?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-chained/1.0.1/jquery.chained.min.js"></script>
<script type="text/javascript">
    $(document).ready(function() {
        $("#jabatan").chained("#id_karyawan");
        $("#nama").on("change", function() {
            var selectedName = $(this).val(); // Dapatkan nama yang dipilih
            // Pilih otomatis jabatan yang sesuai dengan nama yang dipilih
            $("#jabatan option").prop("selected", false); // Reset pilihan jabatan
            $("#jabatan option." + selectedName).prop("selected", true); // Pilih jabatan sesuai nama
            $("#jabatan").trigger("change"); // Trigger event change pada dropdown "Jabatan"
        });
    });
</script>
<script>
    function updateDateTime() {
        var waktuElement = $('#waktu');
        var currentTime = '<?php echo date('Y-m-d'); ?>';

        var days = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
        var day = days[new Date(currentTime).getDay()];

        var date = new Date(currentTime).getDate();

        var months = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
        var month = months[new Date(currentTime).getMonth()];

        var year = new Date(currentTime).getFullYear();

        var hours = new Date().getHours();
        var minutes = new Date().getMinutes();
        var seconds = new Date().getSeconds();

        var formattedTime = day + ', ' + date + ' ' + month + ' ' + year + ' ' + hours + ':' + (minutes < 10 ? '0' : '') + minutes + ':' + (seconds < 10 ? '0' : '') + seconds;

        waktuElement.html('Selamat Datang! Silahkan Isi Kehadiran ' + formattedTime);
    }

    setInterval(updateDateTime, 1000);
</script>
<script>
    function getCurrentLocation() {
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(showPosition);
        } else {
            console.log("Geolocation is not supported by this browser.");
        }
    }

    function showPosition(position) {
        var latitude = position.coords.latitude;
        var longitude = position.coords.longitude;

        var locationInput = $("#alamat");
        var preview = $("#preview");
        preview.val("Mengambil nama lokasi...");

        var url = "https://nominatim.openstreetmap.org/reverse?format=jsonv2&lat=" + latitude + "&lon=" + longitude;

        $.ajax({
            url: url,
            type: "GET",
            success: function(response) {
                var address = response.display_name;
                locationInput.val(address);
                preview.val(address);
            },
            error: function() {
                console.log("Failed to retrieve location information.");
            }
        });
    }

    $("#foto").on("change", function() {
        getCurrentLocation();
    });

    // Bebas pilih aja

    // function getCurrentLocation() {
    //     $.ajax({
    //         url: "https://ipapi.co/json/",
    //         type: "GET",
    //         success: function(response) {
    //             var city = response.city;
    //             var region = response.region;
    //             var country = response.country_name;

    //             var locationInput = $("#lokasi");
    //             locationInput.val(city + ", " + region + ", " + country);
    //         },
    //         error: function() {
    //             console.log("Failed to retrieve location information.");
    //         }
    //     });
    // }
</script>

</body>

</html>