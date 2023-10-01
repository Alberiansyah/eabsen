<?php
require __DIR__ . "/../connections/connections.php";

global $pdo;
$username = $_POST['username'];
$password = $_POST['password'];
$query = $pdo->prepare("SELECT * FROM users WHERE username = ?");
$query->execute([$username]);
$checkRow = $query->rowCount();
if ($checkRow === 1) {
    // Cari password di dalam database.
    $queryAssoc = $query->fetch(PDO::FETCH_OBJ);
    // Mencocokkan data.
    if (password_verify($password, $queryAssoc->password)) {
        $_SESSION['username'] = $queryAssoc->username;
        $_SESSION['nama'] = $queryAssoc->nama;
        header('Location: home');
        exit();
    } else {
        $_SESSION['gagal'] = ['status' => false, 'message' => 'Username/Password tidak sah.'];
        header('Location: index');
        exit();
    }
} else {
    $_SESSION['gagal'] = ['status' => false, 'message' => 'Username/Password tidak sah.'];
    header('Location: index');
    exit();
}
