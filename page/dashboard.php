<?php
session_start();
if (!isset($_SESSION['login'])) {
    header('Location: ../login.php');
    exit();
}
include '../config/db.php';

$queryJamaah = "SELECT COUNT(*) AS total FROM crud_028_jamaah";
$resultJamaah = $conn->query($queryJamaah);
$dataJamaah = $resultJamaah->fetch_assoc();

$queryMitra = "SELECT COUNT(*) AS total FROM crud_028_mitra";
$resultMitra = $conn->query($queryMitra);
$dataMitra = $resultMitra->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Sistem Manajemen Umrah</title>
    <link rel="stylesheet" href="../assets/css/dashboard.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
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
                    <li class="active">
                        <a href="dashboard.php">
                            <i class="fas fa-tachometer-alt"></i>
                            <span>Dashboard</span>
                        </a>
                    </li>
                    <li>
                        <a href="jamaah/jamaah.php">
                            <i class="fas fa-users"></i>
                            <span>Data Jamaah</span>
                        </a>
                    </li>
                    <li>
                        <a href="mitra/mitra.php">
                            <i class="fas fa-handshake"></i>
                            <span>Data Mitra</span>
                        </a>
                    </li>
                    <li class="divider"></li>
                    <li>
                        <a href="settings.php">
                            <i class="fas fa-cog"></i>
                            <span>Pengaturan</span>
                        </a>
                    </li>
                    <li>
                        <a href="logout.php">
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
                    <a href="dashboard.php">Home</a> / Dashboard
                </div>
                
                <div class="header-actions">
                    <button class="settings-btn">
                        <i class="fas fa-cog"></i>
                    </button>
                    <div class="user-profile">
                        <img src="../assets/img/admin.png" alt="Admin">
                    </div>
                </div>
            </header>

            <!-- Content Area -->
            <div class="content-area">
                <div class="content-header">
                    <h1>Dashboard Admin</h1>
                </div>
                
                <!-- Stats Cards -->
                <div class="stats-container">
                    <div class="stat-card">
                        <div class="stat-icon jamaah-icon">
                            <i class="fas fa-users"></i>
                        </div>
                        <div class="stat-details">
                            <h3>Jumlah Jamaah</h3>
                            <p class="stat-number"><?php echo $dataJamaah['total']; ?></p>
                        </div>
                    </div>
                    
                    <div class="stat-card">
                        <div class="stat-icon mitra-icon">
                            <i class="fas fa-handshake"></i>
                        </div>
                        <div class="stat-details">
                            <h3>Jumlah Mitra</h3>
                            <p class="stat-number"><?php echo $dataMitra['total']; ?></p>
                        </div>
                    </div>
                </div>
                
                <!-- Action Buttons -->
                <div class="action-buttons">
                    <a href="jamaah/tambah_jamaah.php" class="btn btn-primary">
                        <i class="fas fa-plus"></i> Tambah Jamaah
                    </a>
                    <a href="mitra/tambah_mitra.php" class="btn btn-success">
                        <i class="fas fa-plus"></i> Tambah Mitra
                    </a>
                </div>
                
                <!-- Recent Data -->
                <div class="content-section">
                    <div class="section-header">
                        <h2>Data Terbaru</h2>
                        <a href="jamaah/jamaah.php" class="view-all">Lihat Semua</a>
                    </div>
                    
                    <div class="table-responsive">
                        <table class="data-table">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Nama Jamaah</th>
                                    <th>Paket Umrah</th>
                                    <th>Mitra</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                // Get recent jamaah data
                                $queryRecentJamaah = "SELECT j.*, m.nama_lengkap as nama_mitra 
                                                    FROM crud_028_jamaah j 
                                                    LEFT JOIN crud_028_mitra m ON j.nama_mitra = m.id 
                                                    ORDER BY j.id DESC LIMIT 5";
                                $resultRecentJamaah = $conn->query($queryRecentJamaah);
                                
                                if ($resultRecentJamaah->num_rows > 0) {
                                    while ($row = $resultRecentJamaah->fetch_assoc()) {
                                        echo "<tr>";
                                        echo "<td>" . $row['id'] . "</td>";
                                        echo "<td>" . $row['nama_lengkap'] . "</td>";
                                        echo "<td>" . $row['paket_umrah'] . "</td>";
                                        echo "<td>" . $row['nama_mitra'] . "</td>";
                                        echo "<td><span class='status active'>Aktif</span></td>";
                                        echo "</tr>";
                                    }
                                } else {
                                    echo "<tr><td colspan='5' class='no-data'>Belum ada data jamaah</td></tr>";
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <script>
        // Toggle sidebar
        document.getElementById('sidebarToggle').addEventListener('click', function() {
            document.getElementById('sidebar').classList.toggle('collapsed');
            document.querySelector('.main-content').classList.toggle('expanded');
        });
    </script>
</body>
</html>