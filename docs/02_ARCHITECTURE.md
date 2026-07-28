# System Architecture Document - Aplikasi Pembayaran SPP

## 1. Ringkasan Arsitektur
Aplikasi **Pembayaran SPP** dibangun menggunakan pola arsitektur **MVC (Model-View-Controller)** yang disediakan oleh framework **Laravel 8.x**.

```
               +----------------------------------+
               |            HTTP Request          |
               +----------------------------------+
                                |
                                v
               +----------------------------------+
               |       Routing & Middleware       |
               | (web.php, IsAdmin, IsStaff, etc.)|
               +----------------------------------+
                                |
                                v
               +----------------------------------+
               |           Controllers            |
               |   (Admin, Staff, Student Namespaces)
               +----------------------------------+
                     /          |          \
                    v           v           v
             +----------+  +----------+  +----------+
             |  Models  |  | Validation| |  Views   |
             | (Eloquent)| | (Validate)| | (Blade)  |
             +----------+  +----------+  +----------+
                  |                         |
                  v                         v
             +----------+            +--------------+
             | Database |            | Browser Response
             | (MySQL)  |            +--------------+
             +----------+
```

---

## 2. Struktur Direktori Proyek

- **`app/Http/Controllers/`**: Controller aplikasi yang dipisah berdasarkan ruang lingkup peran:
  - `Admin/`: DashboardController, ClassController, StaffController, StudentController, SppController.
  - `Staff/`: DashboardController, SppController.
  - `Student/`: DashboardController, SppController.
  - `Auth/`: AuthenticatedSessionController, RegisteredUserController, dll.
- **`app/Http/Middleware/`**: Middleware pengaman request (`Authenticate`, `IsAdmin`, `IsStaff`, `IsStudent`, `EnsureUserRole`, `RedirectIfAuthenticated`).
- **`app/Models/`**: Model Eloquent (`User`, `Classes`, `Payments`, `Spp`).
- **`database/migrations/`**: Skema tabel basis data.
- **`routes/web.php`**: Definisi routing web utama.
- **`resources/views/`**: Blade template views yang terbagi atas layout admin, staff, student, dan halaman publik.

---

## 3. Alur Otentikasi & Otorisasi (Authentication & Authorization Flow)

1. **Login Flow**:
   - Pengguna mengakses `/login` -> memasukkan kredensial (email/username & password).
   - `AuthenticatedSessionController@store` mengautentikasi kredensial.
   - Aplikasi mengarahkan pengguna ke `/auth`.
   - Route `/auth` membaca atribut `$user->roles` dan mengarahkan secara dinamis:
     - Role `ADMIN` -> `/admin/dashboard`
     - Role `STAFF` -> `/staff/dashboard`
     - Role `STUDENT` -> `/student/dashboard`

2. **Middleware Guard Flow**:
   - Setiap route group dilindungi oleh middleware kombinasi: `['auth', 'admin']`, `['auth', 'staff']`, atau `['auth', 'student']`.
   - Jika pengguna non-admin mencoba mengakses `/admin/dashboard`, middleware akan memblokir request dan mengembalikan response redirect ke halaman utama `/`.

---

## 4. Alur Manajemen Data & Validasi

```mermaid
sequenceDiagram
    autonumber
    actor User as Pengguna (Admin/Staff)
    participant Route as Web Route
    participant MW as Middleware (Auth & Role)
    participant Ctrl as Controller
    participant Val as Request Validator
    participant Model as Eloquent Model
    participant DB as MySQL Database

    User->>Route: HTTP POST /admin/data-siswa
    Route->>MW: Verifikasi Session & Role ADMIN
    alt Role Valid
        MW->>Ctrl: Teruskan ke StudentController@store
        Ctrl->>Val: Jalankan $request->validate()
        alt Validasi Sukses
            Val->>Ctrl: Data Terverifikasi
            Ctrl->>Model: User::create($data)
            Model->>DB: INSERT INTO users ...
            DB-->>Model: Success (ID Baru)
            Ctrl-->>User: Redirect dengan Status Sukses
        else Validasi Gagal
            Val-->>User: Redirect Back dengan Validation Errors
        end
    else Role Tidak Valid
        MW-->>User: Redirect to '/'
    end
```
