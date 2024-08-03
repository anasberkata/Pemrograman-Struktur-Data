<?php
require "functions.php";

// DELETE PRODUK
$id_produk = $_GET['id_produk'];

$hapus_produk = "DELETE FROM `produk` WHERE `id_produk` = '$id_produk'";

if (mysqli_query($conn, $hapus_produk)) {
    header("Location: produk.php");
    exit();
} else {
    echo "Error: " . $hapus_produk . "<br>" . mysqli_error($conn);
}