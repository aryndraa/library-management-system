# Library Management System (LMS) 📚

Sistem Manajemen Perpustakaan modern yang dibangun dengan **Laravel 12** dan **Filament v3**, dirancang untuk mengelola operasional perpustakaan secara efisien dengan sistem multi-role.

## 🌟 Overview

Proyek ini adalah platform manajemen perpustakaan yang mencakup pengelolaan buku, keanggotaan, peminjaman, denda, hingga reservasi fasilitas ruangan. Sistem ini memiliki panel terpisah untuk Admin dan Pustakawan (Librarian), serta antarmuka khusus untuk Anggota (Member).

### Fitur Utama:

- **Manajemen Inventaris Buku**: Katalog buku, kategori, dan status ketersediaan.
- **Sistem Peminjaman & Pengembalian**: Pelacakan otomatis tanggal jatuh tempo dan perhitungan denda.
- **Booking Ruangan**: Fasilitas bagi member untuk memesan ruang baca atau ruang diskusi.
- **Sistem Kunjungan**: Pencatatan kehadiran member di perpustakaan.
- **Laporan & Notifikasi**: Notifikasi denda dan laporan aktivitas perpustakaan.
- **QR Code Integration**: Untuk identitas buku atau member.

---

## 🛠️ Tech Stack

| Komponen              | Teknologi                      |
| --------------------- | ------------------------------ |
| **Backend Framework** | Laravel 12                     |
| **Admin Panel**       | Filament v3 (Livewire 3)       |
| **Database**          | MySQL / MariaDB                |
| **Frontend Styling**  | Tailwind CSS                   |
| **Asset Manager**     | Vite                           |
| **Media Handler**     | Spatie Laravel Media Library   |
| **PDF Engine**        | Barryvdh Laravel-DomPDF        |
| **QR Code**           | SimpleSoftwareIO Simple-QRcode |

---

## ⚙️ Cara Instalasi

Ikuti langkah-langkah di bawah ini untuk menjalankan proyek di lokal:

1. **Clone Repository**

    ```bash
    git clone https://github.com/username/library-management-system.git
    cd library-management-system
    ```

2. **Instalasi Dependency**

    ```bash
    composer install
    npm install
    ```

3. **Setup Environment**
   Salin `.env.example` menjadi `.env` dan sesuaikan konfigurasi database Anda.

    ```bash
    cp .env.example .env
    php artisan key:generate
    ```

4. **Migrasi Database & Seeding**

    ```bash
    php artisan migrate --seed
    ```

5. **Menjalankan Aplikasi**
   Buka terminal baru untuk menjalankan Vite dan server Laravel:
    ```bash
    npm run dev
    # Di terminal lain
    php artisan serve
    ```

---

## 👥 Peran Pengguna (Roles)

Sistem ini memiliki 3 peran utama dengan akses yang berbeda:

### 1. **Administrator (Admin)**

- **Akses**: `/admin`
- **Fungsi**: Memiliki kendali penuh atas sistem. Mengelola data perpustakaan, manajemen akun admin lainnya, serta memantau seluruh aktivitas sistem.

### 2. **Pustakawan (Librarian)**

- **Akses**: `/librarian`
- **Fungsi**: Bertanggung jawab atas operasional harian. Mengelola stok buku, memproses peminjaman dan pengembalian, mencatat kehadiran member, serta mengelola absensi dan shift kerja mereka sendiri.

### 3. **Anggota (Member)**

- **Akses**: `/member`
- **Fungsi**: Mencari dan melihat detail buku, memberikan like/komentar pada buku, melihat riwayat peminjaman, serta melakukan booking ruangan fasilitas perpustakaan.

---

## 📝 Catatan Tambahan

Sistem ini menggunakan **Single Page Application (SPA)** mode dari Filament untuk navigasi yang lebih cepat dan user experience yang lebih baik.
