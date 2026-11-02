# Dokumentasi Skema Database

Aplikasi **Etalase Digital Siswa** menggunakan database MySQL dengan struktur tabel utama sebagai berikut:

## 1. Tabel `users`
Digunakan untuk menyimpan data akun pengguna (Admin dan Siswa).
* `id` (INT, Primary Key, Auto Increment)
* `nama` (VARCHAR) - Nama lengkap pengguna
* `email` (VARCHAR) - Email unik untuk login
* `password` (VARCHAR, 255) - Password ter-hash menggunakan `password_hash()`
* `role` (ENUM: 'super_admin', 'admin', 'siswa') DEFAULT 'siswa' - Hak akses pengguna

## 2. Tabel `projects` (Karya Siswa)
Digunakan untuk menyimpan informasi portofolio/project yang diunggah siswa.
* `id` (INT, Primary Key, Auto Increment) - ID unik untuk tiap project
* `user_id` (INT, Foreign Key) - ID pemilik project (relasi ke `users.id` dengan `ON DELETE CASCADE`)
* `nama_project` (VARCHAR, 150) - Nama atau judul karya/project
* `deskripsi` (TEXT) - Penjelasan detail mengenai project
* `gambar` (VARCHAR, 255) - Nama file gambar/thumbnail yang tersimpan di server
* `link_project` (VARCHAR, 255) - Tautan eksternal (GitHub / Live Demo)
* `created_at` (TIMESTAMP) - Waktu pencatatan saat project diunggah (Default: `CURRENT_TIMESTAMP`)

---

## 🔑 Akun Default (Credentials)
Gunakan akun berikut untuk menguji aplikasi berdasarkan perannya:

* **Super Admin:**
  * Email: superadmin@stella.sch.id
  * Password: `password123`
* **Admin:**
  * Email: admin@stella.sch.id
  * Password: `password123`
* **Siswa (Kontributor):**
  * Email: siswa@stella.sch.id
  * Password: `password123`