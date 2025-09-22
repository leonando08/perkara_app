<?php
include_once("../config/database.php");
include_once("../models/Perkara.php");

$perkaraModel = new Perkara($conn);

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $perkaraModel->delete($id);
}

header("Location: dashboard_admin.php");
exit();
