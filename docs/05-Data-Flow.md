# Data Flow

## Tujuan
Dokumen ini menjelaskan perpindahan data antar aktor, aplikasi, database, dan output publik.

## Data Flow Berita
```mermaid
flowchart TD
    A[Admin Form] --> B[Validation]
    B --> C[Database]
    C --> D[Publish]
    D --> E[Public Website]
```

### Entitas Terkait
- `posts`
- `post_categories`
- `post_tags`
- `media`

### Validasi Inti
- Judul wajib.
- Slug unik.
- Status harus valid.
- Thumbnail dan media sesuai tipe file.

## Data Flow Surat
```mermaid
flowchart TD
    A[Form Warga] --> B[Database]
    B --> C[Verifikasi]
    C --> D[Approval]
    D --> E[Generate PDF]
    E --> F[Arsip]
```

### Entitas Terkait
- `letter_types`
- `letter_requirements`
- `letter_requests`
- `letter_request_files`
- `letter_approvals`
- `generated_letters`

### Data Lifecycle
- Draft pengajuan dibuat warga.
- Dokumen dan metadata tersimpan di database dan storage.
- Setiap tahap approval menambah jejak histori.
- PDF final menjadi arsip resmi yang dapat diakses sesuai izin.

## Data Flow Pengaduan
```mermaid
flowchart TD
    A[Form Warga] --> B[Validation]
    B --> C[Database]
    C --> D[Verifikasi Admin]
    D --> E[Assign Petugas]
    E --> F[Update Status]
    F --> G[Riwayat dan Arsip]
```

## Data Flow APBDes
```mermaid
flowchart TD
    A[Input Admin] --> B[Validation]
    B --> C[Database]
    C --> D[Agregasi Ringkasan]
    D --> E[Halaman Publik]
```

## Prinsip Desain Data
- Setiap perubahan status harus auditable.
- Lampiran dipisahkan dari tabel utama agar lifecycle file jelas.
- Status publik dan status internal dapat dibedakan jika dibutuhkan.
- Data publik hanya mengambil record berstatus publish atau approved.
