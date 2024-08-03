<?php
require "functions.php";
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Penjualan</title>
</head>

<body>
    <ul>
        <li><a href="index.php">Beranda</a></li>
        <li><a href="produk.php">Produk</a></li>
        <li><a href="penjualan.php">Penjualan</a></li>
    </ul>

    <h1>Daftar Penjualan</h1>

    <a href="penjualan_tambah.php">Tambah Penjualan</a>

    <?php if (!empty($_GET['tgl_awal']) || !empty($_GET['tgl_akhir']) || !empty($_GET['nama_produk'])): ?>
        <a
            href="penjualan_export.php?tgl_awal=<?= $_GET['tgl_awal'] ?>&tgl_akhir=<?= $_GET['tgl_akhir'] ?>&nama_produk=<?= $_GET['nama_produk'] ?>">Export</a>
    <?php else: ?>
        <a href="penjualan_export.php">Export</a>
    <?php endif; ?>

    <br><br>

    <form action="" method="GET">
        <input type="date" name="tgl_awal">
        <input type="date" name="tgl_akhir">
        <input type="text" name="nama_produk" placeholder="Nama Produk">
        <button type="submit">Cari</button>
    </form>

    <br>

    <table border="1" cellpadding="10" cellspacing="0">
        <tr>
            <td>No.</td>
            <td>Tanggal Penjualan</td>
            <td>Nama Produk</td>
            <td>Qty Terjual</td>
            <td>Total Harga Jual</td>
            <td>Aksi</td>
        </tr>

        <?php if (!empty($data_penjualan)): ?>

            <?php $no = 1; ?>
            <?php foreach ($data_penjualan as $d): ?>
                <tr>
                    <td><?= $no; ?></td>
                    <td><?= date('d F Y', strtotime($d["tgl_penjualan"])) ?></td>
                    <td><?= $d["nama_produk"] ?></td>
                    <td><?= $d["qty_penjualan"] ?></td>
                    <td>Rp. <?= number_format($d["total_harga_jual"], 2, ',', '.') ?></td>
                    <td>
                        <a href="penjualan_ubah.php?id_penjualan=<?= $d['id_penjualan'] ?>">Ubah</a>
                        <a href="penjualan_hapus.php?id_penjualan=<?= $d['id_penjualan'] ?>">Hapus</a>
                    </td>
                </tr>
                <?php $no++; ?>
            <?php endforeach; ?>

        <?php else: ?>
            <p>Tidak Ada Penjualan Hari Ini</p>
        <?php endif; ?>

        <tr>
            <td colspan="4">Jumlah Penjualan</td>
            <td colspan="2">Rp. <?= number_format($t["t"], 2, ',', '.') ?></td>
        </tr>
        <tr>
            <td colspan="4">Laba</td>
            <td colspan="2">Rp. <?= number_format($l["laba"], 2, ',', '.') ?></td>
        </tr>

    </table>
</body>

</html>