<?php
ob_start();
require "include/conn.php";

// Mengambil ID dari URL
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Query hapus
    $sql = "DELETE FROM kategori WHERE id_kategori = '$id'";

    if ($db->query($sql)) {
        header("Location: data_kategori.php?status=hapus_sukses");
        exit();
    } else {
        // Jika gagal (misal: kategori masih dipakai di tabel barang)
        die("Gagal menghapus: Data ini mungkin masih terhubung dengan tabel Barang.");
    }
} else {
    header("Location: data_kategori.php");
    exit();
}
?>