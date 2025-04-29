<?php
session_start();
if (!isset($_SESSION['login'])) {
    header('Location: ../../index.php');
    exit();
}
include '../../config/db.php';

// Delete jamaah if requested
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $query = "DELETE FROM crud_028_jamaah WHERE id = $id";
    if ($conn->query($query) === TRUE) {
        $success_message = "Data jamaah berhasil dihapus";
    } else {
        $error_message = "Error: " . $conn->error;
    }
}

// Get all jamaah data
$query = "SELECT j.*, m.nama_lengkap as nama_mitra 
        FROM crud_028_jamaah j 
        LEFT JOIN crud_028_mitra m ON j.nama_mitra = m.id 
        ORDER BY j.id DESC";
$result = $conn->query($query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Jamaah - Sistem Manajemen Umrah</title>
    <link rel="stylesheet" href="../../assets/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.24/css/jquery.dataTables.min.css">
    <!-- SweetAlert2 CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.18/dist/sweetalert2.min.css">
</head>
<body>
    <div class="app-container">
        <!-- Sidebar -->
        <aside class="sidebar" id="sidebar">
            <div class="sidebar-header">
                <h2 class="app-logo">UmrahApp</h2>
                <button class="sidebar-toggle" id="sidebarToggle">
                    <i class="fas fa-bars"></i>
                </button>
            </div>
            
            <nav class="sidebar-nav">
                <ul>
                    <li>
                        <a href="../dashboard.php">
                            <i class="fas fa-tachometer-alt"></i>
                            <span>Dashboard</span>
                        </a>
                    </li>
                    <li class="active">
                        <a href="jamaah.php">
                            <i class="fas fa-users"></i>
                            <span>Data Jamaah</span>
                        </a>
                    </li>
                    <li>
                        <a href="../mitra/mitra.php">
                            <i class="fas fa-handshake"></i>
                            <span>Data Mitra</span>
                        </a>
                    </li>
                    <li class="divider"></li>
                    <li>
                        <a href="../settings.php">
                            <i class="fas fa-cog"></i>
                            <span>Pengaturan</span>
                        </a>
                    </li>
                    <li>
                        <a href="../logout.php">
                            <i class="fas fa-sign-out-alt"></i>
                            <span>Logout</span>
                        </a>
                    </li>
                </ul>
            </nav>
        </aside>

        <!-- Main Content -->
        <main class="main-content">
            <!-- Top Header -->
            <header class="top-header">
                <div class="breadcrumb">
                    <a href="../dashboard.php">Home</a> / Data Jamaah
                </div>
                
                <div class="header-actions">
                    <button class="settings-btn">
                        <i class="fas fa-cog"></i>
                    </button>
                    <div class="user-profile">
                        <img src="../../assets/img/admin.png" alt="Admin">
                    </div>
                </div>
            </header>

            <!-- Content Area -->
            <div class="content-area">
                <div class="content-header">
                    <h1>Daftar Jamaah</h1>
                    <a href="tambah_jamaah.php" class="btn btn-primary">
                        <i class="fas fa-plus"></i> Tambah Jamaah
                    </a>
                </div>
                
                <?php if (isset($success_message)): ?>
                <div class="alert alert-success">
                    <?php echo $success_message; ?>
                </div>
                <?php endif; ?>
                
                <?php if (isset($error_message)): ?>
                <div class="alert alert-danger">
                    <?php echo $error_message; ?>
                </div>
                <?php endif; ?>
                
                <div class="table-responsive">
                    <table id="jamaahTable" class="data-table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nama Jamaah</th>
                                <th>No. Paspor/KTP</th>
                                <th>Jenis Kelamin</th>
                                <th>No. HP</th>
                                <th>Paket Umrah</th>
                                <th>Mitra</th>
                                <th>Aktif</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if ($result->num_rows > 0) {
                                while ($row = $result->fetch_assoc()) {
                                    echo "<tr>";
                                    echo "<td>" . $row['id'] . "</td>";
                                    echo "<td>" . $row['nama_lengkap'] . "</td>";
                                    echo "<td>" . $row['no_paspor_ktp'] . "</td>";
                                    echo "<td>" . $row['jenis_kelamin'] . "</td>";
                                    echo "<td>" . $row['no_hp'] . "</td>";
                                    echo "<td>" . $row['paket_umrah'] . "</td>";
                                    echo "<td>" . $row['nama_mitra'] . "</td>";
                                    echo "<td>
                                        <label class='switch'>
                                            <input type='checkbox' checked>
                                            <span class='slider round'></span>
                                        </label>
                                    </td>";
                                    echo "<td class='action-buttons'>
                                        <a href='edit_jamaah.php?id=" . $row['id'] . "' class='btn-edit'>
                                            <i class='fas fa-edit'></i> Edit
                                        </a>
                                        <button class='btn-delete delete-btn' data-id='" . $row['id'] . "'>
                                            <i class='fas fa-trash'></i> Hapus
                                        </button>
                                    </td>";
                                    echo "</tr>";
                                }
                            } else {
                                echo "<tr><td colspan='9' class='no-data'>Belum ada data jamaah</td></tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </main>
    </div>

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- DataTables JS -->
    <script src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>
    <!-- SweetAlert2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.18/dist/sweetalert2.all.min.js"></script>
    
    <script>
        // Toggle sidebar
        document.getElementById('sidebarToggle').addEventListener('click', function() {
            document.getElementById('sidebar').classList.toggle('collapsed');
            document.querySelector('.main-content').classList.toggle('expanded');
        });
        
        // Initialize DataTable
        $(document).ready(function() {
            $('#jamaahTable').DataTable({
                responsive: true,
                "language": {
                    "lengthMenu": "Tampilkan _MENU_ data per halaman",
                    "zeroRecords": "Tidak ada data yang ditemukan",
                    "info": "Menampilkan halaman _PAGE_ dari _PAGES_",
                    "infoEmpty": "Tidak ada data yang tersedia",
                    "infoFiltered": "(difilter dari _MAX_ total data)",
                    "search": "Cari:",
                    "paginate": {
                        "first": "Pertama",
                        "last": "Terakhir",
                        "next": "Selanjutnya",
                        "previous": "Sebelumnya"
                    }
                }
            });
            
            // Delete confirmation
            $('.delete-btn').click(function() {
                const id = $(this).data('id');
                
                Swal.fire({
                    title: 'Apakah Anda yakin?',
                    text: "Data jamaah akan dihapus permanen!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Ya, hapus!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = 'jamaah.php?delete=' + id;
                    }
                });
            });
        });
    </script>
</body>
</html>