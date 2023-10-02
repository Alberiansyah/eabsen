<?php

require __DIR__ . '/../functions/functions.php';
require __DIR__ . '/../vendor/autoload.php';

use Carbon\Carbon;

$carbon = Carbon::now('Asia/Jakarta');


function upload($post)
{
    $namaFile = $_FILES['foto']['name'];
    $ukuranFile = $_FILES['foto']['size'];
    $error = $_FILES['foto']['error'];
    $tmpName = $_FILES['foto']['tmp_name'];

    if ($error === 4) {
        $_SESSION['berhasil'] = ['type' => false, 'message' => 'Gagal menambahkan GIF/Image ' . '<b>' . $namaFile . '</b>'];
        return false;
    }

    $ekstensiGambarValid = ['jpg', 'jpeg', 'png', 'gif'];
    $ekstensiGambar = explode('.', $namaFile);
    $ekstensiGambar = strtolower(end($ekstensiGambar));
    if (!in_array($ekstensiGambar, $ekstensiGambarValid)) {
        $_SESSION['berhasil'] = ['type' => false, 'message' => 'File yang anda upload bukan GIF/Image'];
        return false;
    }

    if ($ukuranFile > 10485760) {
        $_SESSION['berhasil'] = ['type' => false, 'message' => 'Ukuran gambar terlalu besar, minimal size <b>10 MB</b>'];
        return false;
    }

    $namaFileBaru = hash('sha256', date('Y:m:d H:i:s')) . '_' . date('Y_m_d_') . $post['id_karyawan'] . '.' . $ekstensiGambar;
    move_uploaded_file($tmpName, '../wp-content/img-absen/' . $namaFileBaru);
    return $namaFileBaru;
}


function editAbsen($request)
{
    global $pdo, $alasan, $alasanCek, $absenSore, $id_karyawan;
    $pembatas = ['```'];
    $alasanFinal = $alasanCek . '' . implode("", $pembatas) . '' . $alasan;
    $query = $pdo->prepare($request);
    $query->execute([$alasanFinal, $absenSore, $id_karyawan]);

    return $query;
}

$waktuHariIni = $carbon->format('Y-m-d');
$id_karyawan = htmlspecialchars($_POST['id_karyawan']);
$foto = upload($_POST);
// $jabatan = htmlspecialchars($_POST['jabatan']);
$keterangan = htmlspecialchars($_POST['keterangan']);
$alasan = htmlspecialchars($_POST['alasan']) ? htmlspecialchars($_POST['alasan']) : null;
$alamat = $_POST['alamat'];

date_default_timezone_set('Asia/Jakarta');
$waktuSekarang = date('H:i');
$jamSekarang = (int)explode(':', $waktuSekarang)[0];
$menitSekarang = (int)explode(':', $waktuSekarang)[1];
// Waktu absensi pagi: 06:00 - 09:00
$pagiMulai = 6;
$pagiBerakhir = 9;

// Waktu absensi sore: 16:30 - 18:00
$soreMulai = 16;
$soreBerakhir = 18;

if (($jamSekarang >= $pagiMulai && $jamSekarang < $pagiBerakhir) || ($jamSekarang == $pagiBerakhir && $menitSekarang <= 30)) {
    $absenPagiCek = $carbon->format('Y-m-d H:i:s');
} elseif (($jamSekarang >= $soreMulai && $jamSekarang < $soreBerakhir) || ($jamSekarang == $soreBerakhir && $menitSekarang <= 30)) {
    $absenSoreCek = $carbon->format('Y-m-d H:i:s');
}

$absenPagi = isset($absenPagiCek) ? $absenPagiCek : null;
$absenSore = isset($absenSoreCek) ? $absenSoreCek : null;

$queryEdit = tampilDataFirst("SELECT karyawan.*, absen.*
                        FROM karyawan
                        INNER JOIN absen ON absen.id_karyawan = karyawan.id_karyawan
                        WHERE karyawan.id_karyawan = '$id_karyawan'
                        AND absen.absen_pagi IS NOT NULL 
                        AND (DATE(absen.absen_pagi) = '$waktuHariIni' OR DATE(absen.absen_sore) = '$waktuHariIni')
");

if ($queryEdit) {
    $alasanCek = $queryEdit->alasan;
    $query = editAbsen("UPDATE absen SET
                        alasan = ?,
                        absen_sore = ?
                        WHERE id_karyawan = ?
            ");
    header('Location: ../karyawan/berhasil');
} else {

    $query = $pdo->prepare("INSERT INTO absen (id_karyawan, foto, keterangan, alasan, alamat, absen_pagi, absen_sore) VALUE(?, ?, ?, ?, ?, ?, ?)");
    $query->execute([$id_karyawan, $foto, $keterangan, $alasan, $alamat, $absenPagi, $absenSore]);
    header('Location: ../karyawan/berhasil');
}
