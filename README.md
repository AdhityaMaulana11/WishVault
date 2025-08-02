# 🌠 WishVault – Aplikasi Manajemen Impian dan Target Hidup

**WishVault** adalah aplikasi berbasis **PHP Native** yang dirancang untuk membantu pengguna menyusun, melacak, dan merealisasikan impian dan target hidup secara visual dan terorganisir. Aplikasi ini sangat cocok untuk pelajar, mahasiswa, profesional, maupun komunitas pengembangan diri.

---

## 🧩 Fitur Aplikasi

### 🔐 Autentikasi Pengguna
- Formulir login dan registrasi.
- Sistem logout.
- Perlindungan sesi menggunakan `$_SESSION`.

### 🎯 Manajemen Wish (Impian)
- Tambah, edit, dan hapus impian.
- Penambahan deskripsi, target waktu, kategori, dan status progres (%).
- Pengaturan wish sebagai **Publik** atau **Pribadi**.

### 🗂️ Manajemen Kategori
- Menambahkan dan mengelola kategori wish untuk klasifikasi yang lebih rapi.

### 🖼️ Galeri Impian
- Upload dan tampilkan gambar terkait setiap wish.
- Gambar disimpan di direktori `uploads/`.

### 💬 Komentar
- Wish yang diatur sebagai publik dapat dikomentari oleh pengguna lain.

### 🌈 Motivasi Harian
- Menampilkan kutipan motivasi secara acak untuk mendorong semangat pengguna.

---

## 🔁 Alur Navigasi Aplikasi

```mermaid
flowchart TD
    A[Beranda /index.php] --> B[Login /auth/login.php]
    A --> C[Registrasi /auth/register.php]
    B --> D[Dashboard /dashboard.php]
    D --> E[Wish Saya /wish/index.php]
    E --> F[Tambah/Edit Wish]
    D --> G[Galeri /gallery/index.php]
    D --> H[Wish Publik /wish/public_list.php]
    H --> I[Detail + Komentar]
    D --> J[Kategori /category/index.php]
    D --> K[Logout /auth/logout.php]
