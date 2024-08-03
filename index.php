<?php
require "functions.php";

$produk_terlaris = "SELECT 
                    `produk`.`id_produk`, 
                    `produk`.`nama_produk`, 
                    SUM(`penjualan`.`qty_penjualan`) AS `total_qty_terjual`
                FROM 
                    `produk`
                INNER JOIN 
                    `penjualan` ON `produk`.`id_produk` = `penjualan`.`produk_id`
                GROUP BY 
                    `produk`.`id_produk`, `produk`.`nama_produk`
                ORDER BY 
                    `total_qty_terjual` DESC
                LIMIT 1;
";

$result = mysqli_query($conn, $produk_terlaris);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Beranda</title>
</head>

<body>
    <ul>
        <li><a href="index.php">Beranda</a></li>
        <li><a href="produk.php">Produk</a></li>
        <li><a href="penjualan.php">Penjualan</a></li>
    </ul>


    <h3>Produk Terlaris</h3>
    <p>
        <?php
        if ($result && mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                echo "Nama Produk: " . $row['nama_produk'] . " - Total Terjual: " . $row['total_qty_terjual'] . "<br>";
            }
        } else {
            echo "Tidak ada data produk terlaris.";
        }
        ?>
    </p>
</body>

</html>