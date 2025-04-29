/*<?php
session_start();
if (!isset($_SESSION['login'])) {
    header('Location: ../../login.php');
    exit();
}
include '../../config/db.php';

// Fetch jamaah data based on ID for editing
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $query_jamaah = "SELECT * FROM crud_028_jamaah WHERE id = $id";
    $result_jamaah = $conn->query($query_jamaah);
    $jamaah = $result_jamaah->fetch_assoc();
}

// Fetch all mitra for dropdown
$query_mitra = "SELECT * FROM crud_028_mitra ORDER BY nama_lengkap";
$result_mitra = $conn->query($query_mitra);

// Process form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate and sanitize input
    $nama_lengkap = clean($_POST['nama_lengkap']);
    $no_paspor_ktp = clean($_POST['no_paspor_ktp']);
    $jenis_kelamin = clean($_POST['jenis_kelamin']);
    $alamat = clean($_POST['alamat']);
    $no_hp = clean($_POST['no_hp']);
    $paket_umrah = clean($_POST['paket_umrah']);
    $nama_mitra = clean($_POST['nama_mitra']);

    // Server-side validation
    $errors = [];

    if (empty($nama_lengkap)) {
        $errors[] = "Nama lengkap harus diisi";
    }

    if (empty($no_paspor_ktp)) {
        $errors[] = "No. Paspor/KTP harus diisi";
    }

    if (empty($jenis_kelamin)) {
        $errors[] = "Jenis kelamin harus dipilih";
    }

    if (empty($alamat)) {
        $errors[] = "Alamat harus diisi";
    }

    if (empty($no_hp)) {
        $errors[] = "No. HP harus diisi";
    } elseif (!preg_match("/^[0-9]{10,15}$/", $no_hp)) {
        $errors[] = "No. HP harus berupa angka (10-15 digit)";
    }

    if (empty($paket_umrah)) {
        $errors[] = "Paket umrah harus diisi";
    }

    if (empty($nama_mitra)) {
        $errors[] = "Mitra harus dipilih";
    }

    // If no errors, update data
    if (empty($errors)) {
        $query = "UPDATE crud_028_jamaah SET 
                nama_lengkap = '$nama_lengkap', 
                no_paspor_ktp = '$no_paspor_ktp', 
                jenis_kelamin = '$jenis_kelamin', 
                alamat = '$alamat', 
                no_hp = '$no_hp', 
                paket_umrah = '$paket_umrah', 
                nama_mitra = '$nama_mitra' 
                WHERE id = $id";
        
        if ($conn->query($query)) {
            header("Location: jamaah.php?success=updated");
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
    <title>Edit Jamaah - Sistem Manajemen Umrah</title>
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
                    <a href="../dashboard.php">Home</a> / 
                    <a href="jamaah.php">Data Jamaah</a> / 
                    Edit Jamaah
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
                    <h1><i class="fas fa-user-edit"></i> Edit Jamaah</h1>
                    <a href="jamaah.php" class="btn btn-secondary">
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
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) . '?id=' . $id; ?>" method="post" id="jamaahForm" onsubmit="return validateJamaahForm()">
                        <div class="form-group">
                            <label for="nama_lengkap">Nama Lengkap</label>
                            <input type="text" id="nama_lengkap" name="nama_lengkap" value="<?php echo isset($jamaah['nama_lengkap']) ? $jamaah['nama_lengkap'] : ''; ?>">
                            <span class="error" id="nama_lengkap_error"></span>
                        </div>
                        
                        <div class="form-group">
                            <label for="no_paspor_ktp">No. Paspor/KTP</label>
                            <input type="text" id="no_paspor_ktp" name="no_paspor_ktp" value="<?php echo isset($jamaah['no_paspor_ktp']) ? $jamaah['no_paspor_ktp'] : ''; ?>">
                            <span class="error" id="no_paspor_ktp_error"></span>
                        </div>
                        
                        <div class="form-group">
                            <label>Jenis Kelamin</label>
                            <div class="radio-group">
                                <label>
                                    <input type="radio" name="jenis_kelamin" value="Laki-laki" <?php echo (isset($jamaah['jenis_kelamin']) && $jamaah['jenis_kelamin'] == 'Laki-laki') ? 'checked' : ''; ?>> Laki-laki
                                </label>
                                <label>
                                    <input type="radio" name="jenis_kelamin" value="Perempuan" <?php echo (isset($jamaah['jenis_kelamin']) && $jamaah['jenis_kelamin'] == 'Perempuan') ? 'checked' : ''; ?>> Perempuan
                                </label>
                            </div>
                            <span class="error" id="jenis_kelamin_error"></span>
                        </div>
                        
                        <div class="form-group">
                            <label for="alamat">Alamat</label>
                            <textarea id="alamat" name="alamat" rows="3"><?php echo isset($jamaah['alamat']) ? $jamaah['alamat'] : ''; ?></textarea>
                            <span class="error" id="alamat_error"></span>
                        </div>
                        
                        <div class="form-group">
                            <label for="no_hp">No. HP</label>
                            <input type="text" id="no_hp" name="no_hp" value="<?php echo isset($jamaah['no_hp']) ? $jamaah['no_hp'] : ''; ?>">
                            <span class="error" id="no_hp_error"></span>
                        </div>
                        
                        <div class="form-group">
                            <label for="paket_umrah">Paket Umrah</label>
                            <select id="paket_umrah" name="paket_umrah">
                                <option value="" disabled>Pilih Paket Umrah</option>
                                <option value="Ekonomi" <?php echo (isset($jamaah['paket_umrah']) && $jamaah['paket_umrah'] == 'Ekonomi') ? 'selected' : ''; ?>>Ekonomi</option>
                                <option value="Reguler" <?php echo (isset($jamaah['paket_umrah']) && $jamaah['paket_umrah'] == 'Reguler') ? 'selected' : ''; ?>>Reguler</option>
                                <option value="VIP" <?php echo (isset($jamaah['paket_umrah']) && $jamaah['paket_umrah'] == 'VIP') ? 'selected' : ''; ?>>VIP</option>
                                <option value="VVIP" <?php echo (isset($jamaah['paket_umrah']) && $jamaah['paket_umrah'] == 'VVIP') ? 'selected' : ''; ?>>VVIP</option>
                            </select>
                            <span class="error" id="paket_umrah_error"></span>
                        </div>
                        
                        <div class="form-group">
                            <label for="nama_mitra">Mitra</label>
                            <select id="nama_mitra" name="nama_mitra">
                                <option value="" disabled>Pilih Mitra</option>
                                <?php
                                if ($result_mitra->num_rows > 0) {
                                    while ($row = $result_mitra->fetch_assoc()) {
                                        $selected = (isset($jamaah['nama_mitra']) && $jamaah['nama_mitra'] == $row['id']) ? 'selected' : '';
                                        echo "<option value='" . $row['id'] . "' $selected>" . $row['nama_lengkap'] . "</option>";
                                    }
                                }
                                ?>
                            </select>
                            <span class="error" id="nama_mitra_error"></span>
                        </div>
                        
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Simpan
                            </button>
                            <button type="reset" class="btn btn-danger">
                                <i class="fas fa-undo"></i> Reset
                            </button>
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
        function validateJamaahForm() {
            let isValid = true;
            const nama_lengkap = document.getElementById('nama_lengkap');
            const no_paspor_ktp = document.getElementById('no_paspor_ktp');
            const jenis_kelamin = document.getElementsByName('jenis_kelamin');
            const alamat = document.getElementById('alamat');
            const no_hp = document.getElementById('no_hp');
            const paket_umrah = document.getElementById('paket_umrah');
            const nama_mitra = document.getElementById('nama_mitra');
            
            // Reset error messages
            document.querySelectorAll('.error').forEach(el => el.textContent = '');
            
            // Validate nama_lengkap
            if (nama_lengkap.value.trim() === '') {
                document.getElementById('nama_lengkap_error').textContent = 'Nama lengkap harus diisi';
                isValid = false;
            }
            
            // Validate no_paspor_ktp
            if (no_paspor_ktp.value.trim() === '') {
                document.getElementById('no_paspor_ktp_error').textContent = 'No. Paspor/KTP harus diisi';
                isValid = false;
            }
            
            // Validate jenis_kelamin
            let jenisKelaminSelected = false;
            for (let i = 0; i < jenis_kelamin.length; i++) {
                if (jenis_kelamin[i].checked) {
                    jenisKelaminSelected = true;
                    break;
                }
            }
            if (!jenisKelaminSelected) {
                document.getElementById('jenis_kelamin_error').textContent = 'Jenis kelamin harus dipilih';
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
            
            // Validate paket_umrah
            if (paket_umrah.value === '' || paket_umrah.value === null) {
                document.getElementById('paket_umrah_error').textContent = 'Paket umrah harus dipilih';
                isValid = false;
            }
            
            // Validate nama_mitra
            if (nama_mitra.value === '' || nama_mitra.value === null) {
                document.getElementById('nama_mitra_error').textContent = 'Mitra harus dipilih';
                isValid = false;
            }
            
            return isValid;
        }
    </script>
</body>
</html>