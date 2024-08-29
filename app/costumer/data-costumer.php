<?php
session_start();

if (!isset($_SESSION["ssLoginPOS"])) {
  header("location: ../auth/login.php");
  exit();
}

require "../config/config.php";
require "../config/functions.php";
require "module/module-costumer.php";

$title = "Data Costumer - Kasir";
require "template/header.php";
require "template/navbar.php";
require "template/sidebar.php";

if (isset($_GET['msg'])){
    $msg = $_GET['msg'];
} else {
    $msg = '';
}

$alert = '';
if ($msg == 'delected'){
    $alert = '   <div class="alert alert-success alert-dismissible">
                  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                  <h5><i class="icon fas fa-check"></i> Alert!</h5>
                  Costumer Berhasil Dihapus
                </div>';
}

if ($msg == 'updated'){
    $alert = '   <div class="alert alert-success alert-dismissible">
                  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                  <h5><i class="icon fas fa-circle"></i> Alert!</h5>
                  Costumer Berhasil Diperbaruhi
                </div>';
}

if ($msg ==  'aborted'){
    $alert = '   <div class="alert alert-danger alert-dismissible">
                  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                  <h5><i class="icon fas fa-exclamation-triangle"></i> Alert!</h5>
                  Costumer Gagal Dihapus
                </div>';
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
              <li class="breadcrumb-item active">Data Costumer</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <section>
        <div class="container-fluid">
            <div class="card">
                <?php if ($alert != ''){
                    echo $alert;
                } ?>
                <div class="card-header">
                <h3 class="card-title"><i class="fas fa-list fa-sm"></i> Data Costumer</h3>
                <a href="<?= $main_url ?>index.php?page=costumer&act=create" class="btn btn-sm btn-primary float-right"> <i class="fas fa-plus fa-sm"></i> Add Costumer</a>
                </div>
                <div class="card-body table-responsive p-3">
                    <table class="table table-hover text-nowrap" id="tblData">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama</th>
                                <th>Telpon</th>
                                <th>Alamat</th>
                                <th>Deskripsi</th>
                                <th style="width: 10%;">Operasi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $no = 1;
                            $costumers = getData("SELECT * FROM tbl_costumer");
                            if (!empty($costumers)) {
                                foreach ($costumers as $costumer) { 
                            ?>
                                <tr>
                                    <td><?= $no++ ?></td>
                                    <td><?= $costumer['nama'] ?></td>
                                    <td><?= $costumer['telpon'] ?></td>
                                    <td><?= $costumer['alamat'] ?></td>
                                    <td><?= $costumer['deskripsi'] ?></td>
                                    <td>
                                        <a href="index.php?page=costumer&act=edit&id=<?= $costumer['id_costumer'] ?>" class="btn btn-sm btn-warning" title="edit costumer"><i class="fas fa-pen"></i></a>
                                        <a href="index.php?page=costumer&act=delete&id=<?= $costumer['id_costumer'] ?>" 
                                        class="btn btn-sm btn-danger" 
                                        title="hapus costumer" 
                                        onclick="return confirm('Anda yakin ingin menghapus costumer ini ?')">
                                        <i class="fas fa-trash"></i>
                                        </a>

                                    </td>
                                </tr>
                            <?php
                                }
                            } else {
                                echo "<tr><td colspan='6'>No costumers found.</td></tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section> 
</div>

<?php


require "template/footer.php";


?>
