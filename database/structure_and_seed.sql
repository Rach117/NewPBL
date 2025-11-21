-- database/structure_and_seed.sql
-- Struktur tabel dan seeder FINAL untuk SATRIA (Updated Flow)

SET time_zone = '+07:00';
CREATE DATABASE IF NOT EXISTS satria DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE satria;

-- 1. Tabel Master Jurusan
CREATE TABLE IF NOT EXISTS master_jurusan (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nama_jurusan VARCHAR(100) NOT NULL
);
INSERT INTO master_jurusan (nama_jurusan) VALUES
('Teknik Sipil'),('Teknik Mesin'),('Teknik Elektro'),('Akuntansi'),('Administrasi Niaga'),('Teknik Grafika Penerbitan (TGP)'),('Teknik Informatika dan Komputer (TIK)'),('Pascasarjana');

-- 2. Tabel Master IKU
CREATE TABLE IF NOT EXISTS master_iku (
    id INT AUTO_INCREMENT PRIMARY KEY,
    deskripsi_iku VARCHAR(255) NOT NULL
);
INSERT INTO master_iku (deskripsi_iku) VALUES
('Mendapat pekerjaan'),('Melanjutkan studi'),('Menjadi wiraswasta'),('Menjalankan kegiatan pembelajaran di luar program studi'),('Mahasiswa yang menjalankan kegiatan magang wajib di luar program studi'),('Mahasiswa Inbound'),('Mahasiswa Meraih Prestasi'),('Tridharma (di PT Lain)'),('Praktisi (Pengalaman Praktisi)'),('Membimbing Mahasiswa Berkegiatan di Luar Program Studi'),('Jumlah dosen dengan NIDN atau Nomor Induk Dosen Khusus (NIDK) yang memiliki sertifikat kompetensi/ profesi'),('Jumlah pengajar yang berasal dari kalangan praktisi profesional, dunia industri, atau dunia kerja'),('Karya Tulis Ilmiah'),('Karya Terapan'),('Karya Seni'),('Jumlah kerjasama per program studi S1 dan D4/D3/D2/D1'),('50% (lima puluh persen) dari bobot nilai akhir harus berdasarkan kualitas partisipasi diskusi kelas (case method) dan/atau presentasi akhir pembelajaran kelompok berbasis project (team-based project)'),('Persentase program studi S1 dan D4/D3 yang memiliki akreditasi atau sertifikasi internasional yang diakui pemerintah');

-- 3. Tabel Master Kategori Anggaran
CREATE TABLE IF NOT EXISTS master_kategori_anggaran (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nama_kategori VARCHAR(100) NOT NULL
);
INSERT INTO master_kategori_anggaran (nama_kategori) VALUES
('Belanja Barang'),('Belanja Jasa'),('Belanja Perjalanan');

-- 4. Tabel Users
CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    role ENUM('Pengusul','Verifikator','WD2','PPK','Bendahara','Admin','Direktur') NOT NULL,
    jurusan_id INT NULL,
    is_active TINYINT(1) DEFAULT 1,
    FOREIGN KEY (jurusan_id) REFERENCES master_jurusan(id)
);

-- Seeder User (Password Default: admin123 / demo1 / dst)
-- Hash di bawah ini menggunakan PASSWORD_DEFAULT (Bcrypt)
INSERT INTO users (username, email, password, role, jurusan_id, is_active) VALUES
('admin', 'admin@pnj.ac.id', '$2y$10$MXATDBtHj3sB9u/HTj8GT.44PZvD4KwKfEi4Af8weo/KRD5pZWr5e', 'Admin', NULL, 1),
('pengusul_demo', 'pengusul_demo@pnj.ac.id', '$2y$10$V/Spd48L7FwCcGg3zp19FeyaWhHoM8ZwwhZpmPe24PY5nixe1lwhC', 'Pengusul', 7, 1),
('verifikator_demo', 'verifikator_demo@pnj.ac.id', '$2y$10$u4swbKr32cWehAofIxFjD.DZjrTswPNRX3QQqyl1WQtIEqSvz2OD6', 'Verifikator', NULL, 1),
('wd2_demo', 'wd2_demo@pnj.ac.id', '$2y$10$LsfnOj0.GxLs1l2jtCEMkuvP3DAQQa9FN83AIHGTGr93dHBxlDM52', 'WD2', NULL, 1),
('ppk_demo', 'ppk_demo@pnj.ac.id', '$2y$10$tYeNldhBIQQpWUObuVPxbOcRO793JtzgYvRgNXCg3efpi0h6PU3A.', 'PPK', NULL, 1),
('bendahara_demo', 'bendahara_demo@pnj.ac.id', '$2y$10$aTjtp2n9CETgE4jOG.2VmONzddsBlEC5qCfs7aCuJke/4sUxCs67m', 'Bendahara', NULL, 1),
('direktur_demo', 'direktur_demo@pnj.ac.id', '$2y$10$GFsHl/phNpeGibsjOswHruH0O05.7snz/WVFj/wY4WEBwhqFbPeaG', 'Direktur', NULL, 1);

