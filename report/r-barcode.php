<?php
session_start();

if (!isset($_SESSION["ssLoginPOS"])) {
    header("location: ../auth/login.php");
    exit();
}

// Sanitasi dan validasi input dari GET
$jmlCetak = isset($_GET['jmlCetak']) && is_numeric($_GET['jmlCetak']) ? (int)$_GET['jmlCetak'] : 1;
$barcode = isset($_GET['barcode']) ? htmlspecialchars($_GET['barcode']) : '';

if (empty($barcode)) {
    die("Barcode tidak ditemukan.");
}

require 'assets/barcodeGenerator/vendor/autoload.php';
$generator = new Picqer\Barcode\BarcodeGeneratorPNG();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Print Barcode</title>
    <style>
        .barcode-container {
            text-align: center;
            width: 210px;
            display: inline-block;
            margin-right: 30px;
            margin-bottom: 30px;
        }
        .barcode-image {
            width: 200px;
        }
    </style>
</head>
<body>

<?php 
for ($i = 1; $i <= $jmlCetak; $i++) { ?>
    <div class="barcode-container">
        <img src="data:image/png;base64,<?= base64_encode($generator->getBarcode($barcode, $generator::TYPE_CODE_128)) ?>" class="barcode-image">
        <div><?= $barcode ?></div>
    </div>
<?php
}
?>

<script>
    window.print();
</script>

</body>
</html>
