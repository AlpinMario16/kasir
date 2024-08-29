<?php

$page = isset($_GET["act"]) ? $_GET["act"] : '';
switch ($page) {


    case 'view':
        include('penjualan/index.php');
        break;
    case 'edit':
        include('laporan-pembelian/detail-pembelian.php');
        break;
    case 'report':
        include('report/r-struk.php');
        break;
    case 'detail':
        include('laporan-pembelian/detail-pembelian.php');
        break;
    
    default:
        include('penjualan/index.php');
}