-- 5. Tabel Usulan Kegiatan (INTI)
-- UPDATED: Enum status_terkini sudah mencakup flow approval lengkap
CREATE TABLE IF NOT EXISTS telaah_kegiatan (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    nama_kegiatan VARCHAR(255) NOT NULL,
    gambaran_umum TEXT,
    penerima_manfaat VARCHAR(255),
    strategi_pencapaian TEXT,
    metode_pelaksanaan TEXT,
    tahapan_pelaksanaan TEXT,
    tanggal_mulai DATE,
    tanggal_selesai DATE,
    status_telaah ENUM('Draft','Diajukan','Revisi','Disetujui','Ditolak') DEFAULT 'Draft',
    catatan_verifikator TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id)
);

-- Tabel Indikator Kinerja
CREATE TABLE IF NOT EXISTS indikator_kinerja (
    id INT AUTO_INCREMENT PRIMARY KEY,
    telaah_id INT NOT NULL,
    indikator_keberhasilan VARCHAR(255) NOT NULL,
    bulan_target VARCHAR(50),
    bobot_persen DECIMAL(5,2),
    FOREIGN KEY (telaah_id) REFERENCES telaah_kegiatan(id) ON DELETE CASCADE
);

-- Tabel Telaah IKU
CREATE TABLE IF NOT EXISTS telaah_iku (
    id INT AUTO_INCREMENT PRIMARY KEY,
    telaah_id INT NOT NULL,
    iku_id INT NOT NULL,
    target_value VARCHAR(100),
    FOREIGN KEY (telaah_id) REFERENCES telaah_kegiatan(id) ON DELETE CASCADE,
    FOREIGN KEY (iku_id) REFERENCES master_iku(id)
);

-- Tabel Telaah RAB
CREATE TABLE IF NOT EXISTS telaah_rab (
    id INT AUTO_INCREMENT PRIMARY KEY,
    telaah_id INT NOT NULL,
    kategori_id INT NOT NULL,
    uraian VARCHAR(255) NOT NULL,
    volume INT NOT NULL,
    satuan VARCHAR(50) NOT NULL,
    harga_satuan DECIMAL(18,2) NOT NULL,
    total DECIMAL(18,2) NOT NULL,
    FOREIGN KEY (telaah_id) REFERENCES telaah_kegiatan(id) ON DELETE CASCADE,
    FOREIGN KEY (kategori_id) REFERENCES master_kategori_anggaran(id)
);

-- 8. Tabel Dokumen Pendukung
CREATE TABLE IF NOT EXISTS dokumen_pendukung (
    id INT AUTO_INCREMENT PRIMARY KEY,
    usulan_id INT NOT NULL,
    jenis_dokumen ENUM('LPJ','Berita Acara','Bukti Transfer') NOT NULL,
    file_path VARCHAR(255) NOT NULL,
    versi INT NOT NULL DEFAULT 1,
    uploaded_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (usulan_id) REFERENCES usulan_kegiatan(id) ON DELETE CASCADE
);

-- 9. Tabel Notifikasi
CREATE TABLE IF NOT EXISTS notifikasi (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    judul VARCHAR(255) NOT NULL,
    pesan TEXT NOT NULL,
    link VARCHAR(255),
    is_read BOOLEAN DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

-- 10. Tabel Log Histori Usulan
CREATE TABLE IF NOT EXISTS log_histori_usulan (
    id INT AUTO_INCREMENT PRIMARY KEY,
    usulan_id INT NOT NULL,
    user_id INT NOT NULL,
    status_lama VARCHAR(50),
    status_baru VARCHAR(50),
    timestamp TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    catatan TEXT,
    FOREIGN KEY (usulan_id) REFERENCES usulan_kegiatan(id) ON DELETE CASCADE,
    FOREIGN KEY (user_id) REFERENCES users(id)
);

-- 11. Tabel Log Audit Sistem
CREATE TABLE IF NOT EXISTS log_audit_sistem (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    aksi ENUM('Login','Logout','Gagal Login','Reset Password') NOT NULL,
    ip_address VARCHAR(45),
    timestamp TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id)
);