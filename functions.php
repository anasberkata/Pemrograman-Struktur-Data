<?php
// Konfigurasi database
$host = 'localhost';
$user = 'root';
$password = '';
$database = 'kasir';

// Membuat koneksi
$conn = mysqli_connect($host, $user, $password, $database);

// ----------------------------------------------------------------------------------------------------

// SHOW PRODUK
if (!empty($_GET['nama_produk'])) {
    $nama_produk = $_GET['nama_produk'];

    $produk = "SELECT * FROM `produk` WHERE `nama_produk` LIKE '%$nama_produk%'";
    $all_produk = mysqli_query($conn, $produk);
    $data_produk = mysqli_fetch_all($all_produk, MYSQLI_ASSOC);
} else {
    $produk = "SELECT * FROM `produk`";
    $all_produk = mysqli_query($conn, $produk);
    $data_produk = mysqli_fetch_all($all_produk, MYSQLI_ASSOC);
}

// CREATE PRODUK
if (isset($_POST['tambah_produk'])) {
    $nama_produk = $_POST['nama_produk'];
    $qty = $_POST['qty'];
    $harga_dasar = $_POST['harga_dasar'];
    $harga_jual = $_POST['harga_jual'];

    $tambah_produk = "INSERT INTO `produk` VALUES (NULL, '$nama_produk', '$qty', '$harga_dasar', '$harga_jual')";

    if (mysqli_query($conn, $tambah_produk)) {
        header("Location: produk.php");
        exit();
    } else {
        echo "Error: " . $tambah_produk . "<br>" . mysqli_error($conn);
    }
}

// UPDATE PRODUK
if (isset($_POST['ubah_produk'])) {
    $id_produk = $_POST['id_produk'];
    $nama_produk = $_POST['nama_produk'];
    $qty = $_POST['qty'];
    $harga_dasar = $_POST['harga_dasar'];
    $harga_jual = $_POST['harga_jual'];

    $ubah_produk = "UPDATE `produk` SET
                    `nama_produk` = '$nama_produk',
                    `qty` = '$qty',
                    `harga_dasar` = '$harga_dasar',
                    `harga_jual` = '$harga_jual'

                    WHERE `id_produk` = '$id_produk'
    ";

    if (mysqli_query($conn, $ubah_produk)) {
        header("Location: produk.php");
        exit();
    } else {
        echo "Error: " . $ubah_produk . "<br>" . mysqli_error($conn);
    }
}

// ----------------------------------------------------------------------------------------------------
// SHOW PENJUALAN
$query_conditions = [];
$tgl_awal = !empty($_GET['tgl_awal']) ? $_GET['tgl_awal'] : null;
$tgl_akhir = !empty($_GET['tgl_akhir']) ? $_GET['tgl_akhir'] : null;
$nama_produk = !empty($_GET['nama_produk']) ? $_GET['nama_produk'] : null;

if ($tgl_awal && $tgl_akhir) {
    $query_conditions[] = "`tgl_penjualan` BETWEEN '$tgl_awal' AND '$tgl_akhir'";
}
if ($nama_produk) {
    $query_conditions[] = "`nama_produk` LIKE '%$nama_produk%'";
}

$query_condition = implode(' AND ', $query_conditions);
if ($query_condition) {
    $query_condition = "WHERE " . $query_condition;
}

$penjualan = "SELECT * FROM `penjualan`
                INNER JOIN `produk` ON `penjualan`.`produk_id` = `produk`.`id_produk`
                $query_condition";

$all_penjualan = mysqli_query($conn, $penjualan);
$data_penjualan = mysqli_fetch_all($all_penjualan, MYSQLI_ASSOC);

// HITUNG TOTAL PENJUALAN
$total_penjualan = "SELECT SUM(`total_harga_jual`) AS `t` FROM `penjualan`
                    INNER JOIN `produk` ON `penjualan`.`produk_id` = `produk`.`id_produk`
                    $query_condition";

$tp = mysqli_query($conn, $total_penjualan);
$t = mysqli_fetch_all($tp, MYSQLI_ASSOC)[0];

// HITUNG LABA
$total_laba = "SELECT SUM(`total_harga_jual`) - SUM(`total_harga_dasar`) AS `laba` FROM `penjualan`
                INNER JOIN `produk` ON `penjualan`.`produk_id` = `produk`.`id_produk`
                $query_condition";

