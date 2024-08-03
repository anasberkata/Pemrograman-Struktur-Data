<?php
require "functions.php";
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Tambah Penjualan</title>
</head>

<body>
    <ul>
        <li><a href="index.php">Beranda</a></li>
        <li><a href="produk.php">Produk</a></li>
        <li><a href="penjualan.php">Penjualan</a></li>
    </ul>

    <h1>Tambah Penjualan</h1>
    <form action="" method="POST">
        <table>
            <tr>
                <td><label>Tanggal</label></td>
                <td><input type="date" name="tgl_penjualan"></td>
            </tr>
            <tr>
                <td><label>Nama Produk</label></td>
                <td>
                    <select name="id_produk">
                        <?php foreach ($data_produk as $p): ?>
                            <option value="<?= $p['id_produk'] ?>"><?= $p['nama_produk'] ?> | Qty : <?= $p['qty'] ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </td>
            </tr>
            <tr>
                <td><label>Qty Penjualan</label></td>
                <td><input type="number" name="qty_penjualan"></td>
            </tr>
            <tr>
                <td><button type="submit" name="tambah_penjualan">Tambah</button></td>
            </tr>
        </table>
    </form>
</body>

</html>