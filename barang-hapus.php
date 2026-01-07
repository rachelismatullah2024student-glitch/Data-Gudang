<?php
require "include/conn.php";
$id = $_GET['id'];
mysqli_query($db, "delete from databarang where kodebarang='$id'");
header("location:./data_barang.php");