# Quality Assurance & Testing Specification - Aplikasi Pembayaran SPP

## 1. Strategi Pengujian (Testing Strategy)
Aplikasi **Pembayaran SPP** diuji menggunakan kombinasi **Automated Testing** (PHPUnit 9.x) dan **Manual Verification (UAT)** untuk memastikan keandalan fungsionalitas, validasi form, otorisasi role, dan proteksi keamanan.

---

## 2. Rangkaian Pengujian Otomatis (Automated PHPUnit Test Suite)

Pengujian otomatis dapat dijalankan melalui terminal dengan perintah:
```bash
vendor/bin/phpunit
```

### Hasil Ringkasan Eksekusi Terakhir:
```text
PHPUnit 9.6.22 by Sebastian Bergmann and contributors.

....................................                              36 / 36 (100%)

Time: 00:32.038, Memory: 38.00 MB

OK (36 tests, 67 assertions)
```

---

## 3. Matriks Skenario Uji (Test Cases)

| Test ID | Modul / Feature | Skenario Pengujian | Ekspektasi Hasil | Status |
| :--- | :--- | :--- | :--- | :--- |
| **TC-AUTH-01** | Authentication | User login dengan email & password valid | Berhasil login & redirect ke `/auth` | **PASS** |
| **TC-AUTH-02** | Authentication | User login dengan password salah | Gagal login & tampilkan validation error | **PASS** |
| **TC-AUTH-03** | Auth Redirection | Login user dengan role `ADMIN` | Diarahkan ke `/admin/dashboard` | **PASS** |
| **TC-AUTH-04** | Auth Redirection | Login user dengan role `STAFF` | Diarahkan ke `/staff/dashboard` | **PASS** |
| **TC-AUTH-05** | Auth Redirection | Login user dengan role `STUDENT` | Diarahkan ke `/student/dashboard` | **PASS** |
| **TC-RBAC-01** | Authorization | Non-admin mencoba akses `/admin/dashboard` | Diblokir oleh middleware & redirect ke `/` | **PASS** |
| **TC-RBAC-02** | Authorization | Non-staff mencoba akses `/staff/dashboard` | Diblokir oleh middleware & redirect ke `/` | **PASS** |
| **TC-SEC-01** | Security (IDOR) | Siswa A mencoba baca data pembayaran Siswa B | Data Siswa B tidak muncul (scoped to Auth User) | **PASS** |
| **TC-SEC-02** | Security (CSRF) | Submit form tanpa token `@csrf` | HTTP 419 Page Expired | **PASS** |
| **TC-CRUD-01** | Master Kelas | Admin membuat data kelas baru | Data tersimpan di DB & muncul di tabel | **PASS** |
| **TC-CRUD-02** | Master Siswa | Admin membuat data siswa baru | Akun user role `STUDENT` terbuat | **PASS** |
| **TC-CRUD-03** | Master Petugas | Admin membuat data petugas baru | Akun user role `STAFF` terbuat | **PASS** |
| **TC-SPP-01** | Transaksi SPP | Staff menginput pembayaran SPP | Transaksi tersimpan di tabel `payments` | **PASS** |

---

## 4. Perbaikan Bug Kritis yang Terverifikasi Lewat Test Suite
1. **Perbaikan `Collection::findOrFail()`**: Pengujian controller master data tidak lagi menghasilkan `BadMethodCallException`.
2. **Perbaikan Import `Faker\Provider\ar_SA\Payment`**: Penghapusan transaksi SPP berjalan sukses tanpa `Class Payment not found`.
3. **Perbaikan Infinite Redirect Loop (`/auth`)**: Pengujian pengalihan role berjalan mulus tanpa HTTP 302 loop.
