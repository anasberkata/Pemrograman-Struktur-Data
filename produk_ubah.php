<?php
require "functions.php";

$id_produk = $_GET['id_produk'];

// SHOW PRODUK
$produk = "SELECT * FROM `produk` WHERE `id_produk` = '$id_produk'";
$data_produk = mysqli_query($conn, $produk);
$item = mysqli_fetch_all($data_produk, MYSQLI_ASSOC)[0];
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Ubah Produk</title>
</head>

<body>
    <ul>
        <li><a href="index.php">Beranda</a></li>
        <li><a href="produk.php">Produk</a></li>
        <li><a href="penjualan.php">Penjualan</a></li>
    </ul>

    <h1>Ubah Produk</h1>
    <form action="" method="POST">

        <input type="hidden" name="id_produk" value="<?= $item['id_produk'] ?>">

        <table>
            <tr>
                <td><label>Nama Produk</label></td>
                <td><input type="text" name="nama_produk" value="<?= $item['nama_produk'] ?>"></td>
            </tr>
            <tr>
                <td><label>Qty</label></td>
                <td><input type="text" name="qty" value="<?= $item['qty'] ?>"></td>
            </tr>
            <tr>
                <td><label>Harga Dasar (Rp.)</label></td>
                <td><input type="text" name="harga_dasar" value="<?= $item['harga_dasar'] ?>"></td>
            </tr>
            <tr>
                <td><label>Harga Jual (Rp.)</label></td>
                <td><input type="text" name="harga_jual" value="<?= $item['harga_jual'] ?>"></td>
            </tr>
            <tr>
                <td><button type="submit" name="ubah_produk">Ubah</button></td>
            </tr>
        </table>
    </form>
</body>

</html>