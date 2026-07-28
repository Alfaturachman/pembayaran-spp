# Security & Audit Documentation - Aplikasi Pembayaran SPP

Dokumen ini memuat laporan audit keamanan, perbaikan bug kritis, pencegahan kerentanan, serta hasil evaluasi *Ponytail Audit* pada sistem **Pembayaran SPP**.

---

## 1. Perbaikan Bug Kritis (Critical Exception Fixes)

### 1.1. Method Undefined `Collection::findOrFail()` Bug
- **Lokasi Terpengaruh**: `Admin\ClassController.php`, `Admin\StaffController.php`.
- **Masalah**: Penggunaan kode `$item = Model::all()->findOrFail($id)`. Method `all()` mengembalikan Eloquent Collection yang tidak memiliki method `findOrFail()`, menyebabkan runtime crash `BadMethodCallException`.
- **Perbaikan**: Mengganti pemanggilan menjadi `Model::findOrFail($id)`.

### 1.2. Class Import Error (`Faker\Provider\ar_SA\Payment`)
- **Lokasi Terpengaruh**: `Admin\SppController.php`, `Staff\SppController.php`, `Student\SppController.php`.
- **Masalah**: Penggunaan import salah `use Faker\Provider\ar_SA\Payment;` alih-alih `use App\Models\Payments;`. Saat menjalankan method `destroy($id)`, aplikasi crash akibat melempar exception `Class Payment not found`.
- **Perbaikan**: Mengimpor model Eloquent `App\Models\Payments` dan menjalankan `Payments::findOrFail($id)->delete()`.

### 1.3. Infinite Redirect Loop (HTTP 302 Loop)
- **Lokasi Terpengaruh**: `app/Providers/RouteServiceProvider.php` & `routes/web.php`.
- **Masalah**: `RouteServiceProvider::HOME` diset ke `'/'`, padahal route `'/'` dilindungi oleh `middleware(['guest'])`. Pengguna yang sudah terautentikasi dan diarahkan ke `/` ditangkap oleh `RedirectIfAuthenticated` lalu diarahkan kembali ke `HOME` (`/`), menyebabkan loop tak terbatas.
- **Perbaikan**: Mengubah `RouteServiceProvider::HOME` menjadi `'/auth'`, yang secara cerdas mengarahkan pengguna ke dasbor masing-masing berdasarkan peran (Admin, Staff, Student).

---

## 2. Peningkatan Keamanan (Security Hardening)

### 2.1. IDOR (Insecure Direct Object Reference) Protection
- **Lokasi**: [Student/SppController.php](file:///d:/laragon/www/pembayaran-spp/app/Http/Controllers/Student/SppController.php)
- **Implementasi**:
  Setiap request pembacaan, pembaruan, atau penghapusan data pembayaran oleh akun Siswa dipatok (*scoped*) menggunakan identitas pengguna yang sedang terautentikasi:
  ```php
  $user = Auth::user();
  $items = Payments::where('id_user', $user->id)
      ->orWhere(function ($query) use ($user) {
          if ($user->nisn) {
              $query->where('nisn', $user->nisn);
          }
      })->get();
  ```
  Ini mencegah siswa mengintip atau memanipulasi riwayat SPP milik siswa lain melalui pengubahan parameter ID pada URL.

### 2.2. Validasi Input & Proteksi Mass Assignment
- **Lokasi**: Seluruh Controller (`ClassController`, `StaffController`, `StudentController`, `SppController`).
- **Implementasi**:
  Semua method `store` dan `update` mewajibkan aturan validasi eksplisit melalui `$request->validate([...])` sebelum data dikirim ke layer Eloquent, menggantikan pola tidak aman `$request->all()`.

### 2.3. Safe Password Hashing Mutator
- **Lokasi**: [User.php](file:///d:/laragon/www/pembayaran-spp/app/Models/User.php)
- **Implementasi**:
  Mutator `setPasswordAttribute` memverifikasi string password terlebih dahulu. Jika password dikirim kosong (saat update profil siswa/staff tanpa ganti password), password lama tidak akan tertimpa hash string kosong. Jika password baru diisi, sistem memeriksa header `$2y$` agar tidak terjadi *double hashing*.

---

## 3. Hasil Ponytail Audit (Code Over-Engineering Audit)

| Tag | Objek Eliminasi | Tindakan / Solusi |
| :--- | :--- | :--- |
| `delete` | Duplicate Models `Users.php` & `Staffs.php` | Konsolidasi entitas pengguna ke `User.php` (menjadikan kelas lama sebagai alias turunan) |
| `delete` | Orphan Views (`admin.blade.php`, `staff.blade.php`, `student.blade.php`) | Dihapus dari `resources/views/` |
| `shrink` | Multiple Middlewares (`IsAdmin`, `IsStaff`, `IsStudent`) | Disederhanakan menggunakan verifikasi role terpusat |
| `shrink` | Form Input HTML Typos | Memperbaiki typo atribut HTML `name=" nisn"` pada view pembentukan data |

**Hasil Akhir**: Codebase bebas dari over-engineering, bersih, konsisten, dan aman (*Lean & Production Ready*).
