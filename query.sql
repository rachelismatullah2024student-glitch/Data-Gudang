-- Pastikan menggunakan database yang sesuai dengan error Anda
CREATE DATABASE IF NOT EXISTS dtgdg_pr;
USE dtgdg_pr;

-- 1. Tabel Kategori
CREATE TABLE IF NOT EXISTS kategori (
  id_kategori INT PRIMARY KEY AUTO_INCREMENT,
  nama_kategori VARCHAR(50) NOT NULL
) ENGINE=INNODB;

-- 2. Tabel Supplier
CREATE TABLE IF NOT EXISTS supplier (
  id_supplier INT PRIMARY KEY AUTO_INCREMENT,
  nama_supplier VARCHAR(100) NOT NULL
) ENGINE=INNODB;

-- 3. Tabel Data Barang (Master)
CREATE TABLE IF NOT EXISTS databarang (
  kodebarang VARCHAR(20) PRIMARY KEY,
  id_kategori INT,
  namabarang VARCHAR(100) NOT NULL,
  hargasatuan INT NOT NULL,
  gambar VARCHAR(255),
  FOREIGN KEY (id_kategori) REFERENCES kategori(id_kategori) ON DELETE SET NULL
) ENGINE=INNODB;

-- 4. Tabel Riwayat Masuk (Harus bernama riwayat_masuk)
CREATE TABLE IF NOT EXISTS riwayat_masuk (
  id_masuk INT PRIMARY KEY AUTO_INCREMENT,
  kodebarang VARCHAR(20),
  id_supplier INT,
  jumlah_masuk INT NOT NULL,
  tgl_masuk TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (kodebarang) REFERENCES databarang(kodebarang) ON DELETE CASCADE
) ENGINE=INNODB;

-- 5. Tabel Riwayat Keluar (Harus bernama riwayat_keluar)
CREATE TABLE IF NOT EXISTS riwayat_keluar (
  id_keluar INT PRIMARY KEY AUTO_INCREMENT,
  kodebarang VARCHAR(20),
  jumlah_keluar INT NOT NULL,
  tgl_keluar TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (kodebarang) REFERENCES databarang(kodebarang) ON DELETE CASCADE
) ENGINE=INNODB;

-- 6. Tabel Users
CREATE TABLE IF NOT EXISTS users (
  id_user INT PRIMARY KEY AUTO_INCREMENT,
  username VARCHAR(50) UNIQUE,
  PASSWORD VARCHAR(150)
) ENGINE=INNODB;

-- Masukkan Data Kategori Awal agar dropdown tidak kosong
INSERT INTO kategori (nama_kategori) VALUES ('Kopi'), ('Minuman'), ('Lainnya');


INSERT INTO users (username, PASSWORD)
VALUES ('admin', MD5('admin'));