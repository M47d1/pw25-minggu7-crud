<?php
include '../config/db.php';
if (!isset($_SESSION['login'])) {
    header("Location: login.php");
    exit;
}

$id = $_GET['id'];
$data = $conn->query("SELECT * FROM crud_028 WHERE id=$id")->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama = $_POST['nama_jamaah'];
    $paspor = $_POST['no_paspor'];
    $alamat = $_POST['alamat'];
    $hp = $_POST['no_hp'];
    $paket = $_POST['paket_umrah'];
    $conn->query("UPDATE crud_028 SET 
        nama_jamaah='$nama', no_paspor='$paspor', alamat='$alamat', 
        no_hp='$hp', paket_umrah='$paket' WHERE id=$id");
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
    <title>Edit Jamaah</title>
</head>
<body>
    <div class="container">
        <h2 class="title">Edit Data Jamaah</h2>
        <form method="post" class="form-container">
            <div class="form-group">
                <label for="nama_jamaah">Nama Jamaah</label>
                <input type="text" id="nama_jamaah" name="nama_jamaah" value="<?= $data['nama_jamaah'] ?>" required>
            </div>
            <div class="form-group">
                <label for="no_paspor">No Paspor</label>
                <input type="text" id="no_paspor" name="no_paspor" value="<?= $data['no_paspor'] ?>" required>
            </div>
            <div class="form-group">
                <label for="alamat">Alamat</label>
                <textarea id="alamat" name="alamat" required><?= $data['alamat'] ?></textarea>
            </div>
            <div class="form-group">
                <label for="no_hp">No HP</label>
                <input type="text" id="no_hp" name="no_hp" value="<?= $data['no_hp'] ?>" required>
            </div>
            <div class="form-group">
                <label for="paket_umrah">Paket Umrah</label>
                <input type="text" id="paket_umrah" name="paket_umrah" value="<?= $data['paket_umrah'] ?>" required>
            </div>
            <button type="submit" class="submit-btn">Update</button>
        </form>
        <a href="dashboard.php" class="back-btn">Kembali</a>
    </div>
</body>
</html>