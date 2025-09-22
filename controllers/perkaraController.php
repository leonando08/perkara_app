<?php
include_once("../config/database.php");
include_once("../models/Perkara.php");

$perkaraModel = new Perkara($conn);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['tambah'])) {
        $perkaraModel->add($_POST);
        header("Location: dashboard.php");
    }

    if (isset($_POST['edit'])) {
        $perkaraModel->update($_POST['id'], $_POST);
        header("Location: dashboard.php");
    }
}

if (isset($_GET['hapus'])) {
    $perkaraModel->delete($_GET['hapus']);
    header("Location: dashboard.php");
}
