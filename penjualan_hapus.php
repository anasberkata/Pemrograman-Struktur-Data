<?php
require "functions.php";

// DELETE PRODUK
$id_penjualan = $_GET['id_penjualan'];

// AMBIL DATA PENJUALAN
$penjualan = "SELECT * FROM `penjualan` WHERE `id_penjualan` = '$id_penjualan'";
$data_penjualan = mysqli_query($conn, $penjualan);
$item = mysqli_fetch_all($data_penjualan, MYSQLI_ASSOC)[0];

$qty_penjualan = $item['qty_penjualan'];
$produk_id = $item['produk_id'];

$hapus_penjualan = "DELETE FROM `penjualan` WHERE `id_penjualan` = '$id_penjualan'";

// UPDATE QTY DI PRODUK
$update_qty_produk = "UPDATE `produk` SET `qty` = `qty` + '$qty_penjualan' WHERE `id_produk` = '$produk_id'";

if (mysqli_query($conn, $hapus_penjualan) && mysqli_query($conn, $update_qty_produk)) {
    header("Location: penjualan.php");
    exit();
} else {
    echo "Error: " . $hapus_penjualan . "<br>" . mysqli_error($conn);
    echo "<br>";
    echo "Error: " . $update_qty_produk . "<br>" . mysqli_error($conn);
}