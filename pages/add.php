<?php
include '../config/db.php';
if (!isset($_SESSION['login'])) {
    header("Location: login.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama = $_POST['nama_jamaah'];
    $paspor = $_POST['no_paspor'];
    $alamat = $_POST['alamat'];
    $hp = $_POST['no_hp'];
    $paket = $_POST['paket_umrah'];
    $conn->query("INSERT INTO crud_028 (nama_jamaah, no_paspor, alamat, no_hp, paket_umrah) 
                VALUES ('$nama', '$paspor', '$alamat', '$hp', '$paket')");
    header("Location: dashboard.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/style.css">
    <title>Tambah Jamaah</title>
</head>
<body>
    <div class="container">
        <h2 class="title">Tambah Data Jamaah</h2>
        <form method="post" class="form-container">
            <div class="form-group">
                <label for="nama_jamaah">Nama Jamaah</label>
                <input type="text" id="nama_jamaah" name="nama_jamaah" placeholder="Nama Jamaah" required>
            </div>
            <div class="form-group">
                <label for="no_paspor">No Paspor</label>
                <input type="text" id="no_paspor" name="no_paspor" placeholder="No Paspor" required>
            </div>
            <div class="form-group">
                <label for="alamat">Alamat</label>
                <textarea id="alamat" name="alamat" placeholder="Alamat" required></textarea>
            </div>
            <div class="form-group">
                <label for="no_hp">No HP</label>
                <input type="text" id="no_hp" name="no_hp" placeholder="No HP" required>
            </div>
            <div class="form-group">
                <label for="paket_umrah">Paket Umrah</label>
                <input type="text" id="paket_umrah" name="paket_umrah" placeholder="Paket Umrah" required>
            </div>
            <button type="submit" class="submit-btn">Simpan</button>
        </form>
        <a href="dashboard.php" class="back-btn">Kembali</a>
    </div>
</body>
</html>
