<?php
require "functions.php";

header('Content-Type: text/csv; charset=utf-8');
header('Content-Disposition: attachment;filename="Laporan Penjualan.csv"');

// Buka output file
$output = fopen('php://output', 'w');

// Ambil data dari database
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

// Tulis header CSV
$columns = ['No.', 'Tanggal Penjualan', 'Nama Produk', 'Qty Terjual', 'Total Harga Jual'];
fputcsv($output, $columns);

// Tulis data ke CSV
if ($all_penjualan && $all_penjualan->num_rows > 0) {
    while ($row = mysqli_fetch_assoc($all_penjualan)) {
        fputcsv($output, $row);
    }
}

// Tutup koneksi
fclose($output);
$conn->close();