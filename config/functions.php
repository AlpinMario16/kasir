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
    // Periksa apakah 'ssUserPOS' ada dalam sesi
    if (isset($_SESSION["ssUserPOS"])) {
        $userActive = $_SESSION["ssUserPOS"];
        
        // Ambil data user berdasarkan username
        $result = getData("SELECT * FROM tbl_user WHERE username = '$userActive'");
        
        // Periksa apakah hasil query tidak kosong dan elemen pertama ada
        if (!empty($result) && isset($result[0])) {
            return $result[0];
        } else {
            // Tangani kasus di mana data user tidak ditemukan
            return null; // atau Anda bisa mengembalikan nilai lain sesuai kebutuhan
        }
    } else {
        // Tangani kasus di mana 'ssUserPOS' tidak ada dalam sesi
        return null; // atau Anda bisa mengembalikan nilai lain sesuai kebutuhan
    }
}

function userMenu()
{
    $uri = $_SERVER['REQUEST_URI']; // Mendapatkan URI saat ini
    $uriSegments = explode('/', $uri); // Memisahkan URI menjadi segmen-segmen
    $page = end($uriSegments); // Mengambil segmen terakhir dari URI

    // Menentukan menu yang aktif berdasarkan nama halaman
    if (strpos($page, 'data-supplier') !== false) {
        return 'supplier';
    }
    // Tambahkan kondisi lain jika diperlukan
    // if (strpos($page, 'data-customer') !== false) {
    //     return 'customer';
    // }

    return null;
}


function menuSupplier()
{
    if (userMenu() == 'supplier') {
        $result = 'active';
    } else {
        $result = null;
    }
    return $result;
}

function menuMaster()
{
    if (userMenu() == 'supplier') {
        $result = 'menu-is-opening menu-open';
    } else {
        $result = null;
    }
    return $result;
}


