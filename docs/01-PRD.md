# Product Requirements Document

## Ringkasan
SatuDesa adalah platform digital desa berbasis Laravel untuk mengelola website publik desa, layanan administrasi warga, pengaduan, data kependudukan, APBDes, UMKM, dan BUMDes dalam satu sistem terpadu.

## Vision
Membangun sistem informasi desa yang cepat, transparan, mudah dioperasikan perangkat desa, dan mudah diakses warga dari web maupun kanal mobile di tahap berikutnya.

## Goals
- Menyediakan portal publik desa yang informatif dan selalu terbarui.
- Mempercepat proses surat menyurat dari pengajuan sampai dokumen jadi.
- Memusatkan data penduduk, KK, RT, RW, dan dusun dalam satu sumber data.
- Menyediakan kanal pengaduan yang dapat dilacak statusnya.
- Membuka transparansi APBDes dan potensi desa ke publik.
- Menyediakan fondasi API untuk aplikasi mobile.

## Non-Goals
- Integrasi penuh dengan layanan tanda tangan digital pihak ketiga pada fase awal.
- Integrasi pembayaran online pada fase awal.
- Migrasi otomatis dari sistem lama tanpa proses validasi manual.

## Target Users
- Warga
- Operator desa
- Sekretaris desa
- Kepala desa
- Admin desa
- Super admin

## User Roles
| Role | Deskripsi | Kebutuhan Utama |
| --- | --- | --- |
| Super Admin | Pengelola sistem lintas desa | Pengaturan global, role, permission, audit |
| Admin Desa | Pengelola utama aplikasi desa | Kelola konten, master data, pengguna, APBDes |
| Operator | Pelaksana operasional harian | Verifikasi data, proses surat, proses pengaduan |
| Sekretaris Desa | Reviewer administratif | Review surat, validasi proses |
| Kepala Desa | Otorisasi final | Approval surat dan kebijakan tertentu |
| Warga | Pengguna layanan publik | Ajukan surat, buat pengaduan, lihat informasi |

## Problem Statement
- Informasi desa sering tersebar dan tidak terkelola konsisten.
- Layanan surat menyurat manual memakan waktu dan sulit dilacak.
- Data penduduk dan keluarga sering tidak sinkron antar arsip.
- Pengaduan masyarakat tidak memiliki SLA dan histori yang jelas.
- Transparansi APBDes, UMKM, BUMDes, dan potensi desa masih rendah.

## Success Metrics
- Waktu rata-rata proses surat turun di bawah 2 hari kerja.
- Minimal 80% pengajuan surat masuk melalui sistem.
- Minimal 90% pengaduan memiliki status yang terbarui.
- Halaman publik utama memiliki konten aktif mingguan.
- APBDes dan realisasi tahunan tersedia dan dapat diakses publik.

## Modules
- Authentication dan authorization
- Website publik desa
- Berita, pengumuman, agenda, galeri
- Potensi desa
- UMKM
- BUMDes
- APBDes
- Penduduk, KK, dusun, RT, RW
- Surat menyurat
- Pengaduan
- Pengaturan desa dan pengguna
- API untuk mobile

## Functional Requirements
### Authentication
- Login aman untuk admin dan petugas.
- Registrasi atau onboarding warga sesuai kebijakan desa.
- Role-based access control untuk seluruh modul.

### Public Website
- Menampilkan profil desa, pemerintahan, berita, pengumuman, agenda, potensi, UMKM, BUMDes, APBDes, galeri, pengaduan, surat, dan kontak.
- SEO-friendly slug untuk konten publik.
- Media management untuk gambar, banner, dan lampiran.

### Content Management
- Draft, review, publish untuk berita dan pengumuman.
- Scheduling agenda.
- Kategori dan tag konten.

### Population Management
- Kelola data KK, penduduk, dusun, RT, dan RW.
- Pencarian cepat dan filter administratif.
- Validasi NIK dan relasi kepala keluarga.

### Letter Service
- Warga mengajukan surat berdasarkan tipe surat.
- Upload persyaratan per jenis surat.
- Workflow verifikasi, review, approval, generate PDF, arsip.
- Pelacakan status pengajuan oleh warga.

### Complaint Service
- Warga membuat pengaduan dengan kategori dan lampiran.
- Admin memverifikasi dan assign petugas.
- Petugas memperbarui progres hingga selesai.
- Riwayat komentar dan lampiran tersimpan.

### APBDes
- Kelola tahun anggaran, kategori, item anggaran, dan realisasi.
- Publikasi ringkasan dan detail transparansi publik.

### Village Economy
- Kelola data UMKM, produk, kategori.
- Kelola unit usaha BUMDes dan transaksi ringkas.

### Administration
- Pengaturan profil desa, pejabat desa, logo, kontak.
- Kelola users, roles, permissions.
- Audit dasar untuk aktivitas penting.

## Non-Functional Requirements
- Responsive untuk desktop dan mobile.
- Akses cepat pada koneksi internet terbatas.
- Dokumen PDF konsisten dan mudah dicetak.
- Struktur aplikasi modular dan mudah dikembangkan.
- Logging, queue, cache, dan backup siap untuk produksi.

## Assumptions
- Satu instalasi melayani satu desa terlebih dahulu.
- Persetujuan surat dilakukan bertingkat oleh operator, sekretaris desa, dan kepala desa.
- Mobile app akan mengonsumsi API yang disiapkan dari awal.

## Risks
- Kualitas data awal penduduk dapat rendah.
- Perubahan proses administratif antar desa dapat menuntut konfigurasi tambahan.
- Approval multi-level dapat menambah kompleksitas notifikasi dan SLA.

## Release Strategy
- Fase 1 fokus pada fondasi auth, role, profil desa, dan website publik inti.
- Fase 2 fokus pada konten, potensi, UMKM, dan BUMDes.
- Fase 3 fokus pada data penduduk dan layanan surat.
- Fase 4 fokus pada pengaduan, APBDes, dashboard, dan API mobile.

## High-Level Roadmap
| Sprint | Fokus |
| --- | --- |
| Sprint 1 | Auth, role, master desa |
| Sprint 2 | Berita, pengumuman, agenda, galeri |
| Sprint 3 | Potensi desa, UMKM, BUMDes |
| Sprint 4 | Penduduk, KK, RT, RW, dusun |
| Sprint 5 | Surat menyurat |
| Sprint 6 | Pengaduan |
| Sprint 7 | APBDes, dashboard, hardening API |
