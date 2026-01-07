<?php
// 1. Panggil koneksi database terlebih dahulu agar variabel $db tersedia
include "include/conn.php"; 

// 2. Panggil head dari folder layout (bukan include)
include "layout/head.php"; 

// 3. Panggil sidebar
include "layout/sidebar.php";

// 4. Ambil ID dan jalankan query
$id = $_GET['id'];
$query = $db->query("SELECT * FROM kategori WHERE id_kategori = '$id'");
$data = $query->fetch_assoc();
?>
<div id="main">
    <div class="page-heading">
        <h3>Edit Kategori</h3>
    </div>
    <div class="card">
        <div class="card-body">
            <form action="kategori-update.php" method="POST">
                <input type="hidden" name="id_kategori" value="<?= $data['id_kategori']; ?>">
                
                <div class="form-group">
                    <label>Nama Kategori</label>
                    <input type="text" name="nama_kategori" class="form-control" value="<?= $data['nama_kategori']; ?>" required>
                </div>
                <button type="submit" class="btn btn-success mt-3">Update Data</button>
                <a href="data_kategori.php" class="btn btn-light mt-3">Batal</a>
            </form>
        </div>
    </div>
</div>

<?php include "layout/footer.php"; ?>
