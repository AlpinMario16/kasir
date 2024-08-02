<?php

function insert($data){
    global $koneksi;

    $username = strtolower(mysqli_real_escape_string($koneksi, $data['username']));
    $fullname = mysqli_real_escape_string($koneksi, $data['fullname']);
    $password = mysqli_real_escape_string($koneksi, $data['password']);
    $password2 = mysqli_real_escape_string($koneksi, $data['password2']);
    $level = mysqli_real_escape_string($koneksi, $data['level']);
    $address = mysqli_real_escape_string($koneksi, $data['address']);
    $gambar = mysqli_real_escape_string($koneksi, $_FILES['image'] ['name']);

    if ($password !== $password2){

        echo "<script>
                alert('konfirmasi password tidak sesuai , user baru gagal di registrasi !');
              </script>";
        return false;
    }

    $pass = password_hash($password, PASSWORD_DEFAULT);

    $cekUsername = mysqli_query($koneksi, "SELECT  username FROM tbl_user WHERE username ='$username'");
    if (mysqli_num_rows($cekUsername) > 0) {
        echo "<script>
                alert('username sudah terpakai , user baru gagal di registrasi !');
              </script>";
        return false;
    }

    if ($gambar != null) {
        $gambar =uploadimg();
    } else {
        $gambar = 'default.png';
    }

    // gambar tidak sesuai validasi 
    if ($gambar == ''){
        return false;
    }

    $sqlUser  = "INSERT INTO tbl_user VALUE (null, '$username', '$fullname', '$pass','$address', '$level','$gambar')";
    mysqli_query($koneksi, $sqlUser);

    return mysqli_affected_rows($koneksi);
}

function delete($id, $foto) {
    global $koneksi;

    // Pastikan $id tidak kosong dan numerik
    if (empty($id) || !is_numeric($id)) {
        return false;
    }

    // Menghapus user dari database
    $sqlDel = "DELETE FROM tbl_user WHERE userid = $id";
    mysqli_query($koneksi, $sqlDel);

    // Menghapus file gambar jika bukan gambar default
    if ($foto != 'default.png') {
        $filePath = '../assets/image/' . $foto;
        if (file_exists($filePath)) {
            unlink($filePath);
        }
    }

    return mysqli_affected_rows($koneksi);
}
?>
?>