# Development Roadmap

## Prinsip Eksekusi
- Kerjakan fondasi auth, role, dan master data lebih dulu.
- Kirim modul yang bernilai publik lebih cepat agar situs desa dapat online lebih awal.
- Tunda modul dengan workflow kompleks sampai fondasi data stabil.

## Sprint Plan
### Sprint 1
- Auth
- Role
- Master Desa

### Sprint 2
- Berita
- Pengumuman
- Agenda
- Galeri

### Sprint 3
- Potensi Desa
- UMKM
- BUMDes

### Sprint 4
- Penduduk
- KK
- RT/RW
- Dusun

### Sprint 5
- Surat Menyurat

### Sprint 6
- Pengaduan

### Sprint 7
- APBDes
- Dashboard

## Detail Per Sprint
| Sprint | Outcome | Dependensi |
| --- | --- | --- |
| 1 | Login, role, permission, profil desa, settings dasar | Laravel Fortify, roles |
| 2 | CMS publik berjalan | Sprint 1 |
| 3 | Data potensi ekonomi desa tampil publik | Sprint 2 |
| 4 | Basis data warga dan wilayah administratif stabil | Sprint 1 |
| 5 | Workflow surat end-to-end | Sprint 4 |
| 6 | Workflow pengaduan end-to-end | Sprint 1 |
| 7 | Transparansi anggaran dan dashboard ringkasan | Sprint 2, 4 |

## Milestone
- M1: Website publik live
- M2: Modul ekonomi desa live
- M3: Data penduduk siap operasional
- M4: Surat menyurat digital live
- M5: Pengaduan live
- M6: APBDes dan dashboard live

## Risiko Delivery
- Modul surat bergantung pada kualitas data warga.
- APBDes bergantung pada struktur kategori anggaran yang disepakati.
- API mobile sebaiknya distandardisasi saat modul inti sudah stabil.
