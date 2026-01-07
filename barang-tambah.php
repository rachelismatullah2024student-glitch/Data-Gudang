<?php
include "include/conn.php";
include "layout/head.php";
include "layout/sidebar.php";
?>

<div id="main">
    <div class="page-heading">
        <h3>Tambah Barang Baru</h3>
    </div>
    <div class="page-content">
        <div class="card">
            <div class="card-body">
                <form action="barang-simpan.php" method="POST" enctype="multipart/form-data">
                    <div class="form-group mb-3">
                        <label>Kode Barang</label>
                        <input type="text" name="kodebarang" class="form-control" required placeholder="Contoh: BRG001">
                    </div>

                    <div class="form-group mb-3">
                        <label>Nama Barang</label>
                        <input type="text" name="namabarang" class="form-control" required>
                    </div>

                    <div class="form-group mb-3">
                        <label>Kategori</label>
                        <select name="id_kategori" class="form-control" required>
                            <option value="">-- Pilih Kategori --</option>
                            <?php
                            $kat = $db->query("SELECT * FROM kategori");
                            while($k = $kat->fetch_assoc()):
                            ?>
                                <option value="<?= $k['id_kategori']; ?>"><?= $k['nama_kategori']; ?></option>
                            <?php endwhile; ?>
                        </select>
                    </div>

                    <div class="form-group mb-3">
                        <label>Harga Satuan</label>
                        <input type="number" name="hargasatuan" class="form-control" required>
                    </div>

    <div class="form-group mb-3">
        <label>Foto Produk</label>
        <input type="file" name="gambar" class="form-control" accept="image/*">
        <small class="text-muted">Format: jpg, jpeg, png. Maks: 2MB</small>
    </div>

    <button type="submit" class="btn btn-primary">Simpan Barang</button>
                </form>
            </div>
        </div>
    </div>
</div>

<?php include "layout/footer.php"; ?>
<?php include "layout/js.php"; ?>