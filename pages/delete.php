<?php
include '../config/db.php';
if (!isset($_SESSION['login'])) {
    header("Location: login.php");
    exit;
}
$id = $_GET['id'];
$conn->query("DELETE FROM crud_028 WHERE id=$id");
header("Location: dashboard.php");
exit;