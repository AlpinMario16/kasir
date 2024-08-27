<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- <title>Loading</title> -->
    <link rel="stylesheet" href="style.css">
</head>
<body>
    
    <!-- <div class="loading">
        <div class="title">Loading..</div>
        <div class="progress-bar">
            <div class="progress"></div>
        </div>
    </div> -->

    <!-- <script src="script.js"></script> -->

    <?php
        if (isset($_GET['page'])) {
            switch ($_GET['page']) {
                case 'dashboard':
                    include('dashboard.php');
                    break;
                case 'barang':
                    include('barang/default.php');
                    break;
                case 'supplier':
                    include('supplier/default.php');
                    break;
                 case 'costumer':
                     include('costumer/default.php');
                     break;
                case 'user':
                    include('user/default.php');
                    break;
                case 'penjualan':
                     include('penjualan/default.php');
                     break;
                case 'pembelian':
                    include('pembelian/index.php');
                    break;
                case 'gantipw':
                    include('auth/change-password.php');
                    break;
                case 'barcode':
                    include('report/r-barcode.php');
                    break;
                case 'laporan-pembelian':
                    include('laporan-pembelian/default.php');
                     break;
                 case 'laporan-penjualan':
                    include('laporan-penjualan/default.php');
                        break;
                case 'detail-pembelian':
                    include('laporan-pembelian/detail-pembelian.php');
                    break;
                case 'print':
                    include('report/r-beli.php');
                     break;
                    
                default:
                    include('dashboard.php');
            }
        } else {
            include('dashboard.php');  // Halaman default jika 'page' tidak disetel
        }
        ?>


</body>
</html>