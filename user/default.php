<?php

$page = isset($_GET["act"]) ? $_GET["act"] : '';
switch ($page) {


    case 'create':
        include('user/add-user.php');
        break;
    case 'edit':
        include('user/edit-user.php');
        break;
    case 'delete':
        include('user/del-user.php');
        break;
    default:
        include('data-user.php');
}