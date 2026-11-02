# Etalase Digital Siswa (Student Project Repository)

Aplikasi web berbasis PHP Native untuk memamerkan dan mengelola portofolio *project* karya siswa SMK. Dibangun sebagai persiapan Uji Kompetensi Keahlian (UKK) RPL dengan struktur kode yang bersih dan terorganisir.

## 🚀 Fitur Utama
- **Autentikasi & Multi-Role:** Pembagian hak akses antara **Admin/Guru** (moderasi project) dan **Siswa** (upload & kelola project).
- **CRUD Project:** Tambah, lihat, ubah, dan hapus data project lengkap dengan deskripsi dan tautan (GitHub/Demo).
- **Modal Card & Detail:** Tampilan card interaktif dengan modal untuk melihat detail informasi project.
- **Pencarian & Filter:** Fitur *search bar* untuk mencari project berdasarkan judul.

## 🛠️ Tech Stack
- **Backend:** PHP Native (PDO Prepared Statements)
- **Database:** MySQL / MariaDB
- **Frontend:** HTML5 dan CSS3

## 📦 Panduan Instalasi (Quick Start)
Ikuti langkah-langkah berikut untuk menjalankan project ini di komputer lokal (XAMPP/Laragon):

1. **Clone repository ini** atau download sebagai ZIP:
   ```bash
   git clone https://github.com/username/latihan-ukk-lv-3.git
   ```
2. Pindahkan folder project ke direktori web server lokal (`htdocs` untuk XAMPP atau `www` untuk Laragon).
3. Buat database baru di `phpMyAdmin` dengan nama:
   ```sql
   db_etalase_digital
   ```
4. Import file database (`database.sql` atau file `.sql` yang ada di folder `database/`) ke dalam database tersebut.
5. Sesuaikan konfigurasi koneksi database di file `config/database.php` jika diperlukan:
   ```php
   $host = 'localhost';
   $dbname = 'db_etalase_digital';
   $username = 'root';
   $password = '';
   ```
6. Jalankan aplikasi melalui browser:
   ```text
   http://localhost/latihan-ukk-lv-3
   ```

## 🔑 Akun Default (Credentials)
Gunakan akun berikut untuk menguji fitur berdasarkan *role*:

- **Super Admin**
  - Email: `superadmin@stella.sch.id`
  - Password: `password123`

- **Admin / Guru**
  - Email: `admin@stella.sch.id`
  - Password: `password123`

- **Siswa**
  - Username: `siswa@stella.sch.id`
  - Password: `password123`

## 📁 Struktur Folder
```text
latihan-ukk-lv-3/
│
├── admin/               # Halaman khusus manajemen admin/user
├── assets/              # File aset CSS (admin, auth, form, main, style)
├── auth/                # Halaman autentikasi (login, register, logout)
├── config/              # Konfigurasi koneksi database
├── docs/                # Dokumentasi dan folder screenshot project
├── middleware/          # Pengecekan sesi & hak akses (auth_check)
├── uploads/             # Folder penyimpanan gambar/thumbnail project
│
├── database_scheme.sql  # File skema database SQL
├── index.php            # Halaman utama / dashboard
├── project_edit.php     # Proses / form edit project
├── project_hapus.php    # Proses hapus project
├── project_tambah.php   # Proses / form tambah project
└── README.md            # Dokumentasi project
```

## 📝 Lisensi
Project ini dikembangkan untuk keperluan Uji Kompetensi Keahlian (UKK) Rekayasa Perangkat Lunak (RPL).