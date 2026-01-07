<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
require "include/conn.php";
// ... sisa kode lainnya ...
ob_start();
require "include/conn.php";
$nama = mysqli_real_escape_string($db, $_POST['nama_supplier']);
$sql = "INSERT INTO supplier (nama_supplier) VALUES ('$nama')";
if ($db->query($sql) ){
    header("Location: data_supplier.php?status=sukses");
    exit();
} else {
    echo "Error: " . $sql . "<br>" . $db->error;
}
?>