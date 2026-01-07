<!DOCTYPE html>
<html lang="en">
    <?php require "include/conn.php";?>
    <?php require "layout/head.php";?>
    <style>
        .card { border-radius: 15px; border: none; transition: transform 0.2s; box-shadow: 0 4px 15px rgba(0,0,0,0.05); }
        .card:hover { transform: translateY(-5px); }
        .gradient-blue { background: linear-gradient(45deg, #435ebe, #6482eb); color: white; }
        .gradient-green { background: linear-gradient(45deg, #198754, #28a745); color: white; }
        .gradient-red { background: linear-gradient(45deg, #dc3545, #ff4d5e); color: white; }
        .stats-icon { width: 50px; height: 50px; border-radius: 10px; background: rgba(255,255,255,0.2); display: flex; align-items: center; justify-content: center; font-size: 24px; }
        .table thead th { background-color: #f8f9fa; text-transform: uppercase; font-size: 12px; letter-spacing: 1px; }
    </style>
    <body>
        <div id="app">
            <?php require "layout/sidebar.php";?>
            <div id="main">
                <header class="mb-3">
                    <a href="#" class="burger-btn d-block d-xl-none"><i class="bi bi-justify fs-3"></i></a>
                </header>
                
                <div class="page-heading d-flex justify-content-between align-items-center">
                    <h3>Gudang Overview</h3>
                    <button id="btnExport" class="btn btn-sm btn-success rounded-pill px-3 shadow-sm">
                        <i class="bi bi-file-earmark-spreadsheet"></i> Ekspor Excel
                    </button>
                </div>

                <div class="page-content">
                    <section class="row">
                        <?php 
                            $count_barang = $db->query("SELECT count(*) as total FROM databarang")->fetch_object()->total;
                            $stok_masuk = $db->query("SELECT sum(jumlah_masuk) as total FROM riwayat_masuk")->fetch_object()->total;
                            $stok_keluar = $db->query("SELECT sum(jumlah_keluar) as total FROM riwayat_keluar")->fetch_object()->total;
                        ?>
                        <div class="col-6 col-lg-4 col-md-6">
                            <div class="card gradient-blue mb-4">
                                <div class="card-body px-3 py-4-5 d-flex align-items-center">
                                    <div class="stats-icon mr-3"><i class="bi bi-box-seam"></i></div>
                                    <div class="ms-3">
                                        <h6 class="text-white font-semibold">Total Jenis Barang</h6>
                                        <h4 class="font-extrabold mb-0"><?= $count_barang ?> Item</h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-6 col-lg-4 col-md-6">
                            <div class="card gradient-green mb-4">
                                <div class="card-body px-3 py-4-5 d-flex align-items-center">
                                    <div class="stats-icon mr-3"><i class="bi bi-arrow-down-circle"></i></div>
                                    <div class="ms-3">
                                        <h6 class="text-white font-semibold">Total Stok Masuk</h6>
                                        <h4 class="font-extrabold mb-0"><?= number_format($stok_masuk) ?></h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-6 col-lg-4 col-md-6">
                            <div class="card gradient-red mb-4">
                                <div class="card-body px-3 py-4-5 d-flex align-items-center">
                                    <div class="stats-icon mr-3"><i class="bi bi-arrow-up-circle"></i></div>
                                    <div class="ms-3">
                                        <h6 class="text-white font-semibold">Total Stok Keluar</h6>
                                        <h4 class="font-extrabold mb-0"><?= number_format($stok_keluar) ?></h4>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-8">
                            <div class="card" style="height: 400px;">
                                <div class="card-header bg-transparent"><h4>Visualisasi Stok Akhir</h4></div>
                                <div class="card-body">
                                    <canvas id="canvasChart"></canvas>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="card" style="height: 400px; overflow-y: auto;">
                                <div class="card-header bg-transparent border-bottom"><h4>Stok Rendah</h4></div>
                                <div class="card-body">
                                    <?php 
                                    $low_stock = $db->query("SELECT b.namabarang, 
                                        ((SELECT COALESCE(SUM(jumlah_masuk), 0) FROM riwayat_masuk WHERE kodebarang = b.kodebarang) - 
                                        (SELECT COALESCE(SUM(jumlah_keluar), 0) FROM riwayat_keluar WHERE kodebarang = b.kodebarang)) as sisa 
                                        FROM databarang b HAVING sisa < 10 ORDER BY sisa ASC");
                                    while($ls = $low_stock->fetch_object()){
                                    ?>
                                    <div class="d-flex justify-content-between align-items-center mb-3">
                                        <span><?= $ls->namabarang ?></span>
                                        <span class="badge bg-light-danger text-danger"><?= $ls->sisa ?> sisa</span>
                                    </div>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>

                        <div class="col-12 mt-4">
                            <div class="card">
                                <div class="card-body">
                                    <table class="table" id="tableData">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Nama Barang</th>
                                                <th>Masuk</th>
                                                <th>Keluar</th>
                                                <th>Sisa Stok</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php 
                                            $n = 1;
                                            $data = $db->query("SELECT b.*, 
                                                (SELECT COALESCE(SUM(jumlah_masuk), 0) FROM riwayat_masuk WHERE kodebarang = b.kodebarang) as m,
                                                (SELECT COALESCE(SUM(jumlah_keluar), 0) FROM riwayat_keluar WHERE kodebarang = b.kodebarang) as k
                                                FROM databarang b");
                                            while($r = $data->fetch_object()){
                                                $sisa = $r->m - $r->k;
                                                echo "<tr>
                                                    <td>".$n++."</td>
                                                    <td><b>{$r->namabarang}</b></td>
                                                    <td><span class='text-success'>+{$r->m}</span></td>
                                                    <td><span class='text-danger'>-{$r->k}</span></td>
                                                    <td><span class='badge bg-primary'>{$sisa}</span></td>
                                                </tr>";
                                            }
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </section>
                </div>
                <?php require "layout/footer.php";?>
            </div>
        </div>

        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script src="https://cdn.jsdelivr.net/gh/linways/table-to-excel@v1.0.4/dist/tableToExcel.js"></script>
        
        <script>
            // Script Chart
            const ctx = document.getElementById('canvasChart').getContext('2d');
            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: [<?php 
                        $l = $db->query("SELECT namabarang FROM databarang LIMIT 7");
                        while($lb = $l->fetch_object()){ echo "'".$lb->namabarang."',"; }
                    ?>],
                    datasets: [{
                        label: 'Stok Barang',
                        data: [<?php 
                            $v = $db->query("SELECT (SELECT COALESCE(SUM(jumlah_masuk),0) FROM riwayat_masuk WHERE kodebarang=b.kodebarang)-(SELECT COALESCE(SUM(jumlah_keluar),0) FROM riwayat_keluar WHERE kodebarang=b.kodebarang) as s FROM databarang b LIMIT 7");
                            while($vl = $v->fetch_object()){ echo $vl->s.","; }
                        ?>],
                        fill: true,
                        backgroundColor: 'rgba(67, 94, 190, 0.1)',
                        borderColor: '#435ebe',
                        tension: 0.4
                    }]
                }
            });

            // Script Export
            document.getElementById("btnExport").addEventListener("click", function () {
                TableToExcel.convert(document.getElementById("tableData"), {
                    name: "Laporan_Gudang.xlsx"
                });
            });
        </script>
        <?php require "layout/js.php";?>
    </body>
</html>