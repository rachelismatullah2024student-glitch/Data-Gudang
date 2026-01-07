<?php
ob_start();
include "include/conn.php";

$id = $_POST['id_kategori'];
$nama = mysqli_real_escape_string($db, $_POST['nama_kategori']);

$sql = "UPDATE kategori SET nama_kategori = '$nama' WHERE id_kategori = '$id'";

if ($db->query($sql)) {
    header("Location: data_kategori.php?status=update_sukses");
    exit();
} else {
    die("Gagal update: " . $db->error);
}
?>