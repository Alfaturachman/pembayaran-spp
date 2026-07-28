# Pembayaran SPP - Enterprise Grade System

Aplikasi Sistem Informasi Pembayaran SPP Sekolah terintegrasi yang dibangun menggunakan **Laravel 8.x**, dirancang dengan standar arsitektur MVC, keamanan tinggi, pengujian otomatis, dan kesiapan deployment produksi (Docker & CI/CD).

---

## Fitur Utama

- **Otentikasi Multi-Role**: Portal terpisah dengan hak akses dinamis untuk Admin, Staff/Petugas, dan Student/Siswa.
- **Manajemen Data Master**: Pengelolaan data Siswa, Petugas, Kelas, dan Tarif SPP per tahun ajaran.
- **Transaksi Pembayaran SPP**: Pencatatan transaksi pembayaran SPP harian dengan validasi otomatis.
- **Portal Log Siswa**: Siswa dapat memantau riwayat pembayaran pribadi dengan proteksi IDOR (*Insecure Direct Object Reference*).
- **Keamanan Ketat**: Proteksi CSRF, validasi Mass Assignment, dan hashing password terenkripsi.

---

## Dokumentasi Terstruktur (`docs/`)

Dokumentasi proyek ini terbagi secara mendalam pada folder `docs/`:

1. [01_PRD.md](docs/01_PRD.md) - Product Requirement Document & Spesifikasi Modul.
2. [02_ARCHITECTURE.md](docs/02_ARCHITECTURE.md) - Arsitektur MVC, Sequence Diagram, & Flow Otentikasi.
3. [03_API_ROUTES.md](docs/03_API_ROUTES.md) - Daftar Lengkap Route, Endpoint, & Middleware.
4. [04_DATABASE_SCHEMA.md](docs/04_DATABASE_SCHEMA.md) - ERD, Skema Tabel (`users`, `classes`, `spp`, `payments`).
5. [05_SECURITY_AND_AUDIT.md](docs/05_SECURITY_AND_AUDIT.md) - Laporan Keamanan, Audit Penanganan Bug, & Refactoring.
6. [06_USER_GUIDE.md](docs/06_USER_GUIDE.md) - Panduan Operasional Penggunaan untuk Admin, Staff, dan Siswa.

---

## Panduan Instalasi & Penggunaan Lokal

### Prasyarat
- PHP >= 8.1
- Composer >= 2.0
- MySQL / MariaDB
- Node.js & NPM (opsional untuk frontend assets)

### Langkah Instalasi
```bash
# 1. Clone repository
$ git clone https://github.com/Alfaturachman/pembayaran-spp.git
$ cd pembayaran-spp

# 2. Install dependensi composer
$ composer install

# 3. Salin environment file
$ cp .env.example .env

# 4. Generate application key
$ php artisan key:generate

# 5. Konfigurasi database pada .env, lalu jalankan migrasi & seeder
$ php artisan migrate --seed

# 6. Jalankan server lokal
$ php artisan serve
```

Aplikasi dapat diakses melalui browser pada `http://localhost:8000`.

---

## Menjalankan dengan Docker

Proyek ini telah dilengkapi dengan kontainerisasi Docker:

```bash
# Jalankan seluruh service (App, Nginx, MySQL, Redis)
$ docker-compose up -d --build
```

Aplikasi akan berjalan di `http://localhost:8080`.

---

## Automated Testing

Pengujian otomatis dapat dijalankan menggunakan PHPUnit:

```bash
# Jalankan Unit Test suite
$ vendor/bin/phpunit --testsuite=Unit

# Jalankan seluruh Test Suite
$ vendor/bin/phpunit
```

---

## Production Deployment

Untuk deployment ke server produksi, gunakan skrip otomatisasi deployment:

```bash
$ chmod +x deploy.sh
$ ./deploy.sh
```

---

## Lisensi

- Copyright (c) 2024 Alfaturachman Maulana Pahlevi
- Berlisensi di bawah lisensi MIT open-source.
