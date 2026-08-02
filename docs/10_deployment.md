# Deployment & Infrastructure Specification - Aplikasi Pembayaran SPP

Dokumen ini memuat panduan lengkap konfigurasi lingkungan, deployment lokal (Laragon/XAMPP), Docker containerization, serta pipeline CI/CD GitHub Actions pada aplikasi **Pembayaran SPP**.

---

## 1. Persyaratan Lingkungan (Environment Requirements)

| Perangkat Lunak | Versi Minimal | Versi Rekomendasi |
| :--- | :--- | :--- |
| **PHP** | `8.2.0` | `8.3.x` |
| **Composer** | `2.x` | `2.7.x` |
| **MySQL / MariaDB** | `8.0` / `10.4` | `8.0.30` |
| **Node.js & NPM** | `16.x` | `18.x / 20.x` |
| **Docker Engine** | `20.10+` | Latest Stable |

---

## 2. Pengaturan Lingkungan Lokal (Local Development Setup)

1. **Clone Repository**:
   ```bash
   git clone https://github.com/Alfaturachman/pembayaran-spp.git
   cd pembayaran-spp
   ```

2. **Salin & Konfigurasi File `.env`**:
   ```bash
   cp .env.example .env
   ```
   Sesuaikan variabel koneksi database di file `.env`:
   ```env
   APP_NAME="Pembayaran SPP"
   APP_ENV=local
   APP_KEY=
   APP_DEBUG=true
   APP_URL=http://localhost

   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=pembayaran_spp
   DB_USERNAME=root
   DB_PASSWORD=
   ```

3. **Install Dependensi & Generate Key**:
   ```bash
   composer install
   php artisan key:generate
   ```

4. **Jalankan Migrasi & Seeder Database**:
   ```bash
   php artisan migrate --seed
   ```

5. **Jalankan Web Server**:
   ```bash
   php artisan serve
   ```
   Aplikasi dapat diakses melalui `http://127.0.0.1:8000`.

---

## 3. Deployment Berbasis Docker (Containerization)

Aplikasi telah dilengkapi konfigurasi Docker lengkap:

### 3.1. File `Dockerfile`
Menyiapkan PHP 8.2 FPM / Apache environment beserta ekstensi yang dibutuhkan:
```dockerfile
FROM php:8.2-fpm
# Install system dependencies & extensions (pdo_mysql, mbstring, bcmath, dll)
...
```

### 3.2. File `docker-compose.yml`
Menjalankan layanan aplikasi web dan MySQL 8.0 secara bersamaan:
```yaml
version: '3.8'
services:
  app:
    build: .
    ports:
      - "8000:8000"
    volumes:
      - .:/var/www/html
  db:
    image: mysql:8.0
    environment:
      MYSQL_DATABASE: pembayaran_spp
      MYSQL_ROOT_PASSWORD: root
    ports:
      - "3306:3306"
```

### 3.3. Script `deploy.sh`
Perintah bash otomatisasi deployment produksi:
```bash
#!/bin/bash
composer install --no-dev --optimize-autoloader
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan migrate --force
```

---

## 4. Pipeline CI/CD (GitHub Actions Workflow)

Pipeline diatur pada [.github/workflows/ci.yml](file:///d:/laragon/www/pembayaran-spp/.github/workflows/ci.yml). Setiap kali ada `push` atau `pull_request` ke branch `main`/`master`, CI akan secara otomatis menjalankan:

1. **Setup Environment**: PHP 8.2 dengan ekstensi `mbstring`, `pdo_mysql`, `bcmath`, `ctype`, `json`, `openssl`, `tokenizer`, `xml`.
2. **Service MySQL**: Menjalankan MySQL 8.0 container untuk database pengujian `pembayaran_spp_test`.
3. **Install Dependencies**: `composer install --prefer-dist --no-interaction`.
4. **Generate Key & Permissions**: `php artisan key:generate` dan pemberian izin folder `storage`.
5. **Running Test Suite**: `vendor/bin/phpunit`.

```yaml
name: Laravel CI/CD Pipeline
on:
  push:
    branches: [ main, master, develop ]
  pull_request:
    branches: [ main, master ]
jobs:
  laravel-tests:
    runs-on: ubuntu-latest
    steps:
      - uses: actions/checkout@v3
      - name: Setup PHP
        uses: shivammathur/setup-php@v2
        with:
          php-version: '8.2'
      - name: Install Dependencies
        run: composer install --prefer-dist --no-interaction --no-progress
      - name: Run PHPUnit Test Suite
        run: vendor/bin/phpunit
```
