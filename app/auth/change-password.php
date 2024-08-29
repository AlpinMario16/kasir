<?php
session_start();

if (!isset($_SESSION["ssLoginPOS"])) {
    header("location: ../auth/login.php");
    exit();
}

require "config/config.php";
require "config/functions.php";
require "module/module-password.php";

$title = "Change Password - Kasir";
require "template/header.php";
require "template/navbar.php";
require "template/sidebar.php";

// Update password
if (isset($_POST['simpan'])) {
    if ($_POST['newPass'] !== $_POST['confPass']) {
        $_SESSION['error'] = 'Kata sandi tidak cocok.';
        header("Location: index.php?page=gantipw");
        exit();
    }
    
    $hashedPassword = password_hash($_POST['newPass'], PASSWORD_DEFAULT);
    
    if (update(['password' => $hashedPassword])) {
        $_SESSION['success'] = 'Password berhasil diperbarui.';
        header("Location: index.php?page=gantipw");
        exit();
    } else {
        $_SESSION['error'] = 'Terjadi kesalahan saat memperbarui kata sandi.';
        header("Location: index.php?page=gantipw");
        exit();
    }
}


$msg = $_GET['msg'] ?? '';
$alert1 = '<small class="text-danger p1-2 font-italic">Konfirmasi password tidak sama dengan password baru.</small>';
$alert2 = '<small class="text-danger p1-2 font-italic">Password saat ini tidak benar.</small>';
?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Password</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="<?= $main_url ?>dashboard.php">Home</a></li>
                        <li class="breadcrumb-item active">Password</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <section class="content">
        <div class="container-fluid">
            <div class="card">
                <form action="" method="post">
                    <div class="card-header">
                        <h3 class="card-title"><i class="fas fa-key"></i> Change Password</h3>
                        <button type="submit" name="simpan" class="btn btn-primary btn-sm float-right">
                            <i class="fas fa-edit"></i> Submit
                        </button>
                        <button type="reset" class="btn btn-danger btn-sm float-right mr-1">
                            <i class="fas fa-times"></i> Reset
                        </button>
                    </div>
                    <div class="card-body">
                        <div class="col-lg-8 mb-3">
                            <div class="form-group">
                                <label for="curPass">Current Password</label>
                                <input type="password" name="curPass" id="curPass" class="form-control" placeholder="Masukkan password Anda saat ini" required>
                                <?php if ($msg == 'err2') echo $alert2; ?>
                            </div>
                            <div class="form-group">
                                <label for="newPass">New Password</label>
                                <input type="password" name="newPass" id="newPass" class="form-control" placeholder="Masukkan password baru Anda" required>
                                <?php if ($msg == 'err1') echo $alert1; ?>
                            </div>
                            <div class="form-group">
                                <label for="confPass">Confirm Password</label>
                                <input type="password" name="confPass" id="confPass" class="form-control" placeholder="Masukkan kembali password baru Anda" required>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </section>

<?php require "template/footer.php"; ?>
