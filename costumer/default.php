<?php

$page = isset($_GET["act"]) ? $_GET["act"] : '';
switch ($page) {


    case 'create':
        include('costumer/add-costumer.php');
        break;
    case 'edit':
        include('costumer/edit-costumer.php');
        break;
    case 'delete':
        include('costumer/del-costumer.php');
        break;
    default:
        include('data-costumer.php');
}