<?php
if (isset($_SESSION['username'])) {
    header("Location: " . $hostToRoot . "admin/home");
    exit;
}
