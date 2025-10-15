# 🌾 SatuDesa Core – Portal Desa Digital Modern

**SatuDesa** adalah boilerplate Laravel modern berbasis **Domain-Driven Design (DDD)** yang dirancang khusus untuk pengembangan **portal desa digital**.  
Menampilkan sistem **manajemen pengguna, role, dan permission dinamis**, dengan antarmuka elegan berbasis **Tailwind CSS**, **Livewire**, dan **Alpine.js**.

---

## 🚀 Fitur Utama

### 🏗️ Arsitektur Inti

-   Struktur **Domain-Driven Design (DDD)** modular (User, Role, Permission, Profil, Desa, UMKM, dll.)
-   Pemisahan logika bisnis melalui **Actions** dan **DataTransferObjects**
-   Kode bersih, mudah dipelihara, dan mengikuti standar Laravel modern

### 👥 Manajemen Pengguna

-   CRUD lengkap untuk pengguna (Tambah, Edit, Hapus, Aktif/Nonaktif)
-   Profil pengguna & pengaturan akun pribadi
-   Sistem autentikasi (Login, Register, Lupa Password)
-   Verifikasi email
-   Status pengguna (aktif/nonaktif)

### 🔐 Role & Permission Dinamis

-   **Role Management:** Admin Desa, Operator, Kontributor, dll.
-   **Permission Management:** kontrol granular per modul (misal: `profil.view`, `umkm.edit`, `pengumuman.delete`)
-   **Role Assignment:** satu user dapat memiliki banyak role
-   **Permission Assignment:** atur izin langsung ke role
-   **Middleware & Blade Directive:** `@permission`, `@role`, `@can` untuk kontrol tampilan & akses

### 🏘️ Modul Desa Siap Pakai

| Modul                      | Deskripsi                           | Contoh Permission                    |
| -------------------------- | ----------------------------------- | ------------------------------------ |
| 🏡 **Profil Desa**         | Data umum & identitas desa          | `profil.view`, `profil.edit`         |
| 📜 **Sejarah Desa**        | Asal-usul dan perkembangan desa     | `sejarah.view`, `sejarah.edit`       |
| 🎯 **Visi & Misi**         | Tujuan & arah pembangunan desa      | `visi_misi.view`, `visi_misi.edit`   |
| 🧩 **Struktur Organisasi** | Hierarki pemerintahan desa          | `struktur.view`, `struktur.edit`     |
| 🌾 **Potensi Desa**        | Produk unggulan & sumber daya lokal | `potensi.view`, `potensi.edit`       |
| 🛍️ **UMKM**                | Direktori usaha masyarakat          | `umkm.view`, `umkm.edit`             |
| 📢 **Pengumuman**          | Informasi resmi desa                | `pengumuman.view`, `pengumuman.edit` |

### 💻 Frontend Modern

-   **Tailwind CSS 3+** untuk desain bersih dan responsif
-   **Livewire 3+** untuk komponen interaktif tanpa reload
-   **Alpine.js** untuk interaksi ringan
-   **Blade Components** reusable (form, modal, tombol, tabel)

---

## 🏗️ Struktur Proyek

app/
├── Domains/
│ ├── User/
│ ├── Role/
│ ├── Permission/
│ ├── ProfilDesa/
│ ├── SejarahDesa/
│ ├── VisiMisi/
│ ├── StrukturOrganisasi/
│ ├── PotensiDesa/
│ └── Umkm/
├── Http/
│ ├── Controllers/
│ ├── Middleware/
│ └── Livewire/
└── View/
└── Components/

---

## ⚙️ Teknologi

| Layer            | Teknologi                               |
| ---------------- | --------------------------------------- |
| **Backend**      | Laravel 11+                             |
| **Frontend**     | Tailwind CSS 3+, Livewire 3+, Alpine.js |
| **Database**     | MySQL / SQLite                          |
| **Auth**         | Laravel Sanctum                         |
| **Testing**      | PHPUnit, Laravel Dusk                   |
| **Code Quality** | Laravel Pint, PHPStan                   |

---

## 🧩 Quick Start

# Clone repository

git clone https://github.com/username/satudesa-core.git
cd satudesa-core

# Install dependencies

composer install
npm install

# Copy environment file

cp .env.example .env
php artisan key:generate

# Setup database

php artisan migrate --seed

# Build frontend assets

npm run build

# Jalankan server

php artisan serve
Buka di browser:
👉 http://127.0.0.1:8000

🔑 Akun Default (Seeder)
Role Email Password
🧑‍💼 Admin Desa admin@satudesa.test
password
🧑‍💻 Operator operator@satudesa.test
password
👥 Viewer viewer@satudesa.test
password

## ⚙️ Konfigurasi .env

# Database

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=satudesa
DB_USERNAME=root
DB_PASSWORD=

# Mail (untuk reset password)

MAIL_MAILER=smtp
MAIL_HOST=smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=null
MAIL_PASSWORD=null

## 🎨 Kustomisasi

# 🖌️ Tampilan

Edit tema di tailwind.config.js

Sesuaikan komponen di resources/views/components/

Gunakan layout utama di resources/views/layouts/app2.blade.php

# 🧠 Logika Bisnis

Tambah permission di database/seeders/PermissionSeeder.php

Tambah role di database/seeders/RoleSeeder.php

Tambah domain baru di app/Domains/

## s🏆 Checklist Fitur

✅ CRUD Pengguna

✅ Role & Permission Dinamis

✅ Middleware Otorisasi

✅ Blade Directive @permission

✅ UI Responsif (Tailwind)

✅ Livewire Interaktif

✅ Autentikasi & Verifikasi Email

✅ Reset Password

✅ Seeder Default

✅ Struktur DDD Bersih

✅ Siap Produksi
