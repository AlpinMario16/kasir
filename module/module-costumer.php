<?php


function insert($data){
    global $koneksi;

    $nama   = mysqli_real_escape_string($koneksi, $data['nama']);
    $telpon   = mysqli_real_escape_string($koneksi, $data['telpon']);
    $alamat   = mysqli_real_escape_string($koneksi, $data['alamat']);
    $ketr   = mysqli_real_escape_string($koneksi, $data['ketr']);

    $sqlCostumer  = "INSERT INTO tbl_costumer VALUES (null,'$nama','$telpon','$ketr','$alamat')";
    mysqli_query($koneksi, $sqlCostumer);

    return mysqli_affected_rows($koneksi);


}

function delete($id){
    global $koneksi;

    $sqlDelete = "DELETE FROM tbl_costumer WHERE id_costumer = $id";
    mysqli_query($koneksi, $sqlDelete);

    return mysqli_affected_rows($koneksi);
}

function update($data) {
    global $koneksi;

    // Periksa apakah 'id' tersedia di array $data
    if (!isset($data['id'])) {
        throw new Exception('ID tidak ditemukan di array data.');
    }

    $id = mysqli_real_escape_string($koneksi, $data['id']);
    $nama = isset($data['nama']) ? mysqli_real_escape_string($koneksi, $data['nama']) : '';
    $telpon = isset($data['telpon']) ? mysqli_real_escape_string($koneksi, $data['telpon']) : '';
    $alamat = isset($data['alamat']) ? mysqli_real_escape_string($koneksi, $data['alamat']) : '';
    $ketr = isset($data['ketr']) ? mysqli_real_escape_string($koneksi, $data['ketr']) : '';

    // Cek jika id tidak kosong atau null
    if (empty($id)) {
        throw new Exception('ID Supplier tidak boleh kosong.');
    }

    // Buat query update
    $sqlCostumer = "UPDATE tbl_costumer SET
        nama = '$nama',
        telpon = '$telpon',
        deskripsi = '$ketr',
        alamat = '$alamat'
        WHERE id_costumer = '$id'
    ";

    // Eksekusi query
    if (!mysqli_query($koneksi, $sqlCostumer)) {
        throw new mysqli_sql_exception('Error: ' . mysqli_error($koneksi));
    }

    return mysqli_affected_rows($koneksi);
}
