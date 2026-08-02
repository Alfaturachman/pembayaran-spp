# Business Requirement Document (BRD) - Aplikasi Pembayaran SPP

## 1. Latar Belakang & Masalah
Di banyak lembaga pendidikan, pencatatan dan pengelolaan transaksi Sumbangan Pembinaan Pendidikan (SPP) masih dilakukan secara manual menggunakan buku besar atau lembar kerja terpisah. Hal ini menimbulkan beberapa kendala:
- **Risiko Kesalahan Pencatatan**: Transaksi harian berisiko terlewat, salah catat, atau terduplikasi.
- **Kurangnya Transparansi**: Siswa dan wali murid kesulitan memantau histori pembayaran dan sisa tagihan secara real-time.
- **Lambatnya Rekapitulasi**: Pimpinan sekolah dan bendahara memerlukan waktu lama untuk menyusun laporan penerapan dan tunggakan SPP.
- **Keamanan Data**: Dokumen fisik rawan rusak atau hilang, serta kurang terproteksi dari akses pihak tidak berwenang.

---

## 2. Tujuan Bisnis & Solusi
Aplikasi **Pembayaran SPP** dibangun sebagai sistem informasi berbasis web yang terpusat dan aman untuk memdigitalisasi seluruh proses pengelolaan SPP sekolah. 

Tujuan utama sistem ini meliputi:
- **Otomatisasi Manajemen SPP**: Menggantikan pencatatan manual dengan sistem database terintegrasi.
- **Transparansi Mandiri (Self-Service)**: Menyediakan portal khusus siswa untuk mengecek riwayat pembayaran secara mandiri kapan saja.
- **Efisiensi Operasional Staff**: Memudahkan kasir/petugas sekolah dalam mencatat transaksi SPP harian dengan cepat dan akurat.
- **Keamanan & Akuntabilitas Data**: Menjamin keamanan data pembayaran dengan otentikasi multi-role dan proteksi keamanan tingkat lanjut.

---

## 3. Target Pengguna & Pemangku Kepentingan (Stakeholders)

| Stakeholder / Role | Deskripsi & Peran Utama | Ekspektasi Utama |
| :--- | :--- | :--- |
| **Manajemen / Sekolah** | Pimpinan sekolah & bendahara utama. | Laporan keuangan SPP yang akurat, terstruktur, dan akuntabel. |
| **Administrator System** | Pengelola sistem IT sekolah. | Akses penuh pengelolaan data master (Siswa, Kelas, Petugas, Tarif SPP). |
| **Staff / Kasir SPP** | Petugas operasional keuangan sekolah. | Kemudahan dan kecepatan input transaksi pembayaran harian. |
| **Siswa & Wali Murid** | Penerima layanan pendidikan. | Akses cepat dan transparan ke histori pembayaran SPP pribadi. |

---

## 4. Ruang Lingkup Proyek (Project Scope)

### In-Scope (Fitur Masuk Skala):
- Otentikasi pengguna berbasis peran (*Multi-Role Auth*: Admin, Staff, Student).
- Pengelolaan Data Master (CRUD Data Kelas, Data Siswa, Data Petugas, Tarif SPP).
- Transaksi Entri Pembayaran SPP oleh Admin & Staff.
- Portal Portal Mandiri Siswa untuk melihat histori pembayaran personal (dengan proteksi IDOR).
- Dashboard statistik ringkasan operasional.

### Out-of-Scope (Tidak Masuk Skala Saat Ini):
- Integrasi Payment Gateway otomatis (Midtrans/Xendit) — transaksi saat ini dicatat oleh petugas/kasir.
- Cetak struk/nota menggunakan thermal printer fisik secara langsung.
- Pengiriman notifikasi tagihan otomatis via WhatsApp/SMS Gateway.

---

## 5. Indikator Keberhasilan (KPI & Success Metrics)
1. **Reduksi Waktu Transaksi**: Pemrosesan entri pembayaran SPP per siswa di bawah 30 detik.
2. **Akurasi Data 100%**: Tidak ada selisih antara pencatatan transaksi dengan tarif resmi SPP per tahun ajaran.
3. **Penyajian Data Real-Time**: Histori pembayaran langsung dapat diakses siswa sesaat setelah diinput oleh petugas.
4. **Keamanan Maksimal**: Zero critical security vulnerabilities (terproteksi dari IDOR, CSRF, dan SQL Injection).
