<?php

function genereteNo(){
    global $koneksi;

    // Ambil nomor pembelian terbesar dari database
    $queryNo = mysqli_query($koneksi, "SELECT max(no_beli) as maxno FROM tbl_beli_head");
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
    $newNo = 'PB' . sprintf("%04s", $noUrut);

    return $newNo;
}

?>
