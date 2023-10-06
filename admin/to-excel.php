<?php
require __DIR__ . "/../functions/functions.php";
require __DIR__ . '/../vendor/autoload.php';

$ambilBulan = isset($_GET['bulan']) ? $_GET['bulan'] : '';
$koridor = isset($_GET['koridor']) ? $_GET['koridor'] : '';

use Carbon\Carbon;

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

// Mengatur lokasi ke Bahasa Indonesia
Carbon::setLocale('id');

$today = Carbon::now('Asia/Jakarta')->toDateString();
$getYear = Carbon::parse($today)->translatedFormat('Y');
// Mendefinisikan tanggal awal
$tanggalAwal = Carbon::create($getYear, 1, 1);

$dataBulan = [];

for ($i = 0; $i < 12; $i++) {
    // Menambahkan bulan ke dalam array
    $dataBulan[] = $tanggalAwal->copy()->addMonths($i)->translatedFormat('F');
}

$dataKoridor = ["Koridor 1", "Koridor 2", "Koridor 3", "Koridor 4", "Koridor 5", "Bandros", 'Pegawai Administrasi'];
$bulanValid = in_array($ambilBulan, $dataBulan);
$koridorValid = in_array($koridor, $dataKoridor);
if (!$bulanValid) {
    header($_SERVER["SERVER_PROTOCOL"] . " 404 Not Found", true, 404);
    require __DIR__ . "/../wp-layouts/404-page.php";
    exit;
}
if (!$koridorValid) {
    header($_SERVER["SERVER_PROTOCOL"] . " 404 Not Found", true, 404);
    require __DIR__ . "/../wp-layouts/404-page.php";
    exit;
}

// Inisialisasi array untuk menyimpan data berdasarkan bulan
$dataPerBulan = [];
$dataPerBulanNama = [];

// Loop untuk menghasilkan tanggal dan bulan
while ($tanggalAwal->year <= Carbon::now()->year) {
    $tanggalString = $tanggalAwal->translatedFormat('d F Y');
    $tanggalStringNama = $tanggalAwal->isoFormat('dddd');
    $bulan = $tanggalAwal->translatedFormat('F'); // Mendapatkan nama bulan

    // Menambahkan tanggal ke array yang sesuai dengan bulannya
    $dataPerBulan[$bulan][] = $tanggalString;
    $dataPerBulanNama[$bulan][] = $tanggalStringNama;

    $tanggalAwal->addDay(); // Menambahkan 1 hari ke tanggal
}

$no = 1;
$noTabel = 1;
$query = tampilData("SELECT karyawan.*, absen.*
                        FROM karyawan
                        INNER JOIN absen ON absen.id_karyawan = karyawan.id_karyawan
                        AND karyawan.kategori = '$koridor'
                     ");

if (!$query) {
    header($_SERVER["SERVER_PROTOCOL"] . " 404 Not Found", true, 404);
    require __DIR__ . "/data-kosong.php";
    exit;
}

$dataPerRow = [];

foreach ($query as $data) {
    // Membuat key unik untuk setiap karyawan
    $key = $data->id_karyawan;

    // Mengecek apakah key sudah ada dalam array dataPerRow
    if (!isset($dataPerRow[$key])) {
        // Jika belum, inisialisasi data per baris untuk karyawan ini
        $dataPerRow[$key] = [
            'no' => $no++,
            'nama' => $data->nama,
            'absen_pagi' => [],
            'absen_sore' => [],
            'izin' => [],
            'sakit' => [],
        ];
    }

    // Menambahkan tanggal absen pada array data per baris
    $tanggalAbsenPagi = Carbon::parse($data->absen_pagi)->translatedFormat('d F Y');
    $tanggalAbsenSore = Carbon::parse($data->absen_sore)->translatedFormat('d F Y');
    // Mengecek keterangan absen
    if ($data->keterangan === 'Izin') {
        // Jika keterangan adalah Izin, tambahkan tanggal ke dalam array izin
        $dataPerRow[$key]['izin'][$tanggalAbsenPagi] = $tanggalAbsenPagi;
        $dataPerRow[$key]['izin'][$tanggalAbsenSore] = $tanggalAbsenSore;
    } elseif ($data->keterangan === 'Sakit') {
        // Jika keterangan adalah Sakit, tambahkan tanggal ke dalam array sakit
        $dataPerRow[$key]['sakit'][$tanggalAbsenPagi] = $tanggalAbsenPagi;
        $dataPerRow[$key]['sakit'][$tanggalAbsenSore] = $tanggalAbsenSore;
    } else {
        // Jika keterangan bukan Izin atau Sakit, tambahkan tanggal ke dalam array tanggal_absen
        $dataPerRow[$key]['absen_pagi'][$tanggalAbsenPagi] = Carbon::parse($data->absen_pagi)->translatedFormat('H:i');
        $dataPerRow[$key]['absen_sore'][$tanggalAbsenPagi] = Carbon::parse($data->absen_sore)->translatedFormat('H:i');
    }
}
// Buat objek spreadsheet
$spreadsheet = new Spreadsheet();

// Buat worksheet
$worksheet = $spreadsheet->getActiveSheet();
$spreadsheet->getDefaultStyle()
    ->getFont()
    ->setName('Arial')
    ->setSize(10);

$spreadsheet->getActiveSheet()
    ->setCellValue('B3', 'No');
$spreadsheet->getActiveSheet()
    ->setCellValue('C3', 'Nama');
$spreadsheet->getActiveSheet()
    ->setCellValue('D6', 'IN');
$spreadsheet->getActiveSheet()
    ->setCellValue('E6', 'OUT');

$spreadsheet->getActiveSheet()->mergeCells("B3:B6");
$spreadsheet->getActiveSheet()->mergeCells("C3:C6");
$spreadsheet->getActiveSheet()->getStyle('B3')->getFont()->setSize(14);
$spreadsheet->getActiveSheet()->getStyle('C3')->getFont()->setSize(14);
$spreadsheet->getActiveSheet()->getStyle('B3')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER)->setVertical(Alignment::VERTICAL_CENTER);
$spreadsheet->getActiveSheet()->getStyle('C3')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER)->setVertical(Alignment::VERTICAL_CENTER);
$spreadsheet->getActiveSheet()->getStyle('D6')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
$spreadsheet->getActiveSheet()->getStyle('E6')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
// Sekarang $lastColumnHead akan berisi posisi terakhir sel setelah pengulangan selesai

