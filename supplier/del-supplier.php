<?php
session_start();

if (!isset($_SESSION["ssLoginPOS"])) {
  header("location: ../auth/login.php");
  exit();
}

require "../config/config.php";
require "../config/functions.php";
require "../module/module-supplier.php";

$id = $_GET['id'];

if(delete($id)) {
    echo "
    <script>document.location.href = 'data-supplier.php?msg=deleted';</script>
    ";
}else{
    echo "
    <script>document.location.href = 'data-supplier.php?msg=deleted';</script>
    ";
}