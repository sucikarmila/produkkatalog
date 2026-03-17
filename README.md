
# 📦 Product Showcase System (PRODUK) - Laravel 11

[![Laravel Version](https://img.shields.io/badge/Laravel-11.x-red.svg)](https://laravel.com)
[![License](https://img.shields.io/badge/License-MIT-blue.svg)](LICENSE)
[![User-Level](https://img.shields.io/badge/Role-Admin%20%26%20User-orange.svg)](#)

Solusi manajemen aset visual produk berbasis web yang tangguh. Dirancang khusus untuk **Admin** dalam mengelola katalog produk secara sistematis, serta memberikan ruang interaksi bagi **User** untuk memberikan apresiasi dan feedback.

---

## ⚡ Fitur Unggulan

### 🛡️ Enterprise-Grade Authentication
* **Secure Auth**: Sistem login dan registrasi dengan enkripsi Bcrypt.
* **Role-Based Access**: Pembagian tugas yang jelas antara pengelola konten (Admin) dan penikmat konten (User).
* **Unified Profile**: Manajemen identitas digital pengguna yang ringkas.

### 🖼️ Advance Product Management
* **Dynamic Albums**: Pengelompokan produk berdasarkan kategori atau kampanye.
* **Optimized Uploads**: Engine unggah foto otomatis yang mendukung JPG, PNG, hingga GIF (Max 2MB).
* **Instant Management**: Fitur CRUD (Create, Read, Update, Delete) yang responsif dan cepat.

### 🤝 Social Engagement Engine
* **Interaction System**: Like produk favorit dan sistem komentar bertingkat.
* **Analytical Stats**: Visualisasi jumlah apresiasi dan diskusi secara real-time di setiap halaman produk.

---

## 🏛️ Arsitektur Database

Aplikasi ini menggunakan skema relasi data yang dioptimalkan untuk performa:

```mermaid
graph LR
    U[Users] --- A[Albums]
    U --- F[Fotos]
    A --- F
    F --- K[Komentar_Fotos]
    F --- L[Like_Fotos]
    U --- K
    U --- L
````

### 📋 Kamus Data (Master Tables)

| Entity | Primary Key | Key Attributes |
| :--- | :--- | :--- |
| **Users** | `id` | `username`, `email`, `name` |
| **Albums** | `AlbumID` | `NamaAlbum`, `UserID`, `TanggalDibuat` |
| **Fotos** | `FotoID` | `JudulFoto`, `LokasiFile`, `AlbumID` |
| **Komentar** | `KomentarID` | `parent_id`, `IsiKomentar`, `UserID` |
| **Likes** | `LikeID` | `FotoID`, `UserID`, `TanggalLike` |

-----

## 🛠️ Langkah Instalasi

Pastikan environment Anda memenuhi syarat (PHP \>= 8.2 & MySQL).

1.  **Clone & Enter**
    ```bash
    git clone [https://github.com/sucikarmila/galeri.git](https://github.com/sucikarmila/galeri.git)
    cd galeri
    ```
2.  **Dependencies & Asset Building**
    ```bash
    composer install
    npm install && npm run build
    ```
3.  **Environment Setup**
    ```bash
    cp .env.example .env
    php artisan key:generate
    ```
4.  **Database Provisioning**
    Konfigurasi `.env` (DB\_DATABASE=galeri), lalu jalankan:
    ```bash
    php artisan migrate
    php artisan storage:link
    ```
5.  **Launch**
    ```bash
    php artisan serve
    ```

-----

## 🔧 Debugging & Troubleshooting

Jika Anda menemukan kendala teknis, silakan merujuk pada panduan debug berikut:

  * **Error 404 pada Gambar Produk**:
    Pastikan *symbolic link* sudah terhubung dengan benar. Jalankan `php artisan storage:link`.
  * **Database Connection Refused**:
    Cek kembali file `.env`, pastikan `DB_PORT`, `DB_USERNAME`, dan `DB_PASSWORD` sesuai dengan konfigurasi database lokal Anda.
  * **Vite Manifest Not Found**:
    Jika tampilan CSS/JS berantakan, pastikan Anda sudah menjalankan `npm run build` atau gunakan `npm run dev` saat masa pengembangan.
  * **Clear Cache & Optimization**:
    Jika perubahan kode tidak muncul, jalankan perintah pembersihan massal:
    ```bash
    php artisan optimize:clear
    ```

-----

## 📊 Matriks Hak Akses

| Kapabilitas Sistem | Manager (Admin) | Member (User) |
| :--- | :---: | :---: |
| Akses Dashboard & Profil | ✅ | ✅ |
| Publishing Produk & Album | ✅ | ❌ |
| Orchestration (Edit/Hapus) | ✅ | ❌ |
| Social Engagement (Like/Comment) | ✅ | ✅ |

-----

## 📸 Photo Documentation

Seluruh tampilan antarmuka (UI), hasil pengujian fitur, dan dokumentasi lainnya telah diorganisir di dalam repository.

👉 **[Lihat Dokumentasi Visual di Folder HASIL](https://github.com/sucikarmila/produkkatalog/tree/main/HASIL)**

-----

