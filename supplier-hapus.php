<?php
require "include/conn.php";

$id = $_GET['id'];

// Cek apakah supplier sedang digunakan di riwayat_masuk
$cek = $db->query("SELECT * FROM riwayat_masuk WHERE id_supplier = '$id'");
if ($cek->num_rows > 0) {
    echo "<script>alert('Gagal! Supplier tidak bisa dihapus karena masih terkait dengan data barang masuk.'); window.location='data_supplier.php';</script>";
} else {
    $db->query("DELETE FROM supplier WHERE id_supplier = '$id'");
    header("location:data_supplier.php");
}
?>