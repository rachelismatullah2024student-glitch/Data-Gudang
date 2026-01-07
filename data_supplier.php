<?php
require "include/conn.php";
require "layout/head.php";
?>
<!DOCTYPE html>
<html lang="en">
<body>
    <div id="app">
        <?php require "layout/sidebar.php";?>
        <div id="main">
            <header class="mb-3">
                <a href="#" class="burger-btn d-block d-xl-none"><i class="bi bi-justify fs-3"></i></a>
            </header>
            <div class="page-heading"><h3>Manajemen Supplier</h3></div>
            <div class="page-content">
                <section class="row">
                    <div class="col-12">
                        <?php if(isset($_GET['status']) && $_GET['status'] == 'sukses'): ?>
    <div class="alert alert-success">Data Supplier Berhasil Ditambahkan!</div>
<?php endif; ?>
                        <div class="card">
                            <div class="card-header d-flex justify-content-between">
                                <h4 class="card-title">Daftar Supplier Pemasok</h4>
                                <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#modalSupplier">Tambah Supplier</button>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-hover">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>ID Supplier</th>
                                                <th>Nama Supplier</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $no = 1;
                                            $sql = $db->query("SELECT * FROM supplier ORDER BY id_supplier DESC");
                                            while($row = $sql->fetch_assoc()){
                                            ?>
                                            <tr>
                                                <td><?=$no++;?></td>
                                                <td>SUP-00<?=$row['id_supplier'];?></td>
                                                <td><?=$row['nama_supplier'];?></td>
                                                <td>
                                                    <a href="supplier-hapus.php?id=<?=$row['id_supplier'];?>" class="btn btn-danger btn-sm" onclick="return confirm('Hapus supplier ini?')">Hapus</a>
                                                </td>
                                            </tr>
                                            <?php } ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
            
            <div class="modal fade" id="modalSupplier" tabindex="-1">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <form action="supplier-simpan.php" method="POST">
                            <div class="modal-header"><h5 class="modal-title">Tambah Supplier Baru</h5></div>
                            <div class="modal-body">
                                <label>Nama Supplier:</label>
                                <input type="text" name="nama_supplier" class="form-control" required placeholder="Contoh: PT. Sumber Makmur">
                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-primary">Simpan</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php require "layout/js.php";?>
</body>
</html>