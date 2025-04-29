<?php
session_start();
if (!isset($_SESSION['login'])) {
    header('Location: ../../index.php');
    exit();
}
include '../../config/db.php';

// Check if id parameter exists
if (!isset($_GET['id'])) {
    header("Location: mitra.php");
    exit;
}

$id = $_GET['id'];

// Fetch mitra data
$query = "SELECT * FROM crud_028_mitra WHERE id = $id";
$result = $conn->query($query);

if ($result->num_rows == 0) {
    header("Location: mitra.php");
    exit;
}

$mitra = $result->fetch_assoc();

// Process form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate and sanitize input
    $nama_lengkap = clean($_POST['nama_lengkap']);
    $no_ktp_paspor = clean($_POST['no_ktp_paspor']);
    $alamat = clean($_POST['alamat']);
    $no_hp = clean($_POST['no_hp']);

    // Server-side validation
    $errors = [];

    if (empty($nama_lengkap)) {
        $errors[] = "Nama lengkap harus diisi";
    }

    if (empty($no_ktp_paspor)) {
        $errors[] = "No. KTP/Paspor harus diisi";
    }

    if (empty($alamat)) {
        $errors[] = "Alamat harus diisi";
    }

    if (empty($no_hp)) {
        $errors[] = "No. HP harus diisi";
    } elseif (!preg_match("/^[0-9]{10,15}$/", $no_hp)) {
        $errors[] = "No. HP harus berupa angka (10-15 digit)";
    }

    // If no errors, update data
    if (empty($errors)) {
        $query = "UPDATE crud_028_mitra SET 
                nama_lengkap = '$nama_lengkap', 
                no_ktp_paspor = '$no_ktp_paspor', 
                alamat = '$alamat', 
                no_hp = '$no_hp' 
                WHERE id = $id";
        
        if ($conn->query($query)) {
            header("Location: mitra.php?success=updated");
            exit;
        } else {
            $error_message = "Error: " . $conn->error;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Mitra - Sistem Manajemen Umrah</title>
    <link rel="stylesheet" href="../../assets/css/style.css">
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
                    <li>
                        <a href="../dashboard.php">
                            <i class="fas fa-tachometer-alt"></i>
                            <span>Dashboard</span>
                        </a>
                    </li>
                    <li>
                        <a href="../jamaah/jamaah.php">
                            <i class="fas fa-users"></i>
                            <span>Data Jamaah</span>
                        </a>
                    </li>
                    <li class="active">
                        <a href="mitra.php">
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
                    <a href="../dashboard.php">Home</a> / 
                    <a href="mitra.php">Data Mitra</a> / 
                    Edit Mitra
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
                    <h1><i class="fas fa-handshake"></i> Edit Mitra</h1>
                    <a href="mitra.php" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Kembali
                    </a>
                </div>
                
                <?php if (isset($error_message)): ?>
                    <div class="alert alert-danger">
                        <?php echo $error_message; ?>
                    </div>
                <?php endif; ?>
                
                <?php if (!empty($errors)): ?>
                    <div class="alert alert-danger">
                        <ul>
                            <?php foreach ($errors as $error): ?>
                                <li><?php echo $error; ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                <?php endif; ?>
                
                <div class="form-container">
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"] . "?id=$id"); ?>" method="post" id="mitraForm" onsubmit="return validateMitraForm()">
                        <div class="form-group">
                            <label for="nama_lengkap">Nama Lengkap</label>
                            <input type="text" id="nama_lengkap" name="nama_lengkap" value="<?php echo $mitra['nama_lengkap']; ?>">
                            <span class="error" id="nama_lengkap_error"></span>
                        </div>
                        
                        <div class="form-group">
                            <label for="no_ktp_paspor">No. KTP/Paspor</label>
                            <input type="text" id="no_ktp_paspor" name="no_ktp_paspor" value="<?php echo $mitra['no_ktp_paspor']; ?>">
                            <span class="error" id="no_ktp_paspor_error"></span>
                        </div>
                        
                        <div class="form-group">
                            <label for="alamat">Alamat</label>
                            <textarea id="alamat" name="alamat" rows="3"><?php echo $mitra['alamat']; ?></textarea>
                            <span class="error" id="alamat_error"></span>
                        </div>
                        
                        <div class="form-group">
                            <label for="no_hp">No. HP</label>
                            <input type="text" id="no_hp" name="no_hp" value="<?php echo $mitra['no_hp']; ?>">
                            <span class="error" id="no_hp_error"></span>
                        </div>
                        
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Update
                            </button>
                            <a href="mitra.php" class="btn btn-danger">
                                <i class="fas fa-times"></i> Batal
                            </a>
                        </div>
                    </form>
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
        
        // Form validation
        function validateMitraForm() {
            let isValid = true;
            const nama_lengkap = document.getElementById('nama_lengkap');
            const no_ktp_paspor = document.getElementById('no_ktp_paspor');
            const alamat = document.getElementById('alamat');
            const no_hp = document.getElementById('no_hp');
            
            // Reset error messages
            document.querySelectorAll('.error').forEach(el => el.textContent = '');
            
            // Validate nama_lengkap
            if (nama_lengkap.value.trim() === '') {
                document.getElementById('nama_lengkap_error').textContent = 'Nama lengkap harus diisi';
                isValid = false;
            }
            
            // Validate no_ktp_paspor
            if (no_ktp_paspor.value.trim() === '') {
                document.getElementById('no_ktp_paspor_error').textContent = 'No. KTP/Paspor harus diisi';
                isValid = false;
            }
            
            // Validate alamat
            if (alamat.value.trim() === '') {
                document.getElementById('alamat_error').textContent = 'Alamat harus diisi';
                isValid = false;
            }
            
            // Validate no_hp
            if (no_hp.value.trim() === '') {
                document.getElementById('no_hp_error').textContent = 'No. HP harus diisi';
                isValid = false;
            } else if (!/^[0-9]{10,15}$/.test(no_hp.value.trim())) {
                document.getElementById('no_hp_error').textContent = 'No. HP harus berupa angka (10-15 digit)';
                isValid = false;
            }
            
            return isValid;
        }
    </script>
</body>
</html>