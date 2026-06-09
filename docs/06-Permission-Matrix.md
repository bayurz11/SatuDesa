# Permission Matrix

## Matriks Utama
| Modul | Super Admin | Admin Desa | Operator | Warga |
| --- | --- | --- | --- | --- |
| Berita | CRUD | CRUD | Create/Edit | View |
| Pengumuman | CRUD | CRUD | Create/Edit | View |
| APBDes | CRUD | CRUD | View | View |
| Surat | CRUD | CRUD | Process | Create/View |
| Pengaduan | CRUD | CRUD | Process | Create/View |

## Matriks Rinci yang Disarankan
| Modul | Super Admin | Admin Desa | Operator | Sekretaris Desa | Kepala Desa | Warga |
| --- | --- | --- | --- | --- | --- | --- |
| Users & Roles | CRUD | View/Create/Edit terbatas | View | View | View | - |
| Master Desa | CRUD | CRUD | View/Edit terbatas | View | View | View publik |
| Berita | CRUD | CRUD | Create/Edit | Review | View | View |
| Pengumuman | CRUD | CRUD | Create/Edit | Review | View | View |
| Agenda | CRUD | CRUD | Create/Edit | Review | View | View |
| Galeri | CRUD | CRUD | Create/Edit | View | View | View |
| Potensi Desa | CRUD | CRUD | Create/Edit | View | View | View |
| UMKM | CRUD | CRUD | Create/Edit | View | View | View |
| BUMDes | CRUD | CRUD | Create/Edit | View | View | View |
| APBDes | CRUD | CRUD | View | Review | Approve | View |
| Penduduk & KK | CRUD | CRUD | CRUD | View | View | View terbatas |
| Surat | CRUD | CRUD | Verifikasi/Proses | Review | Approve | Create/View |
| Pengaduan | CRUD | CRUD | Verifikasi/Proses | View | View | Create/View |
| Settings | CRUD | CRUD terbatas | View | View | View | - |

## Catatan Implementasi
- Gunakan permission granular per aksi: `view`, `create`, `update`, `delete`, `process`, `review`, `approve`, `publish`.
- Role `Sekretaris Desa` dan `Kepala Desa` sebaiknya dipisahkan untuk workflow surat.
- Endpoint API dan halaman dashboard harus menggunakan policy atau permission yang sama agar konsisten.
