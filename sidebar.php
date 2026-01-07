<div id="sidebar" class="active">
    <div class="sidebar-wrapper active">
        <div class="sidebar-header">
            <div class="d-flex justify-content-between">
                <div class="logo">
                    <a href="./">Data Gudang</a>
                </div>
                <div class="toggler">
                    <a href="#" class="sidebar-hide d-xl-none d-block"><i class="bi bi-x bi-middle"></i></a>
                </div>
            </div>
        </div>
        <div class="sidebar-menu">
            <ul class="menu">
                <li class="sidebar-title">Menu</li>

                <li class="sidebar-item <?= (basename($_SERVER['PHP_SELF']) == 'index.php' || basename($_SERVER['PHP_SELF']) == '') ? 'active' : '' ?>">
                    <a href="./" class='sidebar-link'>
                        <i class="bi bi-grid-fill"></i>
                        <span>Dashboard</span>
                    </a>
                </li>

                <li class="sidebar-item <?= (basename($_SERVER['PHP_SELF']) == 'data_barang.php') ? 'active' : '' ?>">
                    <a href="data_barang.php" class='sidebar-link'>
                        <i class="bi bi-file-earmark-spreadsheet-fill"></i>
                        <span>Data Barang</span>
                    </a>
                </li>

                <li class="sidebar-item <?= (basename($_SERVER['PHP_SELF']) == 'data_supplier.php') ? 'active' : '' ?>">
                    <a href="data_supplier.php" class='sidebar-link'>
                        <i class="bi bi-truck"></i>
                        <span>Data Supplier</span>
                    </a>
                </li>

                <li class="sidebar-item <?= (basename($_SERVER['PHP_SELF']) == 'data_kategori.php') ? 'active' : '' ?>">
                    <a href="data_kategori.php" class='sidebar-link'>
                        <i class="bi bi-tags-fill"></i>
                        <span>Data Kategori</span>
                    </a>
                </li>

                <li class="sidebar-item">
                    <a href="logout.php" class='sidebar-link'>
                        <i class="bi bi-box-arrow-right"></i>
                        <span>Logout</span>
                    </a>
                    <li class="sidebar-item">
    <a href="barang-tambah.php" class='sidebar-link'>
        <i class="bi bi-plus-circle-fill"></i>
        <span>Tambah Barang</span>
    </a>
</li>
                </li>
            </ul>
        </div>
        <button class="sidebar-toggler btn x"><i data-feather="x"></i></button>
    </div>
</div>