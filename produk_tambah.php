<?php
require "functions.php";
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Tambah Produk</title>
</head>

<body>
    <ul>
        <li><a href="index.php">Beranda</a></li>
        <li><a href="produk.php">Produk</a></li>
        <li><a href="penjualan.php">Penjualan</a></li>
    </ul>

    <h1>Tambah Produk</h1>
    <form action="" method="POST">
        <table>
            <tr>
                <td><label>Nama Produk</label></td>
                <td><input type="text" name="nama_produk"></td>
            </tr>
            <tr>
                <td><label>Qty</label></td>
                <td><input type="text" name="qty"></td>
            </tr>
            <tr>
                <td><label>Harga Dasar (Rp.)</label></td>
                <td><input type="text" name="harga_dasar"></td>
            </tr>
            <tr>
                <td><label>Harga Jual (Rp.)</label></td>
                <td><input type="text" name="harga_jual"></td>
            </tr>
            <tr>
                <td><button type="submit" name="tambah_produk">Tambah</button></td>
            </tr>
        </table>
    </form>
</body>

</html>