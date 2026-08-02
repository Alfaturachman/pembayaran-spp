# Routing & Endpoint Documentation - Aplikasi Pembayaran SPP

Dokumen ini mencatat seluruh daftar route dan endpoint HTTP yang tersedia pada aplikasi **Pembayaran SPP**.

---

## 1. Route Publik & Autentikasi

| Method | URI Path | Route Name | Controller Action | Middleware | Deskripsi |
| :--- | :--- | :--- | :--- | :--- | :--- |
| `GET` | `/` | `index` | Closure | `guest` | Halaman landing page utama |
| `GET` | `/auth` | - | Closure | `auth` | Redirection hub berdasarkan role pengguna |
| `GET` | `/tentang-kami` | - | Closure | - | Halaman profil tentang sekolah |
| `GET` | `/faq` | - | Closure | - | Halaman FAQ |
| `GET` | `/kontak` | - | Closure | - | Halaman kontak sekolah |
| `GET` | `/login` | `login` | `Auth\AuthenticatedSessionController@create` | `guest` | Form login pengguna |
| `POST` | `/login` | - | `Auth\AuthenticatedSessionController@store` | `guest` | Proses autentikasi login |
| `POST` | `/logout` | `logout` | `Auth\AuthenticatedSessionController@destroy` | `auth` | Logout & destroy sesi |

---

## 2. Route Admin (`/admin`)

Seluruh route di bawah ini diprefiks dengan `/admin` dan dilindungi oleh middleware `['auth', 'admin']`.

| Method | URI Path | Route Name | Controller Action | Deskripsi |
| :--- | :--- | :--- | :--- | :--- |
| `GET` | `/admin/dashboard` | `admin` | `Admin\DashboardController@index` | Dasbor utama Admin |
| `GET` | `/admin/data-siswa` | `data-siswa.index` | `Admin\StudentController@index` | Daftar seluruh siswa |
| `GET` | `/admin/data-siswa/create` | `data-siswa.create` | `Admin\StudentController@create` | Form tambah siswa |
| `POST` | `/admin/data-siswa` | `data-siswa.store` | `Admin\StudentController@store` | Simpan data siswa baru |
| `GET` | `/admin/data-siswa/{id}` | `data-siswa.show` | `Admin\StudentController@show` | Detail data siswa |
| `GET` | `/admin/data-siswa/{id}/edit`| `data-siswa.edit` | `Admin\StudentController@edit` | Form edit data siswa |
| `PUT/PATCH`| `/admin/data-siswa/{id}` | `data-siswa.update` | `Admin\StudentController@update` | Update data siswa |
| `DELETE` | `/admin/data-siswa/{id}` | `data-siswa.destroy` | `Admin\StudentController@destroy` | Hapus data siswa |
| `GET` | `/admin/data-petugas` | `data-petugas.index` | `Admin\StaffController@index` | Daftar seluruh petugas/staff |
| `GET` | `/admin/data-petugas/create`| `data-petugas.create`| `Admin\StaffController@create` | Form tambah petugas |
| `POST` | `/admin/data-petugas` | `data-petugas.store` | `Admin\StaffController@store` | Simpan data petugas baru |
| `GET` | `/admin/data-petugas/{id}` | `data-petugas.show` | `Admin\StaffController@show` | Detail petugas |
| `GET` | `/admin/data-petugas/{id}/edit`| `data-petugas.edit`| `Admin\StaffController@edit` | Form edit petugas |
| `PUT/PATCH`| `/admin/data-petugas/{id}`| `data-petugas.update`| `Admin\StaffController@update` | Update data petugas |
| `DELETE` | `/admin/data-petugas/{id}`| `data-petugas.destroy`| `Admin\StaffController@destroy` | Hapus data petugas |
| `GET` | `/admin/data-kelas` | `data-kelas.index` | `Admin\ClassController@index` | Daftar kelas |
| `GET` | `/admin/data-kelas/create` | `data-kelas.create` | `Admin\ClassController@create` | Form tambah kelas |
| `POST` | `/admin/data-kelas` | `data-kelas.store` | `Admin\ClassController@store` | Simpan kelas baru |
| `GET` | `/admin/data-kelas/{id}` | `data-kelas.show` | `Admin\ClassController@show` | Detail kelas |
| `GET` | `/admin/data-kelas/{id}/edit`| `data-kelas.edit` | `Admin\ClassController@edit` | Form edit kelas |
| `PUT/PATCH`| `/admin/data-kelas/{id}` | `data-kelas.update` | `Admin\ClassController@update` | Update kelas |
| `DELETE` | `/admin/data-kelas/{id}` | `data-kelas.destroy` | `Admin\ClassController@destroy` | Hapus kelas |
| `GET` | `/admin/data-spp` | `data-spp.index` | `Admin\SppController@index` | Daftar transaksi SPP |
| `GET` | `/admin/data-spp/create` | `data-spp.create` | `Admin\SppController@create` | Form tambah transaksi SPP |
| `POST` | `/admin/data-spp` | `data-spp.store` | `Admin\SppController@store` | Simpan transaksi SPP |
| `DELETE` | `/admin/data-spp/{id}` | `data-spp.destroy` | `Admin\SppController@destroy` | Hapus transaksi SPP |

---

## 3. Route Staff (`/staff`)

Diprefiks dengan `/staff` dan dilindungi oleh middleware `['auth', 'staff']`.

| Method | URI Path | Route Name | Controller Action | Deskripsi |
| :--- | :--- | :--- | :--- | :--- |
| `GET` | `/staff/dashboard` | `staff` | `Staff\DashboardController@index` | Dasbor Staff/Petugas |
| `GET` | `/staff/data-spp-siswa` | `data-spp-siswa.index` | `Staff\SppController@index` | Daftar entri SPP siswa |
| `GET` | `/staff/data-spp-siswa/create`| `data-spp-siswa.create`| `Staff\SppController@create` | Form input SPP siswa |
| `POST` | `/staff/data-spp-siswa` | `data-spp-siswa.store` | `Staff\SppController@store` | Simpan transaksi SPP |
| `DELETE` | `/staff/data-spp-siswa/{id}`| `data-spp-siswa.destroy`| `Staff\SppController@destroy` | Hapus transaksi SPP |

---

## 4. Route Student (`/student`)

Diprefiks dengan `/student` dan dilindungi oleh middleware `['auth', 'student']`.

| Method | URI Path | Route Name | Controller Action | Deskripsi |
| :--- | :--- | :--- | :--- | :--- |
| `GET` | `/student/dashboard` | `student` | `Student\DashboardController@index` | Dasbor personal Siswa |
| `GET` | `/student/data-log-spp` | `data-log-spp.index` | `Student\SppController@index` | Histori pembayaran SPP siswa |
| `GET` | `/student/data-log-spp/create`| `data-log-spp.create`| `Student\SppController@create` | Form entri mandiri SPP |
| `POST` | `/student/data-log-spp` | `data-log-spp.store` | `Student\SppController@store` | Simpan log entri SPP siswa |
