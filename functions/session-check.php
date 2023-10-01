<?php
// Check session
if (!isset($_SESSION['username']) && !isset($_SESSION['nama'])) {
    $containUrl = urlencode((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]");
    header("Location: " . $hostToRoot . "index");
    die;
}
