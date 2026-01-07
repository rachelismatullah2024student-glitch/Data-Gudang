<?php
require "include/conn.php";

$kodebarang   = $_POST['kodebarang'];
$namabarang   = $_POST['namabarang'];
$hargasatuan  = $_POST['hargasatuan'];

// Data Stok
$stokmasuk_baru  = (int)$_POST['stokmasuk'];
$old_stokmasuk   = (int)$_POST['old_stokmasuk'];
$stokkeluar_baru = (int)$_POST['stokkeluar'];
$old_stokkeluar  = (int)$_POST['old_stokkeluar'];

// --- BAGIAN LOGIKA UPLOAD FOTO ---
$query_gambar = ""; // Default kosong jika tidak ada foto baru

if (isset($_FILES['gambar']) && $_FILES['gambar']['error'] === 0) {
    $upload_dir = __DIR__ . DIRECTORY_SEPARATOR . 'upload' . DIRECTORY_SEPARATOR;
    
    // Ambil info file
    $file_name = $_FILES['gambar']['name'];
    $ext = pathinfo($file_name, PATHINFO_EXTENSION);
    
    // Buat nama unik agar tidak bentrok
    $new_filename = 'img_update_' . time() . '.' . $ext;
    
    if (move_uploaded_file($_FILES['gambar']['tmp_name'], $upload_dir . $new_filename)) {
        // Hapus foto lama dari folder (opsional agar folder tidak penuh)
        $old_data = $db->query("SELECT gambar FROM databarang WHERE kodebarang = '$kodebarang'")->fetch_assoc();
        if ($old_data['gambar'] && file_exists($upload_dir . $old_data['gambar'])) {
            unlink($upload_dir . $old_data['gambar']);
        }
        
        $query_gambar = ", gambar = '$new_filename'";
    }
}

// 1. Update data master (Nama, Harga, dan Foto jika ada)
$sql_update = "UPDATE databarang SET 
                namabarang = '$namabarang', 
                hargasatuan = '$hargasatuan' 
                $query_gambar 
              WHERE kodebarang = '$kodebarang'";
$db->query($sql_update);

// 2. Logika Penyesuaian Stok Masuk
if ($stokmasuk_baru != $old_stokmasuk) {
    $selisih_masuk = $stokmasuk_baru - $old_stokmasuk;
    $db->query("INSERT INTO riwayat_masuk (kodebarang, id_supplier, jumlah_masuk) VALUES ('$kodebarang', 1, '$selisih_masuk')");
}

// 3. Logika Penyesuaian Stok Keluar
if ($stokkeluar_baru != $old_stokkeluar) {
    $selisih_keluar = $stokkeluar_baru - $old_stokkeluar;
    $db->query("INSERT INTO riwayat_keluar (kodebarang, jumlah_keluar) VALUES ('$kodebarang', '$selisih_keluar')");
}

header("location:./data_barang.php");
?>