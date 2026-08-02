# Pembayaran SPP - Enterprise Grade System

Aplikasi Sistem Informasi Pembayaran SPP Sekolah terintegrasi yang dibangun menggunakan **Laravel 8.x**, dirancang dengan standar arsitektur MVC, keamanan tinggi, pengujian otomatis (PHPUnit), dan kesiapan deployment produksi (Docker & CI/CD GitHub Actions).

---

## Fitur Utama

- **Otentikasi Multi-Role**: Portal terpisah dengan hak akses dinamis untuk Admin, Staff/Petugas, dan Student/Siswa.
- **Manajemen Data Master**: Pengelolaan data Siswa, Petugas, Kelas, dan Tarif SPP per tahun ajaran.
- **Transaksi Pembayaran SPP**: Pencatatan transaksi pembayaran SPP harian dengan validasi otomatis.
- **Portal Log Siswa**: Siswa dapat memantau riwayat pembayaran pribadi dengan proteksi IDOR (*Insecure Direct Object Reference*).
- **Keamanan Ketat**: Proteksi CSRF, validasi Mass Assignment, dan hashing password terenkripsi.

---

## Dokumentasi Terstruktur (`docs/`)

Dokumentasi proyek ini terbagi secara terstruktur pada folder `docs/`:

1. [01_brd.md](docs/01_brd.md) - Business Requirement Document & Target Bisnis.
2. [02_prd.md](docs/02_prd.md) - Product Requirement Document & User Stories.
3. [03_srs.md](docs/03_srs.md) - Software Requirements Specification & Technical Limits.
4. [04_architecture.md](docs/04_architecture.md) - Arsitektur MVC, Sequence Diagram, & Tech Stack.
5. [05_database.md](docs/05_database.md) - ERD & Kamus Data (`users`, `classes`, `spp`, `payments`).
6. [06_desain.md](docs/06_desain.md) - Panduan Desain & Style Guide UI.
7. [07_routing.md](docs/07_routing.md) - Dokumentasi API Endpoint & Middleware.
8. [08_testing.md](docs/08_testing.md) - QA Specification, Automated Testing & Results.
9. [09_user_manual.md](docs/09_user_manual.md) - Panduan Operasional Pengguna/Admin.
10. [10_deployment.md](docs/10_deployment.md) - Docker Setup, Environment (.env) & CI/CD Pipeline.

---

## Panduan Instalasi & Penggunaan Lokal

### Prasyarat
- PHP >= 8.2
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
# Jalankan seluruh service (App, Nginx, MySQL)
$ docker-compose up -d --build
```

Aplikasi akan berjalan di `http://localhost:8000`.

---

## Automated Testing

Pengujian otomatis dapat dijalankan menggunakan PHPUnit:

```bash
# Jalankan seluruh Test Suite (36 tests, 100% pass)
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
