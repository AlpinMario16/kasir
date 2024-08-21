<?php

$page = isset($_GET["act"]) ? $_GET["act"] : '';
switch ($page) {


    case 'create':
        include('supplier/add-supplier.php');
        break;
    case 'edit':
        include('supplier/edit-supplier.php');
        break;
    case 'delete':
        include('supplier/del-supplier.php');
        break;
    default:
        include('data-supplier.php');
}