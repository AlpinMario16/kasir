<?php

function uploadimg(){
    $namafile = $_FILES['image']['name'];
    $ukuran = $_FILES['image']['size'];
    $tmp = $_FILES['image']['tmp_name'];

    // validasi file gambar yang boleh di upload
    $ekstensiGambarValid = ['jpg', 'jpeg', 'png', 'gif'];
    $ekstensiGambar = explode('.', $namafile);
    $ekstensiGambar = strtolower(end($ekstensiGambar));
    if (!in_array($ekstensiGambar, $ekstensiGambarValid)) {
        echo '<script>
                alert("file yang anda upload bukan gambar, Data gagal ditambahkan!");
              </script>';
        return false;
    }

    // validasi ukuran gambar max 1mb
    if ($ukuran > 1000000) {
        echo '<script>
                alert("Ukuran gambar tidak boleh melebihi 1 MB");
              </script>';
        return false;
    }

    $namaFileBaru = rand(10, 1000) . '-' . $namafile;

    // Use the correct variable name $tmp instead of $stmp
    move_uploaded_file($tmp, '../assets/image/' . $namaFileBaru);
    return $namaFileBaru;
}

function getData($sql){
    global $koneksi;
         
    $result = mysqli_query($koneksi, $sql);
    $rows =[];
    while ($row = mysqli_fetch_assoc($result)){
        $rows[] = $row;
    }
    return $rows;
}
?>