$laba = mysqli_query($conn, $total_laba);
$l = mysqli_fetch_all($laba, MYSQLI_ASSOC)[0];


// CREATE PENJUALAN
if (isset($_POST['tambah_penjualan'])) {
    $tgl_penjualan = $_POST['tgl_penjualan'];
    $id_produk = $_POST['id_produk'];
    $qty_penjualan = $_POST['qty_penjualan'];

    // AMBIL DATA PRODUK
    $produk = "SELECT * FROM `produk` WHERE `id_produk` = '$id_produk'";
    $data_produk = mysqli_query($conn, $produk);
    $item = mysqli_fetch_all($data_produk, MYSQLI_ASSOC)[0];

    $qty = $item['qty'];
    $harga_dasar = $item['harga_dasar'];
    $harga_jual = $item['harga_jual'];

    // HITUNG TOTAL HARGA DASAR DAN TOTAL HARGA JUAL
    $total_harga_dasar = $qty_penjualan * $harga_dasar;
    $total_harga_jual = $qty_penjualan * $harga_jual;

    // HITUNG QTY PADA PRODUK SETELAH DI KURANGI QTY PENJUALAN
    $qty_akhir = $qty - $qty_penjualan;

    // INSERT PENJUALAN
    $tambah_penjualan = "INSERT INTO `penjualan` VALUES (NULL, '$id_produk', '$tgl_penjualan', '$qty_penjualan', '$total_harga_dasar', '$total_harga_jual')";

    // UPDATE QTY DI PRODUK
    $update_qty_produk = "UPDATE `produk` SET `qty` = '$qty_akhir' WHERE `id_produk` = '$id_produk'";

    if (mysqli_query($conn, $tambah_penjualan) && mysqli_query($conn, $update_qty_produk)) {
        header("Location: penjualan.php");
        exit();
    } else {
        echo "Error: " . $tambah_penjualan . "<br>" . mysqli_error($conn);
        echo "<br>";
        echo "Error: " . $update_qty_produk . "<br>" . mysqli_error($conn);
    }
}

if (isset($_POST['ubah_penjualan'])) {
    $id_penjualan = $_POST['id_penjualan'];
    $tgl_penjualan = $_POST['tgl_penjualan'];
    $id_produk = $_POST['id_produk'];
    $qty_penjualan_baru = $_POST['qty_penjualan_baru'];
    $qty_penjualan_lama = $_POST['qty_penjualan_lama'];

    // AMBIL DATA PRODUK
    $produk = "SELECT * FROM `produk` WHERE `id_produk` = '$id_produk'";
    $data_produk = mysqli_query($conn, $produk);
    $item = mysqli_fetch_all($data_produk, MYSQLI_ASSOC)[0];

    $qty = $item['qty'];
    $harga_dasar = $item['harga_dasar'];
    $harga_jual = $item['harga_jual'];

    // HITUNG TOTAL HARGA DASAR DAN TOTAL HARGA JUAL
    $total_harga_dasar = $qty_penjualan_baru * $harga_dasar;
    $total_harga_jual = $qty_penjualan_baru * $harga_jual;

    // HITUNG QTY PADA PRODUK SETELAH DI KURANGI QTY PENJUALAN
    $qty_akhir = ($qty + $qty_penjualan_lama) - $qty_penjualan_baru;

    // INSERT PENJUALAN
    $ubah_penjualan = "UPDATE `penjualan` SET 

                        `produk_id` = '$id_produk',
                        `tgl_penjualan` = '$tgl_penjualan',
                        `qty_penjualan` = '$qty_penjualan_baru',
                        `total_harga_dasar` = '$total_harga_dasar',
                        `total_harga_jual` = '$total_harga_jual'

                        WHERE `id_penjualan` = '$id_penjualan'
                        ";

    // UPDATE QTY DI PRODUK
    $update_qty_produk = "UPDATE `produk` SET `qty` = '$qty_akhir' WHERE `id_produk` = '$id_produk'";

    if (mysqli_query($conn, $ubah_penjualan) && mysqli_query($conn, $update_qty_produk)) {
        header("Location: penjualan.php");
        exit();
    } else {
        echo "Error: " . $ubah_penjualan . "<br>" . mysqli_error($conn);
        echo "<br>";
        echo "Error: " . $update_qty_produk . "<br>" . mysqli_error($conn);
    }
}