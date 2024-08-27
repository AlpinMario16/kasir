<?php

$page = isset($_GET["act"]) ? $_GET["act"] : '';
switch ($page) {


    case 'create':
        include('laporan-stock/form-barang.php');
        break;
    case 'edit':
        include('laporan-stock/detail-stock.php');
        break;
    case 'report':
        include('report/r-stock.php');
        break;
    case 'detail':
        include('laporan-stock/detail-stock.php');
        break;
    
    default:
        include('laporan-stock/index.php');
}