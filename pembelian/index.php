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

$msg = isset($_GET['msg']) ? $_GET['msg'] : '';

if ($msg == 'deleted') {
    $idbrg = $_GET['idbrg'];
    $idbeli = $_GET['idbeli'];
    $qty = $_GET['qty'];
    $tgl = $_GET['tgl'];
    delete($idbrg, $idbeli, $qty);
    echo "<script>
                document.location = '?tgl=$tgl'
                </script>";
}

$kode = isset($_GET['pilihbrg']) ? $_GET['pilihbrg'] : '';
$selectBrg = null;

if ($kode) {
    $selectBrgData = getData("SELECT * FROM tbl_barang WHERE id_barang = '$kode'");
    if (!empty($selectBrgData)) {
        $selectBrg = $selectBrgData[0];
    } else {
        echo "Barang tidak ditemukan.";
    }
}

if (isset($_POST['addbrg'])) {
    $tgl = $_POST['tglNota'];
    if (insert($_POST)) {
        echo "<script>
                document.location = '?tgl=$tgl'
                </script>";
    }
}

if (isset($_POST['simpan'])) {
    if (simpan($_POST)) {
        echo "<script>
        alert('Data pembelian berhasil disimpan');
                document.location = 'index.php'
                </script>";
    }
}

$noBeli = genereteNo();
$totalPembelian = totalBeli($noBeli);

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
                                    <input type="date" name="tglNota" class="form-control" id="tglNota" value="<?= isset($_GET['tgl']) ? $_GET['tgl'] : date('Y-m-d') ?>" required>
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
                                            <option value="<?= $brg['id_barang'] ?>" <?= $kode == $brg['id_barang'] ? 'selected' : '' ?>>
                                                <?= $brg['id_barang']. " | " . $brg['nama_barang'] ?>
                                            </option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="card card-outline card-danger pt-3 px-3 pb-2">
                            <h6 class="font-weight-bold text-right">Total Pembelian</h6>
                            <h1 class="font-weight-bold text-right" id="totalPembelian" style="font-size: 40pt;">
                            <input type="hidden" name="total" value="<?= $totalPembelian ?>">
                            <?= number_format($totalPembelian ?? 0, 0, ',', '.') ?>
                        </h1>

                        </div>
                    </div>
                </div>
                <div class="card pt-1 pb-2 px-3">
                    <div class="row">
                        <div class="col-lg-4">
                            <div class="form-group">
                                <input type="hidden" value="<?= $kode ? $selectBrg['id_barang'] : '' ?>" name="kodeBrg">
                                <label for="namaBrg">Nama Barang</label>
                                <input type="text" name="namaBrg" class="form-control form-control-sm" id="namaBrg" value="<?= $kode ? $selectBrg['nama_barang'] : '' ?>" readonly>
                            </div>
                        </div>
                        <div class="col-lg-1">
                            <div class="form-group">
                                <label for="stok">Stok</label>
                                <input type="number" name="stok" class="form-control form-control-sm" id="stok" value="<?= $kode ? $selectBrg['stock'] : '' ?>" readonly>
                            </div>
                        </div>
                        <div class="col-lg-1">
                            <div class="form-group">
                                <label for="satuan">Satuan</label>
                                <input type="text" name="satuan" class="form-control form-control-sm" id="satuan" value="<?= $kode ? $selectBrg['satuan'] : '' ?>" readonly>
                            </div>
                        </div>
                        <div class="col-lg-2">
                            <div class="form-group">
                                <label for="harga">Harga</label>
                                <input type="number" name="harga" class="form-control form-control-sm" id="harga" value="<?= $kode ? $selectBrg['harga_beli'] : '' ?>" readonly>
                            </div>
                        </div>
                        <div class="col-lg-2">
                            <div class="form-group">
                                <label for="qty">Qty</label>
                                <input type="number" name="qty" class="form-control form-control-sm" id="qty" value="<?= $kode ? 1 : '' ?>">
                            </div>
                        </div>
                        <div class="col-lg-2">
                            <div class="form-group">
                                <label for="jmlHarga">Jumlah Harga</label>
                                <input type="number" name="jmlHarga" class="form-control form-control-sm" id="jmlHarga" value="<?= $kode ? $selectBrg['harga_beli'] : '' ?>" readonly>
                            </div>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-sm btn-info btn-block" name="addbrg"><i class="fas fa-cart-plus fa-sm"></i> Tambah Barang</button>
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
                        <tbody>
                            <?php 
                            $no = 1;
                            $brgDetail = getData("SELECT * FROM tbl_beli_detail WHERE no_beli = '$noBeli'");
                            foreach ($brgDetail as $detail){ ?>  
                            <tr>
                                <td><?= $no++ ?></td>
                                <td><?= $detail['kode_brg'] ?></td>
                                <td><?= $detail['nama_brg'] ?></td>
                                <td class="text-right"><?= number_format($detail['harga_beli'],0,',','.') ?></td>
                                <td class="text-right">
                                    <?= $detail['qty'] ?>
                                </td>
                                <td class="text-right"><?= number_format($detail['jml_harga'],0,',','.') ?></td>
                                <td class="text-center"> <a href="?idbrg=<?= $detail['kode_brg'] ?>&idbeli=<?= $detail['no_beli'] ?>&qty=<?= $detail['qty'] ?>&tgl=<?= $detail['tgl_beli'] ?>&msg=deleted" class="btn btn-sm btn-danger" title="hapus barang" onclick="return confirm('Anda yakin akan menghapus barang ini ?')"><i class="fas fa-trash"></i></a></td>
                            </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
                <button type="submit" name="simpan" class="btn btn-sm btn-success btn-block"><i class="fas fa-save fa-sm"></i> Simpan Transaksi</button>
            </form>
        </div>
    </section>
</div>

<script>
    let pilihbrg = document.getElementById('kodeBrg');
    let tgl  = document.getElementById('tglNota');
    pilihbrg.addEventListener('change', function(){
        document.location.href = '?pilihbrg=' + this.value + '&tgl=' + tgl.value;
    });

    let qtyInput = document.getElementById('qty');
    let hargaInput = document.getElementById('harga');
    let jmlHargaInput = document.getElementById('jmlHarga');

    qtyInput.addEventListener('input', function() {
        let qty = parseInt(qtyInput.value);
        let harga = parseInt(hargaInput.value);
        jmlHargaInput.value = qty * harga;
    });

    function hapusData(idbrg, qty, idbeli, tgl) {
        if (confirm('Apakah Anda yakin ingin menghapus data ini?')) {
            document.location.href = '?msg=deleted&idbrg=' + idbrg + '&qty=' + qty + '&idbeli=' + idbeli + '&tgl=' + tgl;
        }
    }
</script>

<?php require "../template/footer.php"; ?>
