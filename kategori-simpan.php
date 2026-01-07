<?php
ob_start();
// Pastikan folder 'include' berisi file 'conn.php'
include "include/conn.php"; 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Mengambil data dari form kategori-tambah.php
    $nama_kategori = mysqli_real_escape_string($db, $_POST['nama_kategori']);

    // Proses simpan ke database
    $sql = "INSERT INTO kategori (nama_kategori) VALUES ('$nama_kategori')";

    if ($db->query($sql)) {
        // Jika berhasil, pindah ke halaman daftar kategori
        header("Location: data_kategori.php?status=sukses");
        exit();
    } else {
        die("Gagal menyimpan data: " . $db->error);
    }
}
?>