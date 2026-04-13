# SIPUS SMEKDA (Sistem Informasi Perpustakaan SMEKDA)

SIPUS SMEKDA adalah aplikasi perpustakaan digital berbasis web yang dirancang untuk mendigitalisasi sirkulasi peminjaman buku di SMKN 2 Purwakarta. Dibangun dengan fokus pada integritas data dan keamanan transaksi menggunakan Laravel.

---

## Stack Teknologi

- **Framework:** Laravel 12
- **Bahasa Pemrograman:** PHP 8+
- **Frontend:** Bootstrap 5, JavaScript (ES6+)
- **Database:** MySQL/MariaDB (Menggunakan Database Transaction dan Row Locking)

---

## Akun Login Demo

Gunakan akun di bawah ini untuk menguji fungsionalitas sistem:

| Role | Email / Akun | Password |
| :--- | :--- | :--- |
| Admin | admin@gmail.com | 123123123 |
| Siswa | coco@gmail.com | 123123123 |

---

## Alur Kerja Sistem

### Prosedur Peminjaman
1. **Registrasi Akun:** Siswa mendaftar sebagai anggota resmi terlebih dahulu.
2. **Katalog Digital:** Menjelajahi koleksi melalui katalog untuk memilih buku.
3. **Isi Form Pinjam:** Masuk ke menu **Peminjaman Saya** dan isi detail buku yang dipilih.
4. **Verifikasi Admin:** Menunggu persetujuan admin (validasi stok dan kuota).
5. **Pengambilan Buku:** Mengambil buku fisik di perpustakaan setelah status **Disetujui**.

### Prosedur Pengembalian
1. **Akses Akun:** Login menggunakan akun yang sudah terdaftar.
2. **Menu Pengembalian:** Pilih buku yang sedang dipinjam pada sidebar navigasi.
3. **Ajukan Sistem:** Klik tombol **Ajukan Pengembalian**.
4. **Status Verifikasi:** Status pada sistem berubah menjadi **Menunggu Verifikasi**.
5. **Penyerahan Fisik:** Serahkan buku ke petugas untuk pengecekan kondisi dan validasi denda.
6. **Validasi dan Selesai:** Petugas melakukan konfirmasi dan stok buku otomatis kembali ke rak.

**Catatan Penting:** Pengajuan di sistem belum dianggap selesai sebelum buku fisik diserahkan langsung ke petugas perpustakaan.

---

## Fitur Utama Sistem

### 1. Dashboard Overview
- **Admin Dashboard:** Menampilkan ringkasan statistik real-time (Total Anggota: 11, Total Buku: 11, Sedang Dipinjam: 2, Keterlambatan: 0). Menggunakan aksen warna merah.
- **Siswa Dashboard:** Menampilkan koleksi buku unggulan dan tombol akses cepat ke menu peminjaman dan pengembalian. Menggunakan aksen warna hijau.

### 2. Fitur Admin (Control Center)
- **Data Master:**
    - **Kelola Data Buku:** Fungsi CRUD untuk judul, penulis, stok, dan kategori buku.
    - **Data Anggota:** Manajemen akun siswa dan admin (Tambah, Edit, Hapus).
- **Operation:**
    - **Transaksi Peminjaman:** Verifikasi pengajuan pinjam dengan kontrol stok menggunakan `lockForUpdate`.
    - **Transaksi Pengembalian:** Validasi akhir pengembalian fisik dan pembaruan stok otomatis.

### 3. Fitur Siswa (User Experience)
- **Katalog Literasi:** Akses ke berbagai kategori buku (Sastra, Teknologi, Edukasi).
- **Peminjaman Mandiri:** Sistem kuota maksimal 3 buku dengan otomatisasi tanggal kembali (7 hari dari tanggal pinjam).
- **Riwayat dan Catatan:** Melihat status transaksi serta alasan jika pengajuan ditolak oleh admin.