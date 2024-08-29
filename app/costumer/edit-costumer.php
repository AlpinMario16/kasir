<?php
session_start();

if (!isset($_SESSION["ssLoginPOS"])) {
    header("location: ../auth/login.php");
    exit();
}

require "../config/config.php";
require "../config/functions.php";
require "module/module-costumer.php";

$title = "Edit Costumer - Kasir";
require "template/header.php";
require "template/navbar.php";
require "template/sidebar.php";

// jalankan fungsi update data
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update'])) {
    if (update($_POST)) {
        echo "<script>
        document.location.href = 'index.php?page=costumer&msg=updated'
        </script>";
    }
}

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $sqlEdit = "SELECT * FROM tbl_costumer WHERE id_costumer = $id";
    $costumer = getData($sqlEdit)[0];
}
?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Costumer </h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="<?= $main_url ?>dashboard.php">Home</a></li>
                        <li class="breadcrumb-item"><a href="index.php?page=costumer">Costumer</a></li>
                        <li class="breadcrumb-item active">Edit Costumer</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>

    <section class="content">
        <div class="container-fluid">
            <div class="card">
                <form action="" method="post">
                    <div class="card-header">
                        <h3 class="card-title"><i class="fas fa-plus fa-sm"></i>Edit Costumer</h3>
                        <button type="submit" name="update" class="btn btn-primary btn-sm float-right"><i class="fas fa-save"></i> Update</button>
                        <button type="reset" class="btn btn-danger btn-sm float-right mr-1"><i class="fas fa-times"></i> Reset</button>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <input type="hidden" name="id" value="<?= $costumer['id_costumer'] ?>">
                            <div class="col-lg-8 mb-3">
                                <div class="form-group">
                                    <label for="nama">Nama</label>
                                    <input type="text" name="nama" class="form-control" id="nama" placeholder="nama costumer" autofocus value="<?= $costumer['nama'] ?>" required>
                                </div>
                                <div class="form-group">
                                    <label for="telpon">Telpon</label>
                                    <input type="text" name="telpon" class="form-control" id="telpon" placeholder="no telpon costumer" pattern="[0-9]{5,}" title="minimal 5 angka" value="<?= $costumer['telpon'] ?>" required>
                                </div>
                                <div class="form-group">
                                    <label for="ketr">Deskripsi</label>
                                    <textarea name="ketr" id="ketr" rows="1" class="form-control" placeholder="Keterangan costumer" required><?= $costumer['deskripsi'] ?></textarea>
                                </div>
                                <div class="form-group">
                                    <label for="alamat">Alamat</label>
                                    <textarea name="alamat" id="alamat" rows="3" class="form-control" placeholder="Alamat costumer" required><?= $costumer['alamat'] ?></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </section>
</div>

<?php require "template/footer.php"; ?>
