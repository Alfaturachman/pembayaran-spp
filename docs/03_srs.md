# Software Requirements Specification (SRS) - Aplikasi Pembayaran SPP

## 1. Pendahuluan
Dokumen **Software Requirements Specification (SRS)** ini mendeskripsikan secara detail kebutuhan fungsional, kebutuhan non-fungsional, batasan sistem, dan spesifikasi antarmuka perangkat lunak pada **Aplikasi Pembayaran SPP**.

---

## 2. Kebutuhan Fungsional (Functional Requirements)

### FR-01: Autentikasi & Pengelolaan Sesi
- **FR-01.1**: Sistem harus menyediakan mekanisme autentikasi terpusat berbasis username/email dan password.
- **FR-01.2**: Password harus dienkripsi menggunakan algoritma Hash Bcrypt.
- **FR-01.3**: Sesi login harus dilindungi cookie terenkripsi dan token CSRF pada setiap form masukan.
- **FR-01.4**: Sesi harus otomatis hancur ketika pengguna melakukan logout.

### FR-02: Pengelolaan Role & Akses (RBAC)
- **FR-02.1**: Sistem harus mendukung 3 role utama: `ADMIN`, `STAFF`, dan `STUDENT`.
- **FR-02.2**: Route `/admin/*` hanya dapat diakses oleh peran `ADMIN`.
- **FR-02.3**: Route `/staff/*` hanya dapat diakses oleh peran `STAFF`.
- **FR-02.4**: Route `/student/*` hanya dapat diakses oleh peran `STUDENT`.
- **FR-02.5**: Upaya akses tanpa wewenang harus diblokir oleh middleware dan diarahkan kembali ke halaman aman (`/`).

### FR-03: Manajemen Data Master Kelas
- **FR-03.1**: Admin dapat menambah data kelas baru (ID Kelas, Nama Kelas, Kompetensi Keahlian).
- **FR-03.2**: Admin dapat memperbarui dan menghapus data kelas yang ada.

### FR-04: Manajemen Data Siswa
- **FR-04.1**: Admin dapat menginput siswa baru beserta NISN, Nama, Username, Email, Password, Alamat, Telepon, dan Penetapan Kelas.
- **FR-04.2**: Sistem mendukung pembaruan data siswa dan reset password opsional.

### FR-05: Manajemen Data Petugas/Staff
- **FR-05.1**: Admin dapat mengelola akun staff/kasir yang diberi wewenang mencatat pembayaran SPP.

### FR-06: Manajemen Tarif SPP
- **FR-06.1**: Admin dapat menetapkan nominal tarif SPP berdasarkan tahun ajaran.

### FR-07: Transaksi Pembayaran SPP
- **FR-07.1**: Admin dan Staff dapat mencatat transaksi pembayaran SPP siswa (NISN, Nama, Bulan, Tahun, Nominal).
- **FR-07.2**: Transaksi terhubung dengan acuan tarif SPP dan data pengguna terkait.

### FR-08: Log Pembayaran Siswa (Self-Service)
- **FR-08.1**: Siswa dapat melihat riwayat transaksi pembayaran SPP milik sendiri.
- **FR-08.2**: Sistem membatasi query data pembayaran siswa secara ketat berdasarkan ID/NISN pengguna terautentikasi (Proteksi IDOR).

---

## 3. Kebutuhan Non-Fungsional (Non-Functional Requirements)

### 3.1. Keamanan (Security)
- **CSRF Protection**: Seluruh form masukan HTTP POST/PUT/DELETE wajib menyertakan token `@csrf`.
- **IDOR Protection**: Endpoint siswa dibatasi hanya untuk membaca data milik sendiri (`Auth::user()`).
- **Mass Assignment Protection**: Menggunakan `$request->validate()` eksplisit pada seluruh controller action.
- **Password Safe Mutator**: Memastikan mutator model tidak melakukan *double hashing* atau menimpa password dengan nilai kosong saat update profil.

### 3.2. Performa & Respon Sistem
- Waktu respon rata-rata halaman web di bawah 500ms pada beban normal.
- Paginasi data efisien menggunakan Eloquent ORM Laravel.

### 3.3. Ketersediaan & Keandalan (Availability)
- Aplikasi dirancang untuk berjalan pada lingkungan web server standar (Nginx/Apache) dengan MySQL 8.0.
- Dukungan containerization Docker untuk kemudahan deployment & penanganan kegagalan.

---

## 4. Batasan Sistem (System Constraints)
- **PHP Version**: Membutuhkan PHP versi `>= 8.2` (sesuai spesifikasi `composer.lock` & Symfony 7.x components).
- **Database Engine**: MySQL 8.0 / MariaDB 10.4+.
- **Browser Compatibility**: Mendukung peramban modern (Chrome, Edge, Firefox, Safari).
