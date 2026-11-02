# Panduan Instalasi & Konfigurasi - Etalase Digital Stella

Ikuti langkah-langkah berikut untuk menjalankan project ini di komputer lokal (menggunakan XAMPP):

## 1. Kebutuhan Sistem
* PHP versi 8.0 atau yang lebih baru
* MySQL / MariaDB (via XAMPP/Laragon)
* Web Browser modern (Chrome, Edge, Firefox)

## 2. Langkah Instalasi
1. **Clone atau Download Project:**
   Simpan folder project `latihan-ukk-lv-3` ke dalam direktori server lokal (contoh: `C:/xampp/htdocs/etalase-digital/`).
2. **Konfigurasi Database:**
   * Buka **phpMyAdmin** melalui browser (`http://localhost/phpmyadmin`).
   * Buat database baru dengan nama: `db_etalase_digital`.
   * Import file database yang ada di root folder (`database_scheme.sql`) ke dalam database tersebut.
3. **Atur Koneksi Database:**
   * Buka file `config/kuis_db.php` (atau file koneksi database kamu).
   * Sesuaikan konfigurasi host, username, dan password jika diperlukan:
     ```php
     $host = 'localhost';
     $user = 'root';
     $pass = '';
     $db   = 'db_etalase_digital';
     ```
4. **Jalankan Aplikasi:**
   * Nyalakan Apache dan MySQL di XAMPP Control Panel.
   * Buka browser dan akses: `http://localhost/etalase-digital/`