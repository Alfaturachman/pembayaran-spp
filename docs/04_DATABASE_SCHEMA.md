# Database Schema & Entity Documentation - Aplikasi Pembayaran SPP

Dokumen ini mendeskripsikan struktur basis data, tabel, tipe data, serta relasi antar entitas pada sistem **Pembayaran SPP**.

---

## 1. ERD & Entity Relationships Summary

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

## 2. Definisi Struktur Tabel

### 2.1. Tabel `users`
Menyimpan seluruh data akun pengguna (Admin, Staff/Petugas, dan Student/Siswa).

| Column Name | Data Type | Modifiers | Description |
| :--- | :--- | :--- | :--- |
| `id` | `BIGINT` | `UNSIGNED`, `AUTO_INCREMENT`, `PRIMARY KEY` | Unique ID Pengguna |
| `nisn` | `VARCHAR(255)` | `NULLABLE`, `UNIQUE` | Nomor Induk Siswa Nasional (Khusus Siswa) |
| `name` | `VARCHAR(255)` | `NOT NULL` | Nama Lengkap Pengguna |
| `username` | `VARCHAR(255)` | `NOT NULL` | Username untuk login |
| `email` | `VARCHAR(255)` | `NOT NULL`, `UNIQUE` | Alamat Email |
| `email_verified_at`| `TIMESTAMP` | `NULLABLE` | Timestamp verifikasi email |
| `password` | `VARCHAR(255)` | `NOT NULL` | Hash Bcrypt Password |
| `address` | `VARCHAR(255)` | `NULLABLE` | Alamat Tempat Tinggal |
| `phone_number` | `VARCHAR(255)` | `NULLABLE` | Nomor Telepon / HP |
| `class` | `VARCHAR(255)` | `NULLABLE` | Nama Kelas Siswa (e.g. "XII — RPL") |
| `roles` | `VARCHAR(255)` | `NOT NULL`, `DEFAULT('STUDENT')` | Peran Pengguna (`ADMIN`, `STAFF`, `STUDENT`) |
| `remember_token` | `VARCHAR(100)` | `NULLABLE` | Token sesi remember me |
| `created_at` | `TIMESTAMP` | `NULLABLE` | Timestamp pembuatan |
| `updated_at` | `TIMESTAMP` | `NULLABLE` | Timestamp pembaruan |

---

### 2.2. Tabel `classes`
Menyimpan daftar data kelas dan kompetensi keahlian / jurusan.

| Column Name | Data Type | Modifiers | Description |
| :--- | :--- | :--- | :--- |
| `id` | `BIGINT` | `UNSIGNED`, `AUTO_INCREMENT`, `PRIMARY KEY` | Unique ID Kelas |
| `class_id` | `VARCHAR(255)` | `NOT NULL` | Kode Kategori Kelas (e.g. "RPL001") |
| `class_name` | `VARCHAR(255)` | `NOT NULL` | Nama Kelas (e.g. "XII — RPL") |
| `skill_competence`| `VARCHAR(255)` | `NOT NULL` | Jurusan / Kompetensi Keahlian |
| `deleted_at` | `TIMESTAMP` | `NULLABLE` | Soft delete timestamp |
| `created_at` | `TIMESTAMP` | `NULLABLE` | Timestamp pembuatan |
| `updated_at` | `TIMESTAMP` | `NULLABLE` | Timestamp pembaruan |

---

### 2.3. Tabel `spp`
Menyimpan acuan tarif pembayaran SPP berdasarkan tahun ajaran.

| Column Name | Data Type | Modifiers | Description |
| :--- | :--- | :--- | :--- |
| `id` | `BIGINT` | `UNSIGNED`, `AUTO_INCREMENT`, `PRIMARY KEY` | Unique ID SPP |
| `year` | `INT` | `NOT NULL` | Tahun Ajaran (e.g. 2024) |
| `nominal` | `INT` | `NOT NULL` | Nominal Tagihan SPP (e.g. 150000) |
| `created_at` | `TIMESTAMP` | `NULLABLE` | Timestamp pembuatan |
| `updated_at` | `TIMESTAMP` | `NULLABLE` | Timestamp pembaruan |

---

### 2.4. Tabel `payments`
Menyimpan riwayat dan bukti transaksi pembayaran SPP.

| Column Name | Data Type | Modifiers | Description |
| :--- | :--- | :--- | :--- |
| `id` | `BIGINT` | `UNSIGNED`, `AUTO_INCREMENT`, `PRIMARY KEY` | Unique ID Transaksi Pembayaran |
| `id_spp` | `BIGINT` | `UNSIGNED`, `NULLABLE` | ID Ref ke tabel `spp` |
| `id_user` | `BIGINT` | `UNSIGNED`, `NULLABLE` | ID Ref ke tabel `users` (Siswa) |
| `nisn` | `VARCHAR(255)` | `NOT NULL` | NISN Siswa pembayar |
| `name` | `VARCHAR(255)` | `NOT NULL` | Nama Siswa pembayar |
| `month` | `VARCHAR(255)` | `NOT NULL` | Bulan Pembayaran (e.g. "Januari") |
| `year` | `VARCHAR(255)` | `NOT NULL` | Tahun Pembayaran (e.g. "2024") |
| `total_payment` | `INT` | `NOT NULL` | Jumlah Nominal Yang Dibayarkan |
| `remember_token` | `VARCHAR(100)` | `NULLABLE` | Token opsional |
| `created_at` | `TIMESTAMP` | `NULLABLE` | Timestamp transaksi dibuat |
| `updated_at` | `TIMESTAMP` | `NULLABLE` | Timestamp transaksi diubah |
