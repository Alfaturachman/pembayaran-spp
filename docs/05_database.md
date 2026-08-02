# Database Specification & Data Dictionary - Aplikasi Pembayaran SPP

## 1. Entity Relationship Diagram (ERD)

```
   +--------------------+               +--------------------+
   |       users        |               |      classes       |
   +--------------------+               +--------------------+
   | id (PK)            |<--------------| id (PK)            |
   | nisn               |  class_name   | class_id           |
   | name               |               | class_name         |
   | username           |               | skill_competence   |
   | email              |               +--------------------+
   | password           |
   | address            |               +--------------------+
   | phone_number       |               |        spp         |
   | class              |               +--------------------+
   | roles              |               | id (PK)            |
   +--------------------+               | year               |
             |                          | nominal            |
             |                          +--------------------+
             | id_user / nisn                     | id_spp
             v                                    v
   +---------------------------------------------------------+
   |                        payments                         |
   +---------------------------------------------------------+
   | id (PK)                                                 |
   | id_spp (FK -> spp.id)                                   |
   | id_user (FK -> users.id)                                |
   | nisn                                                    |
   | name                                                    |
   | month                                                   |
   | year                                                    |
   | total_payment                                           |
   +---------------------------------------------------------+
```

---

## 2. Kamus Data (Data Dictionary)

### 2.1. Tabel `users`
Menyimpan seluruh data akun pengguna (Admin, Staff/Petugas, dan Student/Siswa).

| Nama Kolom | Tipe Data | Modifiers | Deskripsi |
| :--- | :--- | :--- | :--- |
| `id` | `BIGINT` | `UNSIGNED`, `AUTO_INCREMENT`, `PRIMARY KEY` | Unique ID Pengguna |
| `nisn` | `VARCHAR(255)` | `NULLABLE`, `UNIQUE` | Nomor Induk Siswa Nasional (Khusus Siswa) |
| `name` | `VARCHAR(255)` | `NOT NULL` | Nama Lengkap Pengguna |
| `username` | `VARCHAR(255)` | `NOT NULL` | Username unik untuk login |
| `email` | `VARCHAR(255)` | `NOT NULL`, `UNIQUE` | Alamat Email Pengguna |
| `email_verified_at`| `TIMESTAMP` | `NULLABLE` | Timestamp verifikasi email |
| `password` | `VARCHAR(255)` | `NOT NULL` | Hash Password Bcrypt |
| `address` | `VARCHAR(255)` | `NULLABLE` | Alamat Rumah Pengguna |
| `phone_number` | `VARCHAR(255)` | `NULLABLE` | Nomor HP / Telepon |
| `class` | `VARCHAR(255)` | `NULLABLE` | Nama Kelas Siswa (misal: "XII — RPL") |
| `roles` | `VARCHAR(255)` | `NOT NULL`, `DEFAULT('STUDENT')` | Peran Akses (`ADMIN`, `STAFF`, `STUDENT`) |
| `remember_token` | `VARCHAR(100)` | `NULLABLE` | Token sesi "Remember Me" |
| `created_at` | `TIMESTAMP` | `NULLABLE` | Waktu data dibuat |
| `updated_at` | `TIMESTAMP` | `NULLABLE` | Waktu data diubah terakhir kali |

---

### 2.2. Tabel `classes`
Menyimpan daftar data kelas dan kompetensi keahlian / jurusan sekolah.

| Nama Kolom | Tipe Data | Modifiers | Deskripsi |
| :--- | :--- | :--- | :--- |
| `id` | `BIGINT` | `UNSIGNED`, `AUTO_INCREMENT`, `PRIMARY KEY` | Unique ID Kelas |
| `class_id` | `VARCHAR(255)` | `NOT NULL` | Kode Kategori Kelas (misal: "RPL001") |
| `class_name` | `VARCHAR(255)` | `NOT NULL` | Nama Kelas (misal: "XII — RPL") |
| `skill_competence`| `VARCHAR(255)` | `NOT NULL` | Jurusan / Kompetensi Keahlian |
| `deleted_at` | `TIMESTAMP` | `NULLABLE` | Soft Delete Timestamp |
| `created_at` | `TIMESTAMP` | `NULLABLE` | Waktu data dibuat |
| `updated_at` | `TIMESTAMP` | `NULLABLE` | Waktu data diubah terakhir kali |

---

### 2.3. Tabel `spp`
Menyimpan acuan tarif pembayaran SPP berdasarkan tahun ajaran.

| Nama Kolom | Tipe Data | Modifiers | Deskripsi |
| :--- | :--- | :--- | :--- |
| `id` | `BIGINT` | `UNSIGNED`, `AUTO_INCREMENT`, `PRIMARY KEY` | Unique ID Tarif SPP |
| `year` | `INT` | `NOT NULL` | Tahun Ajaran SPP (misal: 2024) |
| `nominal` | `INT` | `NOT NULL` | Nominal Tagihan SPP (misal: 150000) |
| `created_at` | `TIMESTAMP` | `NULLABLE` | Waktu data dibuat |
| `updated_at` | `TIMESTAMP` | `NULLABLE` | Waktu data diubah terakhir kali |

---

### 2.4. Tabel `payments`
Menyimpan riwayat dan bukti transaksi pembayaran SPP siswa.

| Nama Kolom | Tipe Data | Modifiers | Deskripsi |
| :--- | :--- | :--- | :--- |
| `id` | `BIGINT` | `UNSIGNED`, `AUTO_INCREMENT`, `PRIMARY KEY` | Unique ID Transaksi Pembayaran |
| `id_spp` | `BIGINT` | `UNSIGNED`, `NULLABLE` | Ref ke `spp.id` (Tarif SPP) |
| `id_user` | `BIGINT` | `UNSIGNED`, `NULLABLE` | Ref ke `users.id` (Pengguna Siswa) |
| `nisn` | `VARCHAR(255)` | `NOT NULL` | NISN Siswa Pembayar |
| `name` | `VARCHAR(255)` | `NOT NULL` | Nama Lengkap Siswa Pembayar |
| `month` | `VARCHAR(255)` | `NOT NULL` | Bulan Pembayaran (misal: "Januari") |
| `year` | `VARCHAR(255)` | `NOT NULL` | Tahun Pembayaran (misal: "2024") |
| `total_payment` | `INT` | `NOT NULL` | Jumlah Nominal Yang Dibayarkan |
| `remember_token` | `VARCHAR(100)` | `NULLABLE` | Token opsional |
| `created_at` | `TIMESTAMP` | `NULLABLE` | Waktu transaksi dibuat |
| `updated_at` | `TIMESTAMP` | `NULLABLE` | Waktu transaksi diubah |
