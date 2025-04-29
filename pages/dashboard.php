<?php
include '../config/db.php';
if (!isset($_SESSION['login'])) {
    header("Location: login.php");
    exit;
}
$data = $conn->query("SELECT * FROM crud_028");
?>

<!DOCTYPE html>
<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="../assets/style.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
</head>
<body>
    <a href="dashboard.php" class="menu-btn">Dashboard</a>
    <a href="add.php" class="menu-btn">Tambah Jama'ah</a>
    <a href="logout.php" class="menu-btn">Logout</a>

<table id="jamaahTable">
    <thead>
        <tr>
            <th>ID</th>
            <th>Nama</th>
            <th>No Paspor</th>
            <th>Alamat</th>
            <th>No HP</th>
            <th>Paket</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        <?php while ($row = $data->fetch_assoc()): ?>
        <tr>
            <td><?= $row['id'] ?></td>
            <td><?= $row['nama_jamaah'] ?></td>
            <td><?= $row['no_paspor'] ?></td>
            <td><?= $row['alamat'] ?></td>
            <td><?= $row['no_hp'] ?></td>
            <td><?= $row['paket_umrah'] ?></td>
            <td>
                <a href="edit.php?id=<?= $row['id'] ?>">Edit</a> | 
                <a href="delete.php?id=<?= $row['id'] ?>" class="btn-delete">Hapus</a>
            </td>
        </tr>
        <?php endwhile; ?>
    </tbody>
</table>

<script src="https://code.jquery.com/jquery-3.7.0.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
$(document).ready(function() {
    $('#jamaahTable').DataTable();
    $('.btn-delete').on('click', function(e) {
        e.preventDefault();
        const href = $(this).attr('href');
        Swal.fire({
            title: 'Yakin ingin menghapus?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Hapus'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = href;
            }
        });
    });
});
</script>
</body>
</html>