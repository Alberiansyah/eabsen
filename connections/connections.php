<?php
$host = "localhost";
$dbname = "eabsen";
$user   = "root";
$pass   = "";

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
} catch (PDOException $e) {
    echo $e->getMessage();
}

$hostToRoot = 'http://localhost/eabsen/';
$title = 'ABSENSI BLUD UPT ANGKUTAN KOTA BANDUNG';
$version = 'git ad1.0 ';

session_start();
