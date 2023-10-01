<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title; ?></title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        a {
            text-decoration: none;
        }

        .accordion-collapse:hover {
            background-color: #00ff33;
            color: #fff;
        }

        .btn-indent {
            margin: 3px;
            margin-bottom: 30px;
        }

        /* CSS untuk tampilan layar */
        @media screen {

            /* Atur tampilan elemen yang ingin Anda tampilkan di layar */
            .screen-only {
                display: block;
            }
        }

        /* CSS untuk cetak */
        @media print {

            /* Atur tampilan elemen yang ingin Anda sembunyikan saat mencetak */
            .screen-only {
                display: none;
            }
        }
    </style>
</head>

<div class="text-center mt-5">
    <img src="<?= $hostToRoot ?>wp-content/logo.png" alt="Logo" width="100" height="100">
    <br>
    <div class="p-2">
        <h1><?= $title; ?></h1>
        <p>PORTAL ABSENSI BLUD UPT ANGKUTAN KOTA BANDUNG</p>
    </div>
</div>

<body style="background-color: #E0E0E0">