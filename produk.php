<?php
require "functions.php";
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Data Produk</title>
</head>

<body>
    <ul>
        <li><a href="index.php">Beranda</a></li>
        <li><a href="produk.php">Produk</a></li>
        <li><a href="penjualan.php">Penjualan</a></li>
    </ul>

    <h1>Daftar Produk</h1>

    <a href="produk_tambah.php">Tambah Produk</a>

    <br><br>

    <form action="" method="GET">
        <input type="text" name="nama_produk" placeholder="Nama Produk">
        <button type="submit">Cari</button>
    </form>

    <br>

    <table border="1" cellpadding="10" cellspacing="0">
        <tr>
            <td>No.</td>
            <td>Nama Produk</td>
            <td>Qty</td>
            <td>Harga Dasar</td>
            <td>Harga Jual</td>
            <td>Aksi</td>
        </tr>


        <?php if (!empty($data_produk)): ?>
            <?php $no = 1; ?>
            <?php foreach ($data_produk as $row): ?>
                <tr>
                    <td><?= $no; ?></td>
                    <td><?= $row['nama_produk']; ?></td>
                    <td><?= $row['qty']; ?></td>
                    <td>Rp. <?= number_format($row['harga_dasar'], 2, ',', '.') ?></td>
                    <td>Rp. <?= number_format($row['harga_jual'], 2, ',', '.') ?></td>
                    <td>
                        <a href="produk_ubah.php?id_produk=<?= $row['id_produk'] ?>">Ubah</a>
                        <a href="produk_hapus.php?id_produk=<?= $row['id_produk'] ?>">Hapus</a>
                    </td>
                </tr>
                <?php $no++; ?>
            <?php endforeach; ?>
        <?php else: ?>
            <p>Tidak ada data yang ditemukan.</p>
        <?php endif; ?>
    </table>
</body>

</html>