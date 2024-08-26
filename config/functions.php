<?php

function uploadimg($url = null, $name = null)
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

    if ($name != null ) {
            $namaFileBaru = $name . '-'. $ekstensiGambar;
    } else {
        $namaFileBaru = rand(10, 1000) . '-' . $namafile;
    }

    $namaFileBaru = rand(10, 1000) . '-' . $namafile;

    // Pindahkan file yang diupload ke direktori tujuan
    move_uploaded_file($tmp, 'assets/image/' . $namaFileBaru);
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
    $current_page = basename($_SERVER['PHP_SELF']);
    $page = isset($_GET['page']) ? $_GET['page'] : '';

    if (strpos($current_page, 'supplier') !== false || $page === 'supplier') {
        return 'supplier';
    }
    
    if (strpos($current_page, 'costumer') !== false || $page === 'costumer') {
        return 'costumer';
    }
    
    if (strpos($current_page, 'barang') !== false || $page === 'barang') {
        return 'barang';
    }
    
    return null;
}




function menuSupplier() {
    return (isset($_GET['page']) && $_GET['page'] === 'supplier') ? 'active' : '';
}
function menuCostumer() {
    return (isset($_GET['page']) && $_GET['page'] === 'costumer') ? 'active' : '';
}

function menuBarang() {
    return (isset($_GET['page']) && $_GET['page'] === 'barang') ? 'active' : '';
}

function menuMaster()
{
    if (userMenu() == 'supplier' || userMenu() == 'costumer' || userMenu() == 'barang') {
        $result = 'menu-is-opening menu-open';
    } else {
        $result = null;
    }
    return $result;
}




function insertJual($data) {
    global $conn; // Menggunakan koneksi database global

    $nojual = $data['nojual'];
    $kodeBrg = $data['kodeBrg'];
    $qty = $data['qty'];
    $harga = $data['harga'];
    $jmlHarga = $data['jmlHarga'];
    $tglNota = $data['tglNota'];

    // Query untuk memasukkan data penjualan ke dalam tabel penjualan
    $query = "INSERT INTO tbl_jual_detail (no_jual, kode_brg, qty, harga_jual, jml_harga, tgl) 
              VALUES ('$nojual', '$kodeBrg', '$qty', '$harga', '$jmlHarga', '$tglNota')";
    
    return mysqli_query($conn, $query);
}

function in_date($tgl){
    $tg  = substr($tgl, 8, 2);
    $bln  = substr($tgl, 5, 2);
    $thn  = substr($tgl, 0, 4);
    return $tg . "-" . $bln . "-" . $thn;
}

