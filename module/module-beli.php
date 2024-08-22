<?php

function genereteNo() {
    global $koneksi;

    $queryNo = mysqli_query($koneksi, "SELECT max(no_beli) as maxno FROM tbl_beli_head");
    $row = mysqli_fetch_assoc($queryNo);
    $maxno = $row['maxno'];

    if ($maxno === null) {
        $maxno = 'PB0000';
    }

    $noUrut = (int) substr($maxno, 2, 4);
    $noUrut++;
    
    $newNo = 'PB' . sprintf("%04s", $noUrut);

    return $newNo;
}

function totalBeli($nobeli) {
    global $koneksi;

    $totalBeli = mysqli_query($koneksi, "SELECT sum(jml_harga) AS total FROM tbl_beli_detail WHERE no_beli = '$nobeli'");
    $data = mysqli_fetch_assoc($totalBeli);
    $total = $data["total"];

    return $total;
}

function insert($data) {
    global $koneksi;

    $no  = mysqli_real_escape_string($koneksi, $data['nobeli']);
    $tgl  = mysqli_real_escape_string($koneksi, $data['tglNota']);
    $kode  = mysqli_real_escape_string($koneksi, $data['kodeBrg']);
    $nama  = mysqli_real_escape_string($koneksi, $data['namaBrg']);
    $qty  = isset($data['qty']) ? mysqli_real_escape_string($koneksi, $data['qty']) : 0;
    $harga  = isset($data['harga']) ? mysqli_real_escape_string($koneksi, $data['harga']) : 0;
    $jmlharga  = isset($data['jmlHarga']) ? mysqli_real_escape_string($koneksi, $data['jmlHarga']) : 0;

    $cekbrg = mysqli_query($koneksi, "SELECT * FROM tbl_beli_detail WHERE no_beli = '$no' AND kode_brg = '$kode'");
    if (mysqli_num_rows($cekbrg)) {
        echo "<script>
        alert('Barang sudah ada, Anda harus menghapusnya terlebih dahulu jika ingin mengubah jumlahnya.');
        </script>";
        return false;
    }

    if (empty($qty)) {
        echo "<script>
        alert('Jumlah barang tidak boleh kosong.');
        </script>";
        return false;
    } else {
        $sqlbeli  = "INSERT INTO tbl_beli_detail VALUES (null, '$no', '$tgl', '$kode', '$nama', $qty, $harga, $jmlharga)";
        mysqli_query($koneksi, $sqlbeli);
    }

    mysqli_query($koneksi, "UPDATE tbl_barang SET stock = stock + $qty WHERE id_barang = '$kode'");

    return mysqli_affected_rows($koneksi);
}

function delete($idbrg, $idbeli, $qty) {
    global $koneksi;

    $sqlDel = "DELETE FROM tbl_beli_detail WHERE kode_brg = '$idbrg' AND no_beli = '$idbeli'";
    mysqli_query($koneksi, $sqlDel);

    mysqli_query($koneksi, "UPDATE tbl_barang SET stock = stock - $qty WHERE id_barang = '$idbrg'");

    return mysqli_affected_rows($koneksi);
}

function simpan($data) {
    global $koneksi;

    $nobeli  = mysqli_real_escape_string($koneksi, $data['nobeli']);
    $tgl  = mysqli_real_escape_string($koneksi, $data['tglNota']);
    $total  = isset($data['total']) && is_numeric($data['total']) ? mysqli_real_escape_string($koneksi, $data['total']) : 0;
    $supplier  = mysqli_real_escape_string($koneksi, $data['supplier']);
    $keterangan  = isset($data['ketr']) ? mysqli_real_escape_string($koneksi, $data['ketr']) : '';

    $sqlbeli = "INSERT INTO tbl_beli_head (no_beli, tgl_beli, supplier, total, keterangan) VALUES ('$nobeli','$tgl','$supplier','$total','$keterangan')";
    mysqli_query($koneksi, $sqlbeli);

    return mysqli_affected_rows($koneksi);
}
?>
