<?php

$page = isset($_GET["act"]) ? $_GET["act"] : '';
switch ($page) {


    case 'create':
        include('laporan-pembelian/form-barang.php');
        break;
    case 'edit':
        include('laporan-pembelian/detail-pembelian.php');
        break;
    case 'print':
        include('report/r-beli.php');
        break;
    case 'delete':
        include('laporan-pembelian/form-barang.php');
        break;
    default:
        include('laporan-pembelian/index.php');
}