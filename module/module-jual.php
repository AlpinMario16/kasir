<?php

function genereteNo(){
    global $koneksi;

    // Ambil nomor pembelian terbesar dari database
    $queryNo = mysqli_query($koneksi, "SELECT max(no_jual) as maxno FROM tbl_jual_head");
    $row = mysqli_fetch_assoc($queryNo);
    $maxno = $row['maxno'];

    // Jika $maxno adalah null, set $maxno menjadi 'PB0000'
    if ($maxno === null) {
        $maxno = 'PB0000';
    }

    // Ambil nomor urut dari $maxno, kemudian increment
    $noUrut = (int) substr($maxno, 2, 4);
    $noUrut++;
    
    // Format nomor pembelian baru dengan prefiks 'PB'
    $newNo = 'PJ' . sprintf("%04s", $noUrut);

    return $newNo;
}

function insert($data) {
    global $koneksi;

    $no  = mysqli_real_escape_string($koneksi, $data['nojual']);
    $tgl  = mysqli_real_escape_string($koneksi, $data['tglNota']);
    $kode  = mysqli_real_escape_string($koneksi, $data['barcode']);
    $nama  = mysqli_real_escape_string($koneksi, $data['namaBrg']);
    $qty  = isset($data['qty']) ? mysqli_real_escape_string($koneksi, $data['qty']) : 0;
    $harga  = isset($data['harga']) ? mysqli_real_escape_string($koneksi, $data['harga']) : 0;
    $jmlharga  = isset($data['jmlHarga']) ? mysqli_real_escape_string($koneksi, $data['jmlHarga']) : 0;
    $stok  = isset($data['stok']) ? mysqli_real_escape_string($koneksi, $data['stok']) : 0;


    // cek barang sudah di input atau belum
    $cekbrg = mysqli_query($koneksi, "SELECT * FROM tbl_jual_detail WHERE no_jual = '$no' AND barcode = '$kode'");
    if (mysqli_num_rows($cekbrg)) {
        echo "<script>
        alert('Barang sudah ada, Anda harus menghapusnya terlebih dahulu jika ingin mengubah jumlahnya.');
        </script>";
        return false;
    }


    // qty brg tidak boleh kosong

    if (empty($qty)) {
        echo "<script>
        alert('Qty tidak boleh kosong.');
        </script>";
        return false;
    } else if ($qty > $stok){
        echo "<script>
        alert('stok barang tidak mencukupi');
        </script>";
        return false;
    } else {
        $sqlJual  = "INSERT INTO tbl_jual_detail VALUES (null, '$no', '$tgl', '$kode', '$nama', $qty, $harga, $jmlharga)";
        mysqli_query($koneksi, $sqlJual);
    }

    mysqli_query($koneksi, "UPDATE tbl_barang SET stock = stock - $qty WHERE barcode = '$kode'");

    return mysqli_affected_rows($koneksi);
}

function totalJual($nojual) {
    global $koneksi;

    $totalJual = mysqli_query($koneksi, "SELECT sum(jml_harga) AS total FROM tbl_jual_detail WHERE no_jual = '$nojual'");
    $data = mysqli_fetch_assoc($totalJual);
    $total = $data["total"];

    return $total;
}

function delete($barcode, $idjual, $qty) {
    global $koneksi;

    $sqlDel = "DELETE FROM tbl_jual_detail WHERE barcode = '$barcode' AND no_jual = '$idjual'";
    mysqli_query($koneksi, $sqlDel);

    mysqli_query($koneksi, "UPDATE tbl_barang SET stock = stock + $qty WHERE barcode = '$barcode'");

    return mysqli_affected_rows($koneksi);
}