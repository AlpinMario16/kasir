<?php 
session_start();

if (!isset($_SESSION["ssLoginPOS"])) {
    header("location: ../auth/login.php");
    exit();
}

require "config/config.php";
require "config/functions.php";
require "module/module-jual.php";

$title = "Transaksi - Kasir";
require "template/header.php";
require "template/navbar.php";
require "template/sidebar.php";

$msg = isset($_GET['msg']) ? $_GET['msg'] : '';

// jika barang di hapus
if ($msg == 'deleted') {
    $barcode = $_GET['barcode'];
    $idjual = $_GET['idjual'];
    $qty = $_GET['qty'];
    $tgl = $_GET['tgl'];
    delete($barcode, $idjual, $qty);
    echo "<script>
                alert('Barang telah dihapus.');
                document.location = 'index.php?page=penjualan&tgl=$tgl';
                </script>";
}

// jika ada barcode yang di kirim
$kode = isset($_GET['barcode']) ? $_GET['barcode'] : '';

if ($kode) {
    $tgl = $_GET['tgl'];
    $dataBrg = mysqli_query($koneksi, "SELECT * FROM tbl_barang WHERE barcode = '$kode'");
    $selectBrg = mysqli_fetch_assoc($dataBrg);

    if (mysqli_num_rows($dataBrg) == 0) {
        echo "<script>
        alert('Barang dengan barcode tersebut tidak ada.');
        document.location = 'index.php?page=penjualan&tgl=$tgl';
        </script>";
    }
}


// jika tombol barang ditekan
if (isset($_POST['addbrg'])) {
    $tgl = $_POST['tglNota'];
    if (insert($_POST)) {
        echo "<script>
                document.location = 'index.php?page=penjualan&act=view&tgl=$tgl';
                </script>";
    }
}

// jika tombol simpan ditekan
if (isset($_POST['simpan'])) {
    $nota = $_POST['nojual'];
    if (simpan($_POST)) {
        // Susun URL di sisi server dengan PHP
        $url = "index.php?page=penjualan&act=report&nota=" . urlencode($nota);
        echo "<script>
            alert('Data penjualan berhasil disimpan');
            window.onload = function(){
                let win = window.open('index.php?page=penjualan&act=report&nota=<?= $nota ?>','Struk Belanja','width=260,height=400,left=10,top=10','_blank');

                if (win) {
                    win.focus();
                    window.location = 'index.php';
                }
            }
        </script>";
    }
}



