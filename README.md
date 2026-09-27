# Aplikasi Manajemen Produk
 
Aplikasi web CRUD (Create, Read, Update, Delete) sederhana yang dibangun menggunakan PHP native dan MySQL (PDO). Proyek ini berfokus pada implementasi keamanan dasar, validasi input, dan antarmuka responsif.

## 🌟 Fitur Utama (Sesuai Spesifikasi Tugas)

- **Create:** Tambah produk dengan validasi input (nama unik & minimal 3 karakter, harga > 0, stok >= 0) dan pola Post-Redirect-Get (PRG) untuk mencegah duplikasi data saat refresh.
- **Read:** Menampilkan daftar produk menggunakan CSS Box Model dan grid responsif (Flexbox). Data dirender dengan aman (mencegah XSS) menggunakan `htmlspecialchars`.
- **Update:** Edit data produk berdasarkan ID dengan validasi form yang sama seperti fitur Create.
- **Delete:** Hapus data produk secara aman menggunakan metode POST dan validasi Token CSRF.
- **Bonus Feature (Search):** Pencarian produk berdasarkan nama atau kategori menggunakan metode GET dan parameter PDO yang aman.

## 📂 Struktur Direktori

Product-manager/
├── config/
│   └── db.php                # Koneksi PDO ke MySQL
├── database/
│   └── store_db.sql          # File dump struktur & data tabel
├── public/
│   ├── assets/
│   │   └── style.css         # Styling UI responsif (Flexbox)
│   ├── index.php             # Halaman utama (Read & Search)
│   ├── create.php            # Logika tambah produk
│   ├── edit.php              # Logika edit produk
│   └── delete.php            # Logika hapus produk beserta validasi CSRF
└── README.md

## 🚀 Cara Menjalankan Aplikasi

1. **Persiapan Sistem:**
   - Pastikan XAMPP (atau web server lokal lainnya) sudah terinstal.
   - Jalankan modul **Apache** dan **MySQL** pada XAMPP Control Panel.

2. **Instalasi Proyek:**
   - Unduh atau *clone* repositori ini.
   - Pindahkan folder `Product-manager` ke dalam direktori *document root* web server Anda (contoh: `C:\xampp\htdocs\`).

3. **Pengaturan Database:**
   - Buka browser dan akses http://localhost/phpmyadmin
   - Buat database baru dengan nama yang persis sama, yaitu: `store_db`
   - Buka database `store_db` yang baru dibuat, klik tab **Import** (Impor).
   - Pilih file `store_db.sql` yang ada di dalam folder `database/` pada proyek ini, lalu klik **Go** (Kirim).

4. **Akses Aplikasi:**
   - Buka browser dan masukkan URL berikut:
     http://localhost/Product-manager/public/

## 🛡️ Aspek Keamanan yang Diimplementasikan
- **SQL Injection Prevention:** Semua query CRUD menggunakan `PDO Prepared Statements`.
- **XSS Prevention:** Output ke HTML disaring menggunakan fungsi `htmlspecialchars(..., ENT_QUOTES, "UTF-8")`.
- **CSRF Protection:** Operasi destruktif (Delete) membutuhkan token sesi yang divalidasi.
- **Data Duplication Prevention:** Menggunakan pola PRG (Post-Redirect-Get) pada saat Insert dan Update.