$rowIndex = 7; // Indeks baris mulai dari 7
foreach ($dataPerRow as $row) {
    $worksheet->setCellValue('B' . $rowIndex, $noTabel++); // Mengisi tanggal pada kolom D
    $worksheet->setCellValue('C' . $rowIndex, $row['nama']); // Mengisi tanggal pada kolom D
    $worksheet->getColumnDimension('B')->setAutoSize(true);
    $worksheet->getColumnDimension('C')->setAutoSize(true);
    $worksheet->getStyle('B')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER)->setVertical(Alignment::VERTICAL_CENTER);
    $rowIndex++; // Pindah ke baris berikutnya
}
$columnIndexBulan = 'D'; // Indeks kolom mulai dari D
$rowDBulan = 4; // Indeks baris mulai dari 4

foreach ($dataPerBulan as $bulan => $tanggal) {
    if ($bulan === $ambilBulan) {
        foreach ($tanggal as $tgl) {
            $originalColumnIndexBulan = $columnIndexBulan;
            $mergeRange = $columnIndexBulan . $rowDBulan . ":" . ++$columnIndexBulan . $rowDBulan; // Menentukan rentang sel yang akan digabung

            // Menggabungkan sel
            $worksheet->mergeCells($mergeRange);

            // Mengatur nilai dalam sel
            $worksheet->setCellValue($originalColumnIndexBulan . $rowDBulan, $tgl);
            $worksheet->getColumnDimension($originalColumnIndexBulan)->setAutoSize(false);


            $spreadsheet->getActiveSheet()->getStyle($originalColumnIndexBulan)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER)->setVertical(Alignment::VERTICAL_CENTER);
            $columnIndexBulan++; // Pindah ke kolom berikutnya untuk menggabungkan dan mengisi data
        }
    }
}


$columnIndexHari = 'D'; // Indeks kolom mulai dari D
$rowD = 5; // Indeks baris mulai dari 4
foreach ($dataPerBulanNama as $bulan => $tanggal) {
    if ($bulan === $ambilBulan) {
        foreach ($tanggal as $tgl) {
            $originalColumnIndexHari = $columnIndexHari;
            $mergeRange = $columnIndexHari . $rowD . ":" . ++$columnIndexHari . $rowD; // Menentukan rentang sel yang akan digabung

            // Menggabungkan sel
            $worksheet->mergeCells($mergeRange);

            // Mengatur nilai dalam sel
            $worksheet->setCellValue($originalColumnIndexHari . $rowD, $tgl);
            $worksheet->getColumnDimension($originalColumnIndexHari)->setAutoSize(false);


            $spreadsheet->getActiveSheet()->getStyle($originalColumnIndexHari)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER)->setVertical(Alignment::VERTICAL_CENTER);
            $columnIndexHari++; // Pindah ke kolom berikutnya untuk menggabungkan dan mengisi data
        }
    }
}

