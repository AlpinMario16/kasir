<?php

$page = isset($_GET["act"]) ? $_GET["act"] : '';
switch ($page) {


    case 'create':
        include('barang/form-barang.php');
        break;
    case 'edit':
        include('barang/form-barang.php');
        break;
    case 'delete':
        include('barang/form-barang.php');
        break;
    default:
        include('barang/index.php');
}