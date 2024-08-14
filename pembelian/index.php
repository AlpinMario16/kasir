<?php

session_start();

if (!isset($_SESSION["ssLoginPOS"])) {
  header("location: ../auth/login.php");
  exit();
}

require "../config/config.php";
require "../config/functions.php";
require "../module/module-beli.php";

$title = "Transaksi - Kasir";
require "../template/header.php";
require "../template/navbar.php";
require "../template/sidebar.php";

$noBeli = genereteNo();

?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Pembelian Barang </h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?= $main_url ?>dashboard.php">Home</a></li>
              <li class="breadcrumb-item"><a href="<?= $main_url ?>barang">Barang</a></li>
              <li class="breadcrumb-item active">Tambah Pembelian</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>

    <section>
        <div class="container-fluid">
            <form action="" method="post">
                <div class="row">
                    <div class="col-lg-6">
                        <div class="card card-outline card-warning p-3">
                            <div class="form-group row mb-2">
                                <label for="noNota" class="col-sm-2 col-form-label">No Nota</label>
                                <div class="col-sm-4">
                                    <input type="text" name="nobeli" class="form-control" id="noNota" value="<?= $noBeli ?>" readonly>
                                </div>
                                <label for="tglNota" class="col-sm-2 col-form-label"> Tanggal Nota</label>
                                <div class="col-sm-4">
                                    <input type="date" name="tglNota" class="form-control" id="tglNota" value="<?= date('Y-m-d') ?>" required>
                                </div>
                            </div>
                            <div class="form-group row mb-2">
                                <label for="kodeBrg" class="col-sm-2 col-form-label">SKU</label>
                                <div class="col-sm-10">
                                    <select name="kodeBrg" id="kodeBrg" class="form-control">
                                        <option value="">--Pilih kode barang--</option>
                                        <?php
                                        $barang = getData("SELECT * FROM tbl_barang");
                                        foreach($barang as $brg){ ?>
                                            <option value="<?= $brg['id_barang'] ?>"><?= $brg['nama_barang']?></option>
                                            <?php
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="card card-outline card-danger pt-3 px-3 pb-2">
                            <h6 class="font-weight-bold text-right">Total Pembelian</h6>
                            <h1 class="font-weight-bold text-right" id="totalPembelian" style="font-size: 40pt;">0</h1>
                        </div>
                    </div>
                </div>
                <div class="card pt-1 pb-2 px-3">
                    <div class="row">
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label for="namaBrg">Nama Barang</label>
                                <input type="text" name="namaBrg" class="form-control form-control-sm" id="namaBrg" readonly>
                            </div>
                        </div>
                        <div class="col-lg-1">
                            <div class="form-group">
                                <label for="stok">Stok</label>
                                <input type="number" name="stok" class="form-control form-control-sm" id="stok" readonly>
                            </div>
                        </div>
                        <div class="col-lg-1">
                            <div class="form-group">
                                <label for="satuan">Satuan</label>
                                <input type="text" name="satuan" class="form-control form-control-sm" id="satuan" readonly>
                            </div>
                        </div>
                        <div class="col-lg-2">
                            <div class="form-group">
                                <label for="harga">Harga</label>
                                <input type="number" name="harga" class="form-control form-control-sm" id="harga" readonly>
                            </div>
                        </div>
                        <div class="col-lg-2">
                            <div class="form-group">
                                <label for="qty">Qty</label>
                                <input type="number" name="qty" class="form-control form-control-sm" id="qty">
                            </div>
                        </div>
                        <div class="col-lg-2">
                            <div class="form-group">
                                <label for="jmlHarga">Jumlah Harga</label>
                                <input type="number" name="jmlHarga" class="form-control form-control-sm" id="jmlHarga" readonly>
                            </div>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-sm btn-info btn-block" name="addBrg"><i class="fas fa-cart-plus fa-sm"></i> Tambah Barang</button>
                </div>
                <div class="card card-outline card-success table-responsive px-2">
                    <table class="table table-sm table-hover text-nowrap">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Kode Barang</th>
                                <th>Nama Barang</th>
                                <th class="text-right">Harga</th>
                                <th class="text-right">Qty</th>
                                <th class="text-right">Jumlah Harga</th>
                                <th class="text-right">Operasi</th>
                            </tr>
                        </thead>
                        <tbody id="tablePembelian">
                            <!-- Data barang yang dibeli akan ditambahkan di sini -->
                        </tbody>
                    </table>
                </div>
                <div class="row">
                    <div class="col-lg-6 p2">
                        <div class="form-group row mb-2">
                            <label for="suplier" class="col-sm-3 col-form-label col-form-label-sm">Suplier</label>
                            <div class="col-sm-9">
                                <select name="suplier" id="suplier" class="form-control form-control-sm">
                                    <option value="">-- Pilih Suplier --</option>
                                    <?php
                                    $suppliers = getData("SELECT * FROM tbl_suplier");
                                    foreach($suppliers as $supplier){ ?>
                                        <option value="<?= $supplier['nama'] ?>"><?= $supplier['nama'] ?></option>
                                        <?php
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row mb-2">
                            <label for="ketr" class="col-sm-3 col-form-label">Keterangan</label>
                            <div class="col-sm-9">
                                <textarea name="ketr" id="ketr" class="form-control form-control-sm"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 p-2">
                        <button type="submit" name="simpan" id="simpan" class="btn btn-primary btn-sm btn-block"><i class="fa fa-save"></i> Simpan</button>
                    </div>
                </div>
            </form>
        </div>
    </section>

<?php 
require "../template/footer.php";
?>

