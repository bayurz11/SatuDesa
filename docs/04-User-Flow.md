# User Flow

## Tujuan
Dokumen ini merangkum alur interaksi pengguna untuk modul prioritas.

## Flow Berita
```mermaid
flowchart TD
    A[Admin] --> B[Buat Berita]
    B --> C[Draft]
    C --> D[Review]
    D --> E[Publish]
    E --> F[Website Publik]
```

### Catatan
- Draft dapat diedit berulang.
- Tahap review dapat dilakukan Admin Desa atau editor yang diberi izin.
- Publish memicu update listing dan detail berita di website publik.

## Flow APBDes
```mermaid
flowchart TD
    A[Admin] --> B[Input Anggaran]
    B --> C[Input Realisasi]
    C --> D[Publish]
    D --> E[Publik]
```

### Catatan
- Anggaran diinput per tahun dan kategori.
- Realisasi dapat diperbarui berkala sebelum publish final.
- Data publik menampilkan ringkasan dan detail sesuai kebijakan transparansi.

## Flow Surat Menyurat
```mermaid
flowchart TD
    A[Warga] --> B[Pilih Jenis Surat]
    B --> C[Isi Form]
    C --> D[Upload Persyaratan]
    D --> E[Tracking Status]
    E --> F[Unduh Hasil]
```

## Flow Pengaduan
```mermaid
flowchart TD
    A[Warga] --> B[Buat Pengaduan]
    B --> C[Upload Lampiran]
    C --> D[Lihat Status]
    D --> E[Terima Tanggapan]
    E --> F[Selesai]
```

## Flow Admin Dashboard
```mermaid
flowchart TD
    A[Login] --> B[Dashboard]
    B --> C{Pilih Modul}
    C --> D[Konten]
    C --> E[Data Penduduk]
    C --> F[Surat]
    C --> G[Pengaduan]
    C --> H[APBDes]
    C --> I[Settings]
```
