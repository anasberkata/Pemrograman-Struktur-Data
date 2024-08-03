<?php
require "functions.php";

$id_penjualan = $_GET['id_penjualan'];

// SHOW PRODUK
$penjualan = "SELECT * FROM `penjualan` WHERE `id_penjualan` = '$id_penjualan'";
$data_penjualan = mysqli_query($conn, $penjualan);
$item = mysqli_fetch_all($data_penjualan, MYSQLI_ASSOC)[0];

$produk_id = $item['produk_id'];

$selected_id_produk = isset($produk_id) ? $produk_id : null;
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Ubah Penjualan</title>
</head>

<body>
    <ul>
        <li><a href="index.php">Beranda</a></li>
        <li><a href="produk.php">Produk</a></li>
        <li><a href="penjualan.php">Penjualan</a></li>
    </ul>

    <h1>Ubah Penjualan</h1>
    <form action="" method="POST">
        <table>

            <input type="hidden" name="id_penjualan" value="<?= $item['id_penjualan'] ?>">
            <input type="hidden" name="qty_penjualan_lama" value="<?= $item['qty_penjualan'] ?>">

            <tr>
                <td><label>Tanggal</label></td>
                <td><input type="date" name="tgl_penjualan" value="<?= $item['tgl_penjualan'] ?>"></td>
            </tr>
            <tr>
                <td><label>Nama Produk</label></td>
                <td>
                    <select name="id_produk">
                        <?php foreach ($data_produk as $p): ?>
                            <option value="<?= $p['id_produk'] ?>" <?= ($p['id_produk'] == $selected_id_produk) ? 'selected' : '' ?>><?= $p['nama_produk'] ?> | Qty : <?= $p['qty'] ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </td>
            </tr>
            <tr>
                <td><label>Qty Penjualan</label></td>
                <td><input type="number" name="qty_penjualan_baru" value="<?= $item['qty_penjualan'] ?>"></td>
            </tr>
            <tr>
                <td><button type="submit" name="ubah_penjualan">Ubah</button></td>
            </tr>
        </table>
    </form>
</body>

</html>