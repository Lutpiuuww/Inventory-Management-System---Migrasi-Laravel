# Sistem Manajemen Inventaris (Inventory Laravel)

Aplikasi web sistem manajemen inventaris barang berbasis **Laravel 12** dan **Tailwind CSS**. Proyek ini dibuat sebagai hasil **migrasi dan modernisasi dari proyek sebelumnya (P4)** guna meningkatkan keandalan arsitektur kode, keamanan, keteraturan basis data relasional, serta pengalaman antarmuka pengguna (UI/UX).

---

## 📌 Latar Belakang & Tujuan Migrasi

Proyek ini merupakan tahap migrasi dari **Project P4** sebelumnya:
1. **Modernisasi Framework**: Beralih ke arsitektur modern Laravel (MVC) dengan pemanfaatan Eloquent ORM, migrasi skema terstruktur, seeder, dan middleware.
2. **Keamanan & Autentikasi**: Implementasi sistem autentikasi bawaan dengan hashing sandi (Bcrypt) dan kontrol hak akses berbasis peran (*Role-Based Access Control* - Admin & Staff).
3. **Peningkatan Tampilan (UI/UX)**: Menggunakan Tailwind CSS dan komponen Blade yang responsif, bersih, dan informatif.
4. **Relasi Basis Data yang Lebih Kuat**: Menghubungkan relasi antarentitas seperti produk, kategori, pemasok (*many-to-many*), serta pencatatan riwayat perpindahan stok (*stock movements*).

---

## 🚀 Fitur Utama

- **Autentikasi & Otorisasi**:
  - Login dan Logout berbasis sesi.
  - Pembagian hak akses: **Admin** (akses penuh) dan **Staff** (akses operasional produk & stok).
- **Manajemen Produk (CRUD)**:
  - Tambah, lihat, ubah, dan hapus data produk.
  - Pengunggahan dan pengelolaan gambar produk.
  - Relasi dengan kategori dan pemasok (*suppliers*).
- **Manajemen Kategori & Pemasok (Admin Only)**:
  - Pengelolaan kategori barang untuk pengelompokan yang rapi.
  - Pengelolaan data pemasok (*supplier contact & information*).
- **Riwayat Pergerakan Stok (*Stock Movements*)**:
  - Pencatatan barang masuk (*in*) dan keluar (*out*).
  - Pembaruan stok secara otomatis serta histori pencatatan transaksi barang.

---

## 🛠️ Prasyarat Sistem

Sebelum menjalankan proyek ini, pastikan sistem Anda telah terpasang:
- **PHP** >= 8.2
- **Composer**
- **Node.js** & **NPM**
- **MySQL / MariaDB** (atau SQLite)

---

## ⚙️ Panduan Instalasi & Menjalankan Proyek

Ikuti langkah-langkah berikut untuk menjalankan proyek di lingkungan lokal:

### 1. Klon Repositori
```bash
git clone <url-repositori-anda>
cd inventory-laravel
```

### 2. Pasang Dependensi PHP & Node
```bash
composer install
npm install
```

### 3. Konfigurasi Environment (`.env`)
Salin file `.env.example` menjadi `.env`:
```bash
cp .env.example .env
```
> *(Di Windows PowerShell, gunakan `copy .env.example .env`)*

Buka file `.env` dan sesuaikan koneksi database Anda, misalnya:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=inventory_laravel
DB_USERNAME=root
DB_PASSWORD=
```

### 4. Buat Application Key
```bash
php artisan key:generate
```

### 5. Jalankan Migrasi & Seeder Database
Jalankan migrasi untuk membuat tabel beserta data dummy awal:
```bash
php artisan migrate --seed
```

### 6. Tautkan Storage (Storage Link)
Buat symlink agar gambar produk yang diunggah dapat diakses publik:
```bash
php artisan storage:link
```

### 7. Jalankan Server Pengembangan
Jalankan server Laravel dan compiler aset frontend:
```bash
# Terminal 1: Menjalankan Laravel
php artisan serve

# Terminal 2: Menjalankan Vite (Tailwind CSS)
npm run dev
```

Akses aplikasi di browser melalui: `http://127.0.0.1:8000`

---

## 🔐 Akun Default (Seeder)

Setelah menjalankan `php artisan migrate --seed`, Anda dapat masuk menggunakan akun default berikut:

| Peran (*Role*) | Username | Password | Hak Akses |
|---|---|---|---|
| **Admin** | `admin` | `password` | Akses penuh (Produk, Kategori, Supplier, Stock Movement) |
| **Staff** | `staff` | `password` | Akses operasional (Produk & Stock Movement) |

---

## 📂 Struktur Proyek

```plaintext
inventory-laravel/
├── app/
│   ├── Http/
│   │   ├── Controllers/     # Controller (Auth, Product, Category, Supplier, StockMovement)
│   │   └── Middleware/      # AdminMiddleware untuk proteksi hak akses
│   └── Models/              # Model Eloquent (User, Product, Category, Supplier, StockMovement)
├── database/
│   ├── migrations/          # File migrasi struktur tabel basis data
│   └── seeders/             # DatabaseSeeder & data awal
├── public/                  # Entry point publik & aset statis
├── resources/
│   └── views/               # Tampilan UI Blade (Dashboard, Form, Tabel)
├── routes/
│   └── web.php              # Definisi endpoint & rute aplikasi
└── screenshot/              # Dokumentasi visual aplikasi
```

---

## 📄 Lisensi

Proyek ini dikembangkan untuk kebutuhan akademik/pembelajaran dan bersifat *open-source* di bawah lisensi [MIT](LICENSE).
