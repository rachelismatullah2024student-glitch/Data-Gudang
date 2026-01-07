<?php
include "include/conn.php";
include "layout/head.php"; // Pastikan pakai 'layout', bukan 'include'
include "layout/sidebar.php";
?>

<div id="main">
    <div class="page-heading">
        <h3>Tambah Kategori Barang</h3>
    </div>
    <div class="page-content">
        <section class="section">
            <div class="card">
                <div class="card-body">
                    <form action="kategori-simpan.php" method="POST">
                        <div class="form-group">
                            <label>Nama Kategori</label>
                            <input type="text" name="nama_kategori" class="form-control" placeholder="Contoh: Elektronik, Makanan, dll" required>
                        </div>
                        <div class="mt-4">
                            <button type="submit" class="btn btn-primary">Simpan</button>
                            <a href="data_kategori.php" class="btn btn-secondary">Batal</a>
                        </div>
                    </form>
                </div>
            </div>
        </section>
    </div>
</div>

<?php include "layout/footer.php"; ?>