$columnIn = 'D'; // Indeks kolom D
$rowIn = 6; // Indeks baris mulai dari 6

foreach ($dataPerBulan as $bulan => $tanggal) {
    if ($bulan === $ambilBulan) {
        foreach ($tanggal as $tgl) {
            $worksheet->setCellValue($columnIn . $rowIn, 'IN');
            $spreadsheet->getActiveSheet()->getStyle($columnIn)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER)->setVertical(Alignment::VERTICAL_CENTER);
            ++$columnIn;
            $columnIn++;
        }
    }
}

$columnOut = 'E'; // Indeks kolom E
$rowOut = 6; // Indeks baris mulai dari 6

foreach ($dataPerBulan as $bulan => $tanggal) {
    if ($bulan === $ambilBulan) {
        foreach ($tanggal as $tgl) {
            $worksheet->setCellValue($columnOut . $rowOut, 'OUT');
            $spreadsheet->getActiveSheet()->getStyle($columnOut)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER)->setVertical(Alignment::VERTICAL_CENTER);
            ++$columnOut;
            $columnOut++;
        }
    }
}
$columnOut = 'D'; // Indeks kolom D
$rowOut = 7; // Indeks baris mulai dari 7

foreach ($dataPerRow as $row) {
    $columnOut = 'D'; // Set ulang nilai awal kolom setiap kali iterasi baris karyawan

    foreach ($dataPerBulan[$ambilBulan] as $tgl) {
        $tempcolumnOut = $columnOut;
        if (isset($row['izin'][$tgl])) {
            $worksheet->setCellValue($columnOut . $rowOut, 'Izin');
            $style = $worksheet->getStyle($columnOut . $rowOut);
            $font = $style->getFont();
            $font->getColor()->setRGB('0000FF'); // Warna biru
            $columnOut++;
        } elseif (isset($row['sakit'][$tgl])) {
            $worksheet->setCellValue($columnOut . $rowOut, 'Sakit');
            $style = $worksheet->getStyle($columnOut . $rowOut);
            $font = $style->getFont();
            $font->getColor()->setRGB('FFA500'); // Warna merah
            $columnOut++;
        } elseif (isset($row['absen_pagi'][$tgl])) {
            $worksheet->setCellValue($columnOut . $rowOut, $row['absen_pagi'][$tgl]);
            $columnOut++;
        } else {
            $worksheet->setCellValue($columnOut . $rowOut, '');
            $columnOut++;
        }

        if (isset($row['izin'][$tgl])) {
            $worksheet->setCellValue($columnOut . $rowOut, 'Izin');
            $style = $worksheet->getStyle($columnOut . $rowOut);
            $font = $style->getFont();
            $font->getColor()->setRGB('0000FF'); // Warna biru
            $columnOut++;
        } elseif (isset($row['sakit'][$tgl])) {
            $worksheet->setCellValue($columnOut . $rowOut, 'Sakit');
            $style = $worksheet->getStyle($columnOut . $rowOut);
            $font = $style->getFont();
            $font->getColor()->setRGB('FFA500'); // Warna merah
            $columnOut++;
        } elseif (isset($row['absen_sore'][$tgl])) {
            $worksheet->setCellValue($columnOut . $rowOut, $row['absen_sore'][$tgl]);
            $columnOut++;
        } else {
            $worksheet->setCellValue($columnOut . $rowOut, '');
            $columnOut++;
        }
    }
    // Pindah ke baris berikutnya
    $rowOut++;
}


// Menentukan baris awal untuk data
$worksheet->getStyle('B3:' . ++$tempcolumnOut . ($rowOut - 1))->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);

$spreadsheet->getActiveSheet()
    ->setCellValue('D3', 'Tanggal');
$mergeCek = 'D3' . ":" . $tempcolumnOut . "3";
$worksheet->mergeCells($mergeCek);
$spreadsheet->getActiveSheet()->getStyle('D3')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER)->setVertical(Alignment::VERTICAL_CENTER);

$writer = new Xlsx($spreadsheet);
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="Rekap Data Bulan ' . $ambilBulan . '.xlsx"');
// $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
$writer->save('php://output');
