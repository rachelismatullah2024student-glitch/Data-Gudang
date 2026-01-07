<?php
include "include/conn.php";
include "layout/header.php";
include "layout/sidebar.php";
?>

<div id="main">
    <header class="mb-3">
        <a href="#" class="burger-btn d-block d-xl-none">
            <i class="bi bi-justify fs-3"></i>
        </a>
    </header>

    <div class="page-heading">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-6 order-md-1 order-last">
                    <h3>Tambah Supplier</h3>
                    <p class="text-subtitle text-muted">Tambahkan mitra supplier baru ke dalam sistem.</p>
                </div>
            </div>
        </div>

        <section id="basic-horizontal-layouts">
            <div class="row match-height">
                <div class="col-md-6 col-12">
                    <div class="card">
                        <div class="card-content">
                            <div class="card-body">
                                <form class="form form-horizontal" action="supplier-simpan.php" method="POST">
                                    <div class="form-body">
                                        <div class="row">
                                            <div class="col-md-4">
                                                <label>Nama Supplier</label>
                                            </div>
                                            <div class="col-md-8 form-group">
                                                <input type="text" class="form-control" name="nama_supplier" placeholder="Contoh: PT. Sumber Makmur" required>
                                            </div>
                                            
                                            <div class="col-sm-12 d-flex justify-content-end mt-3">
                                                <button type="submit" class="btn btn-primary me-1 mb-1">Simpan</button>
                                                <a href="data_supplier.php" class="btn btn-light-secondary me-1 mb-1">Batal</a>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

<?php include "layout/footer.php"; ?>