$nojual = genereteNo();
?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Penjualan Barang</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="<?= $main_url ?>dashboard.php">Home</a></li>
                        <li class="breadcrumb-item"><a href="index.php?page=barang">Barang</a></li>
                        <li class="breadcrumb-item active">Tambah Penjualan</li>
                    </ol>
                </div>
            </div>
        </div>
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
                                    <input type="text" name="nojual" class="form-control" id="noNota" value="<?= $nojual ?>" readonly>
                                </div>
                                <label for="tglNota" class="col-sm-2 col-form-label"> Tanggal Nota</label>
                                <div class="col-sm-4">
                                    <input type="date" name="tglNota" class="form-control" id="tglNota" value="<?= isset($_GET['tgl']) ? $_GET['tgl'] : date('Y-m-d') ?>" required>
                                </div>
                            </div>
                            <div class="form-group row mb-2">
                                <label for="barcode" class="col-sm-2 col-form-label">Barcode</label>
                                <div class="col-sm-10 input-group">
                                    <input type="text" name="barcode" value="<?= $kode ?>" class="form-control" placeholder="Masukkan barcode barang" id="barcode">
                                    <div class="input-group-append">
                                        <span class="input-group-text" id="icon-barcode"><i class="fas fa-barcode"></i></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="card card-outline card-danger pt-3 px-3 pb-2">
                            <h6 class="font-weight-bold text-right">Total Penjualan</h6>
                            <h1 class="font-weight-bold text-right" id="totalPenjualan" style="font-size: 40pt;">
                                <input type="hidden" id="total" name="total" value="<?= totalJual($nojual) ?>">
                                <?= number_format(totalJual($nojual) ?? 0, 0, ',', '.') ?>
                            </h1>
                        </div>
                    </div>

                </div>
                <div class="card pt-1 pb-2 px-3">
                    <div class="row">
                        <div class="col-lg-4">
                            <div class="form-group">
                                <input type="hidden" value="<?= isset($selectBrg['barcode']) ? $selectBrg['barcode'] : '' ?>" name="barcode">
                                <label for="namaBrg">Nama Barang</label>
                                <input type="text" name="namaBrg" class="form-control form-control-sm" id="namaBrg" value="<?= isset($selectBrg['nama_barang']) ? $selectBrg['nama_barang'] : '' ?>" readonly>
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
                                <input type="text" name="satuan" class="form-control form-control-sm" id="satuan" value="<?= isset($selectBrg['satuan']) ? $selectBrg['satuan'] : '' ?>" readonly>
                            </div>
                        </div>
                        <div class="col-lg-2">
                            <div class="form-group">
                                <label for="harga">Harga</label>
                                <input type="number" name="harga" class="form-control form-control-sm" id="harga" value="<?= isset($selectBrg['harga_jual']) ? $selectBrg['harga_jual'] : '' ?>" readonly>
                            </div>
                        </div>
                        <div class="col-lg-2">
                            <div class="form-group">
                                <label for="qty">Qty</label>
                                <input type="number" name="qty" class="form-control form-control-sm" id="qty" value="<?= isset($selectBrg['harga_jual']) ? 1 : '' ?>" min="1">

                            </div>
                        </div>
                        <div class="col-lg-2">
                            <div class="form-group">
                                <label for="jmlHarga">Jumlah Harga</label>
                                <input type="number" name="jmlHarga" class="form-control form-control-sm" id="jmlHarga" value="<?= isset($selectBrg['harga_jual']) ? $selectBrg['harga_jual'] : '' ?>" readonly>
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
                            $brgDetail = getData("SELECT * FROM tbl_jual_detail WHERE no_jual = '$nojual'");

                            foreach ($brgDetail as $detail){ ?>  
                            <tr>
                                <td><?= $no++ ?></td>
                                <td><?= $detail['nama_brg'] ?></td>
                                <td class="text-right"><?= number_format($detail['harga_jual'],0,',','.') ?></td>
                                <td class="text-right">
                                    <?= $detail['qty'] ?>
                                </td>
                                <td class="text-right"><?= number_format($detail['jml_harga'],0,',','.') ?></td>
                                <td class="text-right"> <a href="index.php?page=penjualan&barcode=<?= $detail['barcode'] ?>&idjual=<?= $detail['no_jual'] ?>&qty=<?= $detail['qty'] ?>&tgl=<?= $detail['tgl_jual'] ?>&msg=deleted" class="btn btn-sm btn-danger" title="hapus barang" onclick="return confirm('Anda yakin akan menghapus barang ini ?')"><i class="fas fa-trash"></i></a></td>
                            </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
                <div class="row">
                    <div class="col-lg-4 p2">
                        <div class="form-group row mb-2">
                            <label for="costumer" class="col-sm-3 col-form-label col-form-label-sm">Costumer</label>
                            <div class="col-sm-9">
                                <select name="costumer" id="costumer" class="form-control form-control-sm">
                                    
                                    <?php
                                    $costumers = getData("SELECT * FROM tbl_costumer");
                                    foreach($costumers as $costumer){ ?>
                                        <option value="<?= htmlspecialchars($costumer['nama']) ?>"><?= htmlspecialchars($costumer['nama']) ?></option>
                                    <?php } ?>
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
                    <div class="col-lg-4 py-2 px3">
                        <div class="form-group row mb-2">
                            <label for="bayar" class="col-sm-3 col-form-label">Bayar</label>
                            <div class="col-sm-9">
                                <input type="number" name="bayar" class="form-control form-control-sm text-right" id="bayar">
                            </div>
                        </div>
                        <div class="form-group row mb-2">
                            <label for="kembalian" class="col-sm-3 col-form-label">Kembalian</label>
                            <div class="col-sm-9">
                            <input type="number" name="kembalian" class="form-control form-control-sm text-right" id="kembalian" readonly>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 p-2">
                        <button type="submit" name="simpan" id="simpan" class="btn btn-primary btn-sm btn-block"><i class="fa fa-save"></i> Simpan</button>
                    </div>
                </div>
            </form>
        </div>
    </section>

    <script>
        let barcode = document.getElementById('barcode');
        let tgl = document.getElementById('tglNota');
        let qty  = document.getElementById('qty');
        let harga  = document.getElementById('harga');
        let jmlHarga  = document.getElementById('jmlHarga');
        let bayar  = document.getElementById('bayar');
        let kembalian  = document.getElementById('kembalian');
        let total  = document.getElementById('total');

        barcode.addEventListener('change', function(){
            document.location.href = 'index.php?page=penjualan&barcode=' + barcode.value + '&tgl=' + tgl.value;
        });


document.getElementById('bayar').addEventListener('input', function() {
    let total = parseFloat(document.getElementById('total').value);
    let bayar = parseFloat(this.value);
    let kembalian = bayar - total;

    document.getElementById('kembalian').value = kembalian > 0 ? kembalian : 0;
});

document.getElementById('qty').addEventListener('input', function() {
    let harga = parseFloat(document.getElementById('harga').value);
    let qty = parseInt(this.value);
    document.getElementById('jmlHarga').value = harga * qty;
});



    </script>
<?php
require "template/footer.php";
?>
