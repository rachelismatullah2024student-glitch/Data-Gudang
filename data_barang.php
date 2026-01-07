<!DOCTYPE html>
<html lang="en">
    <?php require "layout/head.php"; require "include/conn.php"; ?>
    <style>.table-responsive { overflow: visible !important; }</style>
    <body>
        <div id="app">
            <?php require "layout/sidebar.php";?>
            <div id="main">
                <header class="mb-3">
                    <a href="#" class="burger-btn d-block d-xl-none"><i class="bi bi-justify fs-3"></i></a>
                </header>
                <div class="page-heading"><h3>Data Barang</h3></div>
                <div class="page-content">
                    <section class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header d-flex justify-content-between">
                                    <h4 class="card-title">Daftar Barang</h4>
                                    <button type="button" class="btn btn-outline-success btn-sm" data-bs-toggle="modal" data-bs-target="#inlineForm">Tambah Barang</button>
<button type="button" id="btnExport" class="btn btn-outline-primary btn-sm">Ekspor Excel</button>
                                </div>
                                <div class="card-header">
    <a href="barang-tambah.php" class="btn btn-primary">
        <i class="bi bi-plus"></i> Tambah Barang
    </a>
</div>
                                <div class="card-content">
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table class="table table-striped mb-0">
                                                <thead>
                                                    <tr>
                                                        <th>No</th>
                                                        <th>Gambar</th>
                                                        <th>Kode</th>
                                                        <th>Nama Barang</th>
                                                        <th>Harga</th>
                                                        <th>masuk</th>
                                                        <th>keluar</th>
                                                        <th>Aksi</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    $sql = "SELECT b.kodebarang, b.namabarang, b.hargasatuan, b.gambar,
                                                            (SELECT COALESCE(SUM(jumlah_masuk), 0) FROM riwayat_masuk WHERE kodebarang = b.kodebarang) AS stokmasuk,
                                                            (SELECT COALESCE(SUM(jumlah_keluar), 0) FROM riwayat_keluar WHERE kodebarang = b.kodebarang) AS stokkeluar
                                                            FROM databarang b";
                                                    $result = $db->query($sql);
                                                    $i = 0;
                                                    while ($row = $result->fetch_object()) {
                                                        echo "<tr>
                                                            <td>" . (++$i) . "</td>
                                                            <td><img src='upload/{$row->gambar}' width='70' class='rounded'></td>
                                                            <td>{$row->kodebarang}</td>
                                                            <td>{$row->namabarang}</td>
                                                            <td>Rp. ".number_format($row->hargasatuan, 0, ',', '.')."</td>
                                                            <td>{$row->stokmasuk}</td>
                                                            <td>{$row->stokkeluar}</td>
                                                            <td>
                                                                <div class='dropdown'>
                                                                    <button class='btn btn-primary btn-sm dropdown-toggle' type='button' data-bs-toggle='dropdown' data-bs-boundary='viewport'>Aksi</button>
                                                                    <div class='dropdown-menu shadow'>
                                                                        <a class='dropdown-item' href='barang-edit.php?id={$row->kodebarang}'>Edit</a>
                                                                        <a class='dropdown-item text-danger' href='barang-hapus.php?id={$row->kodebarang}' onclick='return confirm(\"Hapus?\")'>Hapus</a>
                                                                    </div>
                                                                </div>
                                                            </td>
                                                        </tr>";
                                                    }
                                                    ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                </div>
                <?php require "layout/footer.php";?>
            </div>
        </div>

        <div class="modal fade" id="inlineForm" tabindex="-1" role="dialog">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header"><h4 class="modal-title">Tambah Barang</h4></div>
                    <form action="barang-simpan.php" method="POST" enctype="multipart/form-data">
                        <div class="modal-body">
                            <label>Kode Barang:</label>
                            <input type="text" name="kodebarang" class="form-control mb-2" required>
                            <label>Nama Barang:</label>
                            <input type="text" name="namabarang" class="form-control mb-2" required>
                            <label>Harga Satuan:</label>
                            <input type="number" name="hargasatuan" class="form-control mb-2" required>
                            <label>Gambar:</label>
                            <input type="file" name="gambar" accept="image/*" class="form-control" required>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-light-secondary" data-bs-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <script src="https://cdn.jsdelivr.net/gh/linways/table-to-excel@v1.0.4/dist/tableToExcel.js"></script>
<script>
    document.getElementById("btnExport").addEventListener("click", function () {
        let table = document.querySelector(".table"); // Mengambil tabel di halaman tersebut
        TableToExcel.convert(table, {
            name: "Data_Barang_Gudang.xlsx",
            sheet: { name: "Data" }
        });
    });
</script>
        <?php require "layout/js.php";?>
    </body>
</html>