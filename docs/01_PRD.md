# Product Requirement Document (PRD) - Aplikasi Pembayaran SPP

## 1. Informasi Proyek
- **Nama Aplikasi**: Sistem Informasi Pembayaran SPP Sekolah (Pembayaran SPP)
- **Framework**: Laravel 8.x
- **Teknologi**: PHP, MySQL/MariaDB, Blade Templating, Bootstrap / Stisla Admin UI
- **Status Proyek**: Production Ready (Audited & Refactored)

---

## 2. Latar Belakang & Tujuan
Aplikasi **Pembayaran SPP** dirancang untuk mengelola data dan proses transaksi pembayaran Sumbangan Pembinaan Pendidikan (SPP) di lingkungan sekolah secara digital. Sistem ini bertujuan untuk:
- Menggantikan pencatatan manual pembayaran SPP menjadi terintegrasi dan otomatis.
- Menyediakan transparansi data pembayaran bagi siswa dan wali murid.
- Memudahkan petugas/kasir dan administrator dalam mengelola data master (siswa, kelas, SPP, petugas) dan pelaporan transaksi.

---

## 3. Pengguna & Hak Akses (User Roles)

Sistem ini mendukung 3 peran pengguna (*multi-role authentication*):

### 3.1. Admin
- Memiliki hak akses penuh (*Full Privileges*) ke seluruh fitur sistem.
- Mengelola data master: Data Siswa, Data Petugas/Staff, Data Kelas, dan Data Tarif SPP.
- Mengelola dan memantau seluruh transaksi pembayaran SPP.
- Melihat laporan dan rekapitulasi data sekolah.

### 3.2. Staff / Petugas
- Bertanggung jawab atas pemprosesan transaksi pembayaran SPP harian.
- Menginput transaksi pembayaran SPP siswa.
- Mengedit/mengubah histori pembayaran siswa jika terjadi kekeliruan pencatatan.
- Melihat daftar tagihan dan histori transaksi pembayaran.

### 3.3. Student / Siswa
- Pengguna dengan hak akses khusus (*Self-Service / Read-Only Transaksi*).
- Melihat dasbor ringkasan status pembayaran SPP pribadi.
- Melihat dan mencetak riwayat/log pembayaran SPP milik sendiri.
- Mengajukan/menginput log entri pembayaran jika diizinkan oleh sistem.

---

## 4. Fitur Utama

| Modul | Fitur | Deskripsi | Access Role |
| :--- | :--- | :--- | :--- |
| **Autentikasi** | Multi-Role Login | Login terpusat berbasis username/email & password dengan otomatisasi redirect ke dasbor sesuai role | Guest / All |
| **Autentikasi** | Logout & Session Management | Manajemen sesi login aman dengan enkripsi cookie & token CSRF | Auth User |
| **Master Kelas** | CRUD Data Kelas | Manajemen data kelas (ID Kelas, Nama Kelas, Kompetensi Keahlian) | Admin |
| **Master Siswa** | CRUD Data Siswa | Manajemen profil siswa (NISN, Nama, Username, Email, Password, Alamat, Telepon, Kelas) | Admin |
| **Master Petugas** | CRUD Data Petugas | Manajemen akun staff/kasir sekolah (Nama, Email, Username, Alamat, Telepon) | Admin |
| **Master SPP** | CRUD Tarif SPP | Pengaturan tarif nominal SPP per tahun ajaran | Admin |
| **Pembayaran** | Entri Transaksi SPP | Pencatatan transaksi pembayaran SPP (NISN, Nama, Bulan, Tahun, Nominal Pembayaran) | Admin, Staff |
| **Histori Siswa**| Log SPP Personal | Melihat riwayat transaksi pembayaran SPP diri sendiri secara mandiri | Student |

---

## 5. Non-Functional Requirements (NFR)

- **Keamanan (Security)**:
  - Seluruh Form dilengkapi token proteksi Cross-Site Request Forgery (`@csrf`).
  - Proteksi Insecure Direct Object Reference (IDOR) pada portal siswa.
  - Enkripsi password menggunakan algoritma `bcrypt`.
  - Validasi ketat pada setiap payload masukan (*Mass Assignment Protection*).
- **Performa**:
  - Response time halaman dasbor di bawah 500ms.
  - Paginasi dan query efisien menggunakan Eloquent ORM.
- **Usabilitas**:
  - Antarmuka berbasis responsive web UI yang ramah pengguna.
