# Panduan Desain & Style Guide UI - Aplikasi Pembayaran SPP

## 1. Konsep & Prinsip Desain
Aplikasi **Pembayaran SPP** mengusung desain antarmuka antarmuka yang bersih, intuitif, dan responsif menggunakan komponen antarmuka Stisla Admin Template dan Bootstrap.

Prinsip utama antarmuka:
- **Clarity & Simplicity**: Informasi disajikan dalam kartu statis (*stat cards*), tabel terstruktur, dan form modal yang mudah dipahami.
- **Visual Hierarchy**: Penggunaan kontras warna yang jelas antara tombol aksi utama (*Primary*), sukses (*Success*), peringatan (*Warning*), dan bahaya (*Danger*).
- **Responsive Layout**: Tampilan beradaptasi secara optimal pada perangkat layar desktop, tablet, dan smartphone.

---

## 2. Palet Warna (Color Palette)

| Nama Warna | Kode Hex | Penggunaan Utama |
| :--- | :--- | :--- |
| **Primary Blue** | `#6777ef` | Brand Identity, Navbar, Tombol Aksi Utama |
| **Secondary Gray**| `#cdd3d8` | Subtitle, Border, Inactive Element |
| **Success Green** | `#47c363` | Notifikasi Sukses, Badge Status Lunas |
| **Warning Yellow**| `#ffa426` | Status Alert, Tombol Edit |
| **Danger Red** | `#fc544b` | Tombol Hapus, Pesan Error Validasi |
| **Background Gray**| `#f4f6f9` | Latar Belakang Main Content Dashboard |

---

## 3. Tipografi (Typography)
- **Primary Font Family**: `'Nunito', 'Segoe UI', arial, sans-serif`
- **Heading Styles**:
  - `H1 / Dashboard Title`: 28px, Semi-Bold, `#34395e`
  - `H2 / Section Title`: 22px, Medium, `#34395e`
  - `H3 / Card Header`: 16px, Bold, `#6777ef`
- **Body Text**: 14px, Regular, `#6c757d`

---

## 4. Komponen Antarmuka (UI Components)

### 4.1. Stat Cards (Kartu Ringkasan Dasbor)
Kartu dengan ikon berwarna di sisi kiri untuk menampilkan total siswa, total petugas, total kelas, dan total transaksi SPP.

### 4.2. Tabel Data & Paginasi
Tabel responsif berbasis Bootstrap dengan garis pemisah (*bordered table*), badge status berwarna untuk role (`ADMIN` = Primary, `STAFF` = Warning, `STUDENT` = Info), dan aksi CRUD terpadu.

### 4.3. Form & Validation Display
Form input standar dengan indikator field wajib (*asterisk red*). Jika terjadi kesalahan validasi server, field terkait akan menampilkan class `is-invalid` dan pesan kesalahan di bawah input element.

---

## 5. Layout Wireframe Reference

```
+-----------------------------------------------------------------------+
|  LOGO  [Search...]                      [Profile Admin (Role: ADMIN)] |
+--------------+--------------------------------------------------------+
|  NAVIGATION  | DASHBOARD                                              |
|  - Dashboard | +-----------------+ +-----------------+ +--------------+ |
|  - Data Siswa| | Total Siswa: 120| | Total Kelas: 12 | | Total SPP    | |
|  - Data Kelas| +-----------------+ +-----------------+ +--------------+ |
|  - Data SPP  |                                                        |
|  - Logout    | DATA SISWA TABLE                                       |
|              | [ + Tambah Siswa ]                                      |
|              | +------+----------+---------------+------------+-----+ |
|              | | NISN | Nama     | Kelas         | Role       | Aksi| |
|              | +------+----------+---------------+------------+-----+ |
+--------------+--------------------------------------------------------+
```
