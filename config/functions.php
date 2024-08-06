<?php

function uploadimg($url = null)
{
    $namafile = $_FILES['image']['name'];
    $ukuran = $_FILES['image']['size'];
    $tmp = $_FILES['image']['tmp_name'];

    // Validasi file gambar yang boleh di upload
    $ekstensiGambarValid = ['jpg', 'jpeg', 'png', 'gif'];
    $ekstensiGambar = explode('.', $namafile);
    $ekstensiGambar = strtolower(end($ekstensiGambar));
    if (!in_array($ekstensiGambar, $ekstensiGambarValid)) {
        if ($url != null) {
            echo '<script>
                    alert("File yang anda upload bukan gambar, Data gagal diupdate!");
                    document.location.href = "' . $url . '";
                  </script>';
            die();
        } else {
            echo '<script>
                    alert("File yang anda upload bukan gambar, Data gagal ditambahkan!");
                  </script>';
            return false;
        }
    }

    // Validasi ukuran gambar max 1MB
    if ($ukuran > 1000000) {
        if ($url != null) {
            echo '<script>
                    alert("Ukuran gambar melebihi 1MB, Data gagal diupdate!");
                    document.location.href = "' . $url . '";
                  </script>';
            die();
        } else {
            echo '<script>
                    alert("Ukuran gambar tidak boleh melebihi 1 MB");
                  </script>';
            return false;
        }
    }

    $namaFileBaru = rand(10, 1000) . '-' . $namafile;

    // Pindahkan file yang diupload ke direktori tujuan
    move_uploaded_file($tmp, '../assets/image/' . $namaFileBaru);
    return $namaFileBaru;
}

function getData($sql){
    global $koneksi;

    $result = mysqli_query($koneksi, $sql);
    $rows = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $rows[] = $row;
    }
    return $rows;
}

function userLogin(){
    if (isset($_SESSION["ssUserPOS"])) {
        $userActive = $_SESSION["ssUserPOS"];
        $dataUser = getData("SELECT * FROM tbl_user WHERE username = '$userActive'");
        if (!empty($dataUser)) {
            return $dataUser[0];
        }
    }
    return null;
}

function userMenu(){
    $uri_path = parse_url($_SESSION['REQUEST_URI'], PHP_URL_PATH);
    $uri_segments = explode('/', $uri_path);
    $menu  = $uri_segments[2];
    return $menu;
}

function menuHome(){
    if (userMenu() == 'dashboard.php'){
        $result = 'active';
    }else{
        $result = null;
    }
     return $result;
}



function menuSetting(){
    if (userMenu() == 'user') {
        $result = 'menu-is-opening menu-open';
    } else {
        $result = null;
    }
    return $result;
}

function menuUser(){
    if (userMenu() == 'user'){
        $result = 'active';
    }else{
        $result = null;
    }
     return $result;
}

