<?php
require "include/conn.php";
$id = $_GET['id'];

// Query ambil data barang + total stok
$sql = "SELECT b.*, 
        (SELECT COALESCE(SUM(jumlah_masuk), 0) FROM riwayat_masuk WHERE kodebarang = b.kodebarang) AS total_masuk,
        (SELECT COALESCE(SUM(jumlah_keluar), 0) FROM riwayat_keluar WHERE kodebarang = b.kodebarang) AS total_keluar
        FROM databarang b WHERE b.kodebarang = '$id'";

$result = $db->query($sql);
$row = $result->fetch_assoc();
?>
<!DOCTYPE html>
<html lang="en">
    <?php require "layout/head.php";?>
    <body>
        <div id="app">
            <?php require "layout/sidebar.php";?>
            <div id="main">
                <header class="mb-3">
                    <a href="#" class="burger-btn d-block d-xl-none"><i class="bi bi-justify fs-3"></i></a>
                </header>
                <div class="page-heading"><h3>Edit Barang & Foto</h3></div>
                <div class="page-content">
                    <section class="row">
                        <div class="card">
                            <div class="card-header"><h4 class="card-title">Form Update Data</h4></div>
                            <div class="card-body">
                                <form action="barang-edit-act.php" method="POST" enctype="multipart/form-data">
                                    <div class="row">
                                        <div class="col-md-6 border-end">
                                            <label>Kode Barang</label>
                                            <input type="text" class="form-control mb-3" name="kodebarang" value="<?=$row['kodebarang'];?>" readonly>
                                            
                                            <label>Nama Barang</label>
                                            <input type="text" class="form-control mb-3" name="namabarang" value="<?=$row['namabarang'];?>" required>
                                            
                                            <label>Harga Satuan</label>
                                            <input type="number" class="form-control mb-3" name="hargasatuan" value="<?=$row['hargasatuan'];?>" required>
                                            
                                            <label>Ganti Foto Barang (Kosongkan jika tidak diganti)</label>
                                            <input type="file" class="form-control mb-3" name="gambar" accept="image/*">
                                            
                                            <div class="mb-3">
                                                <p class="small text-muted mb-1">Foto Saat Ini:</p>
                                                <img src="upload/<?=$row['gambar'];?>" width="120" class="img-thumbnail">
                                            </div>
                                        </div>
                                        
                                        <div class="col-md-6">
                                            <label>Total Stok Masuk</label>
                                            <input type="number" class="form-control mb-3" name="stokmasuk" value="<?=$row['total_masuk'];?>">
                                            <input type="hidden" name="old_stokmasuk" value="<?=$row['total_masuk'];?>">
                                            
                                            <label>Total Stok Keluar</label>
                                            <input type="number" class="form-control mb-3" name="stokkeluar" value="<?=$row['total_keluar'];?>">
                                            <input type="hidden" name="old_stokkeluar" value="<?=$row['total_keluar'];?>">
                                            
                                            <p class="text-info small mt-4">*Sistem akan otomatis mencatat riwayat penyesuaian jika angka stok diubah.</p>
                                        </div>
                                    </div>
                                    <div class="mt-4">
                                        <button type="submit" class="btn btn-primary px-4">Simpan Perubahan</button>
                                        <a href="data_barang.php" class="btn btn-light-secondary px-4">Batal</a>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </section>
                </div>
                <?php require "layout/footer.php";?>
            </div>
        </div>
        <?php require "layout/js.php";?>
    </body>
</html>