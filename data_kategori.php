<?php
include "include/conn.php";
include "layout/head.php"; // Diubah dari header ke head
include "layout/sidebar.php";
?>

<div id="main">
    <div class="page-heading">
        <h3>Data Kategori</h3>
    </div>
    <div class="page-content">
        <div class="card">
            <div class="card-header">
                <a href="kategori-tambah.php" class="btn btn-primary">Tambah Kategori</a>
            </div>
            <div class="card-body">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Kategori</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $no = 1;
                        $query = $db->query("SELECT * FROM kategori");
                        while($row = $query->fetch_assoc()):
                        ?>
                        <tr>
                            <td><?= $no++; ?></td>
                            <td><?= $row['nama_kategori']; ?></td>
                            <td>
                                <a href="kategori-edit.php?id=<?= $row['id_kategori']; ?>" class="btn btn-warning btn-sm">Edit</a>
                                <a href="kategori-hapus.php?id=<?= $row['id_kategori']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Yakin hapus?')">Hapus</a>
                            </td>
                        </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<?php include "layout/footer.php"; ?>
<?php include "layout/js.php"; ?>