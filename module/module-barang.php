<?php

function generateId(){
    global $koneksi;

    // Ambil ID maksimal dari database
    $queryId = mysqli_query($koneksi, "SELECT max(id_barang) as maxid FROM tbl_barang");
    $data = mysqli_fetch_array($queryId);
    $maxid = $data['maxid'];

    // Jika maxid belum ada (belum ada data di database), mulai dari 1
    if ($maxid == null) {
        $noUrut = 1;
    } else {
        // Ambil angka setelah 'BRG-' dan konversi ke integer
        $noUrut = (int) substr($maxid, 4);
        $noUrut++;
    }

    // Buat ID baru dengan format 'BRG-XXX'
    $newId = "BRG-" . sprintf("%03s", $noUrut);

    return $newId;
}





function insert($data) {
    global $koneksi;

    // Tambahkan log debug
    error_log("insert() called with data: " . print_r($data, true));

    // Validasi data
    if (empty($data['kode']) || empty($data['barcode']) || empty($data['name']) || empty($data['satuan']) || empty($data['harga_beli']) || empty($data['harga_jual']) || empty($data['stock_minimal'])) {
        echo '<script>alert("Data tidak lengkap, barang gagal ditambahkan")</script>';
        return false;
    }

    // Escape semua input data
    $id = mysqli_real_escape_string($koneksi, $data['kode']);
    $barcode = mysqli_real_escape_string($koneksi, $data['barcode']);
    $nama_barang = mysqli_real_escape_string($koneksi, $data['name']);
    $satuan = mysqli_real_escape_string($koneksi, $data['satuan']);
    $harga_beli = mysqli_real_escape_string($koneksi, $data['harga_beli']);
    $harga_jual = mysqli_real_escape_string($koneksi, $data['harga_jual']);
    $stockmin = mysqli_real_escape_string($koneksi, $data['stock_minimal']);
    $gambar = isset($_FILES['image']['name']) ? mysqli_real_escape_string($koneksi, $_FILES['image']['name']) : '';

    // Cek apakah barcode sudah ada di database
    $cekBarcode = mysqli_query($koneksi, "SELECT * FROM tbl_barang WHERE barcode = '$barcode'");
    if (mysqli_num_rows($cekBarcode) > 0) {
        echo '<script>alert("Kode barcode sudah ada, barang gagal ditambahkan")</script>';
        return false;
    }

    // Upload gambar barang
    if ($gambar) {
        $gambar = uploadimg(null, $id);
    } else {
        $gambar = 'default-brg.jpg';
    }

    // Validasi apakah gambar berhasil di-upload
    if ($gambar === '') {
        return false;
    }

    // Insert data ke tabel tbl_barang
    $sqlBrg = "INSERT INTO tbl_barang (id_barang, barcode, nama_barang, harga_beli, harga_jual, stock, satuan, stock_minimal, gambar) 
               VALUES ('$id', '$barcode', '$nama_barang', '$harga_beli', '$harga_jual', '0', '$satuan', '$stockmin', '$gambar')";

    // Menjalankan query
    mysqli_query($koneksi, $sqlBrg);

    // Mengembalikan jumlah baris yang terpengaruh oleh query
    return mysqli_affected_rows($koneksi);
}

function delete($id, $gbr){
    global $koneksi;

    // Jalankan query DELETE
    $sqlDel = "DELETE FROM tbl_barang WHERE id_barang = '$id'";
    $result = mysqli_query($koneksi, $sqlDel);

    // Periksa apakah penghapusan berhasil
    if ($result) {
        // Hapus gambar jika bukan gambar default
        if ($gbr != 'default-brg.jpg' && file_exists('../assets/image/' . $gbr)) {
            unlink('../assets/image/' . $gbr);
        }
    } else {
        // Log atau beri tahu pengguna jika penghapusan gagal
        error_log("Gagal menghapus barang dengan ID $id: " . mysqli_error($koneksi));
    }

    // Kembalikan jumlah baris yang terpengaruh
    return mysqli_affected_rows($koneksi);
}

function update($data){
    global $koneksi;

    $id = mysqli_real_escape_string($koneksi, $data['kode']);
    $barcode = mysqli_real_escape_string($koneksi, $data['barcode']);
    $nama_barang = mysqli_real_escape_string($koneksi, $data['name']);
    $satuan = mysqli_real_escape_string($koneksi, $data['satuan']);
    $harga_beli = mysqli_real_escape_string($koneksi, $data['harga_beli']);
    $harga_jual = mysqli_real_escape_string($koneksi, $data['harga_jual']);
    $stockmin = mysqli_real_escape_string($koneksi, $data['stock_minimal']);
    $gbrLama = mysqli_real_escape_string($koneksi, $data['oldImg']);
    $gambar = isset($_FILES['image']['name']) ? mysqli_real_escape_string($koneksi, $_FILES['image']['name']) : '';

    // cek barcode lama
    $queryBarcode = mysqli_query($koneksi, "SELECT *FROM tbl_barang WHERE id_barang = '$id'");
    $dataBrg = mysqli_fetch_assoc($queryBarcode);
    $curBarcode = $dataBrg['barcode'];
    // barcode baru
    $cekBarcode = mysqli_query($koneksi, "SELECT * FROM tbl_barang WHERE barcode = '$barcode'");

    // jika barcode  diganti
    if ($barcode !== $curBarcode) {


        if (mysqli_num_rows($cekBarcode) > 0) {
            echo '<script>alert("Kode barcode sudah ada, barang gagal diperbarui")</script>';
            return false;
        }
    }

    // cek gambar
    if ($gambar) {
        $url = "index.php";
        if ($gbrLama == 'default-barang.png') {
           $nmgbr = $id;
        } else {
            $nmgbr = $id . '-' . rand(10, 1000);
        }
        $imgBrg = uploadimg($url, $nmgbr);
        if ($gbrLama != 'default-barang.png') {
            @unlink('../assets/image/' .$gbrLama);
        }
    } else {
        $imgBrg = $gbrLama;
    }


    mysqli_query($koneksi, "UPDATE tbl_barang SET
                        barcode   ='$barcode',
                        nama_barang = '$nama_barang',
                        harga_beli = $harga_beli,
                        harga_jual = $harga_jual,
                        satuan  = '$satuan',
                        stock_minimal = $stockmin,
                        gambar  = '$imgBrg'
                        WHERE id_barang = '$id';
  ");

  return mysqli_affected_rows($koneksi);

    // Validasi apakah gambar berhasil di-upload
    
}



    
