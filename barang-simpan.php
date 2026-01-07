<?php
require "include/conn.php";
$kodebarang = $_POST['kodebarang'] ?? '';
$namabarang = $_POST['namabarang'] ?? '';
$hargasatuan = $_POST['hargasatuan'] ?? '';
$id_kategori = $_POST['id_kategori'] ??'';

// upload directory (absolute path)
$upload_dir = __DIR__ . DIRECTORY_SEPARATOR . 'upload' . DIRECTORY_SEPARATOR;
if (!is_dir($upload_dir)) {
    if (!mkdir($upload_dir, 0755, true)) {
        die('Gagal membuat direktori upload: ' . $upload_dir);
    }
}

$nama_gambar_baru = '';
if (!isset($_FILES['gambar'])) {
    die('File upload tidak ditemukan. Pastikan form memiliki enctype="multipart/form-data" dan field name="gambar".');
}

$file = $_FILES['gambar'];
if ($file['error'] !== UPLOAD_ERR_OK) {
    $errors = [
        UPLOAD_ERR_INI_SIZE => 'File terlalu besar (UPLOAD_ERR_INI_SIZE).',
        UPLOAD_ERR_FORM_SIZE => 'File terlalu besar (UPLOAD_ERR_FORM_SIZE).',
        UPLOAD_ERR_PARTIAL => 'File hanya terupload sebagian (UPLOAD_ERR_PARTIAL).',
        UPLOAD_ERR_NO_FILE => 'Tidak ada file yang diunggah (UPLOAD_ERR_NO_FILE).',
        UPLOAD_ERR_NO_TMP_DIR => 'Folder temporer hilang (UPLOAD_ERR_NO_TMP_DIR).',
        UPLOAD_ERR_CANT_WRITE => 'Gagal menulis ke disk (UPLOAD_ERR_CANT_WRITE).',
        UPLOAD_ERR_EXTENSION => 'Upload dihentikan oleh ekstensi PHP (UPLOAD_ERR_EXTENSION).',
    ];
    $msg = $errors[$file['error']] ?? 'Kesalahan upload tidak diketahui.';
    die('Upload error: ' . $msg);
}

// basic validation (optional): limit file size (e.g., 5MB)
$maxSize = 5 * 1024 * 1024;
if ($file['size'] > $maxSize) {
    die('File terlalu besar. Maksimum 5MB.');
}

$original_name = basename($file['name']);
$ext = pathinfo($original_name, PATHINFO_EXTENSION);
$allowed = ['jpg','jpeg','png','gif'];
if (!in_array(strtolower($ext), $allowed)) {
    die('Tipe file tidak diperbolehkan. Hanya: ' . implode(', ', $allowed));
}

// sanitize and create unique filename
$safe_base = preg_replace('/[^A-Za-z0-9_\-]/', '_', pathinfo($original_name, PATHINFO_FILENAME));
$nama_gambar_baru = $safe_base . '_' . time() . '.' . $ext;
$destination = $upload_dir . $nama_gambar_baru;

if (!move_uploaded_file($file['tmp_name'], $destination)) {
    // try to get last error
    $last = error_get_last();
    $err = $last['message'] ?? 'Unknown';
    die('Gagal memindahkan file ke folder upload: ' . $destination . ' — ' . $err);
}

// insert into database using prepared statement
$stmt = $db->prepare("INSERT INTO databarang (kodebarang, id_kategori, namabarang, hargasatuan, gambar) VALUES (?, ?, ?, ?, ?)");
if ($stmt === false) {
    die('Prepare failed: ' . $db->error);
}
$stmt->bind_param('sssss', $kodebarang, $id_kategori, $namabarang, $hargasatuan, $nama_gambar_baru);
if ($stmt->execute()) {
    header('Location: ./data_barang.php');
    exit;
} else {
    echo 'Error saat menyimpan data: ' . $stmt->error;
}

