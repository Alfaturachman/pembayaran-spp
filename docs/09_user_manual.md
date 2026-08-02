# User & Operational Guide - Aplikasi Pembayaran SPP

Dokumen ini berisi panduan teknis dan operasional penggunaan aplikasi **Pembayaran SPP** untuk peran **Admin**, **Staff**, dan **Siswa**.

---

## 1. Panduan Akses & Login

1. Buka peramban (browser) dan akses alamat web aplikasi (misal: `http://localhost/pembayaran-spp/public/login` atau URL server).
2. Masukkan **Email / Username** dan **Password**.
3. Klik tombol **Login**.
4. Sistem akan secara otomatis mengarahkan Anda ke Dasbor sesuai peran (*Admin*, *Staff*, atau *Student*).

---

## 2. Panduan Pengguna: Admin

### 2.1. Manajemen Data Kelas
- **Melihat Daftar Kelas**: Navigasi ke menu `Data Kelas`.
- **Tambah Kelas**: Klik tombol `Tambah Data Kelas`, isi form (ID Kelas, Nama Kelas, Kompetensi Keahlian), lalu klik `Simpan`.
- **Edit Kelas**: Klik tombol `Edit` pada baris kelas yang ingin diubah, lakukan penyesuaian, lalu simpan.
- **Hapus Kelas**: Klik tombol `Hapus` untuk menghapus data kelas.

### 2.2. Manajemen Data Siswa
- **Melihat Daftar Siswa**: Navigasi ke menu `Data Siswa`.
- **Tambah Siswa Baru**: Klik `Tambah Data Siswa`, isi NISN, Nama, Username, Email, Password, Alamat, Telepon, dan Pilih Kelas dari dropdown, lalu klik `Simpan`.
- **Edit & Reset Password Siswa**: Buka form Edit Siswa. Isi password baru *hanya jika* ingin mengganti password siswa. Jika dibiarkan kosong, password lama tidak akan berubah.

### 2.3. Manajemen Data Petugas/Staff
- Navigasi ke menu `Data Petugas`.
- Kelola akun staff kasir yang berhak memproses pembayaran SPP sekolah.

---

## 3. Panduan Pengguna: Staff / Petugas

### 3.1. Memproses Pembayaran SPP
1. Navigasi ke menu `Data SPP Siswa`.
2. Klik tombol `Tambah Transaksi Pembayaran`.
3. Isi data transaksi: NISN Siswa, Nama Siswa, Bulan, Tahun, dan Nominal Pembayaran.
4. Klik tombol `Simpan`. Transaksi akan langsung tercatat dan dapat dilihat oleh siswa yang bersangkutan.

---

## 4. Panduan Pengguna: Student / Siswa

### 4.1. Melihat Histori Pembayaran SPP Pribadi
1. Login menggunakan akun siswa (Email/Username dan Password siswa).
2. Anda akan secara otomatis diarahkan ke `Dasbor Siswa`.
3. Navigasi ke menu `Log SPP` (`/student/data-log-spp`).
4. Anda dapat melihat daftar seluruh transaksi pembayaran SPP yang telah berhasil dibayarkan atas nama Anda.

---

## 5. Pertanyaan Sering Diajukan (FAQ)

- **Lupa Password Siswa/Petugas?**  
  Admin dapat melakukan reset password melalui menu `Data Siswa` atau `Data Petugas` dengan mengedit akun terkait dan memasukkan password baru.
- **Bagaimana jika transaksi pembayaran salah input?**  
  Admin atau Staff dapat menghapus entri transaksi yang keliru dari menu Data SPP lalu menginput ulang transaksi yang benar.
