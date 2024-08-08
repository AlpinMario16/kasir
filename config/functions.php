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
    // Mendapatkan nama file yang sedang dibuka
    $current_page = basename($_SERVER['PHP_SELF']);

    if ($current_page == 'data-supplier.php' || $current_page == 'edit-supplier.php' || $current_page == 'add-supplier.php') {
        return 'supplier';
    } elseif ($current_page == 'data-customer.php' || $current_page == 'edit-customer.php' || $current_page == 'add-customer.php') {
        return 'customer';
    } elseif ($current_page == 'data-barang.php' || $current_page == 'edit-barang.php' || $current_page == 'add-barang.php') {
        return 'barang';
    }
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
    $currentMenu = userMenu();
    if ($currentMenu == 'supplier' || $currentMenu == 'customer' || $currentMenu == 'barang') {
        return 'menu-is-opening menu-open';
    }
    return null;
}



function menuCostumer()
{
    if (userMenu() == 'costumer') {
        $result = 'active';
    } else {
        $result = null;
    }
    return $result;
}


