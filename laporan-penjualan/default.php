<?php

$page = isset($_GET["act"]) ? $_GET["act"] : '';
switch ($page) {


    case 'create':
        include('laporan-penjualan/form-barang.php');
        break;
    case 'edit':
        include('laporan-penjualan/detail-penjualan.php');
        break;
    case 'print':
        include('report/r-jual.php');
        break;
    case 'detail':
        include('laporan-penjualan/detail-penjualan.php');
        break;
    
    default:
        include('laporan-penjualan/index.php');
}