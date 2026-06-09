# UI UX Guideline

## Brand Direction
Antarmuka SatuDesa harus terasa modern, tegas, ramah warga, dan cocok untuk konteks layanan publik desa. Gaya visual perlu bersih dan informatif, bukan korporat generik.

## Color System
### Primary
- `#2563EB`
- Gradient utama dashboard: `#2563EB` -> `#1D4ED8` -> `#3730A3`

### Secondary
- `#0F172A`
- Slate pendukung: `#64748B`

### Accent
- `#10B981`
- Highlight aksen: `#F59E0B`

### Support
- Background: `#F8FAFC`
- Background subtle: `#EFF6FF`
- Surface: `#FFFFFF`
- Border: `#E2E8F0`
- Primary soft: `#DBEAFE`
- Accent soft: `#D1FAE5`
- Success: `#10B981`
- Danger: `#DC2626`
- Info: `#3B82F6`

### Usage Rules
- Semua halaman admin mengikuti basis warna dashboard: biru untuk aksi utama, slate untuk struktur, emerald untuk status positif, amber untuk highlight.
- Hindari kembali ke primary hijau lama agar dashboard, topbar, sidebar, chart, badge, dan CTA terasa satu sistem.
- Purple hanya dipakai bila benar-benar butuh layer kedalaman visual. Untuk gradient utama, gunakan kombinasi blue-indigo yang sudah dipakai dashboard.

## Typography
### Heading
- `Oxanium`

### Body
- `Inter`

### Usage
- Heading utama memakai `Oxanium` untuk karakter modern dan tegas.
- Konten panjang, tabel, dan form memakai `Inter` untuk keterbacaan tinggi.

## Layout Guideline
### Dashboard Layout
- Sidebar tetap di desktop.
- Topbar memuat search, profil, notifikasi, dan quick actions.
- Dashboard utama memuat stats, charts, recent activity, dan tabel ringkas.

### Public Layout
- Hero section kuat dengan identitas desa.
- CTA utama diarahkan ke `Surat Menyurat` dan `Pengaduan`.
- Section berita, agenda, APBDes, dan potensi dibuat modular.

## Component Guideline
- Gunakan card dengan radius sedang dan shadow halus.
- Gunakan badge status berwarna konsisten untuk draft, review, publish, approved, rejected, selesai.
- Form panjang dibagi per section agar tidak terasa berat.
- Tabel admin wajib mendukung search, filter, sorting, dan empty state.

## Interaction Guideline
- Tampilkan stepper untuk alur surat dan pengaduan.
- Gunakan konfirmasi sebelum approval, publish, atau delete.
- Berikan feedback instan setelah submit, upload, atau perubahan status.

## Accessibility
- Kontras warna minimal memenuhi standar dasar WCAG.
- Semua tombol penting memiliki label jelas, bukan ikon saja.
- Form error harus muncul dekat field dan mudah dibaca.
- Navigasi keyboard untuk dashboard inti perlu dipertahankan.

## Responsive Rules
- Public site mobile-first.
- Sidebar dashboard berubah jadi drawer pada layar kecil.
- Tabel kompleks menyediakan mode horizontal scroll atau kartu ringkas di mobile.

## Visual Priority
1. Layanan warga
2. Informasi publik terbaru
3. Transparansi APBDes
4. Data operasional admin
