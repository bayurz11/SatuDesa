# DDD Structure

## Tujuan
Dokumen ini menetapkan struktur Domain-Driven Design yang dipakai repo agar modul SatuDesa berkembang konsisten.

## Struktur Inti
```text
app/
├── Domains/
│   ├── User/
│   ├── Role/
│   ├── Permission/
│   ├── Village/
│   ├── Post/
│   ├── Potential/
│   ├── Citizen/
│   ├── LetterRequest/
│   └── Complaint/
├── Livewire/
│   ├── Admin/
│   ├── Public/
│   └── Citizen/
├── Services/
├── Actions/
├── Policies/
├── Enums/
└── DTOs/
```

## Konvensi Per Domain
Setiap domain minimal memiliki:

```text
app/Domains/<Domain>/
├── Models/
├── Actions/
├── DTOs/
├── Enums/
└── Policies/
```

## Mapping Modul ke Domain
### Authentication dan Authorization
- `User`
- `Role`
- `Permission`

### Master Desa
- `Village`
- `VillageProfile`
- `VillageOfficial`
- `Setting`

### Konten Publik
- `Post`
- `PostCategory`
- `PostTag`
- `Announcement`
- `Agenda`
- `Gallery`
- `Media`

### Potensi dan Ekonomi
- `Potential`
- `PotentialCategory`
- `Business`
- `BusinessCategory`
- `BusinessProduct`
- `BumdesUnit`
- `BumdesTransaction`

### APBDes
- `Budget`
- `BudgetCategory`
- `BudgetRealization`
- `BudgetYear`

### Kependudukan
- `Household`
- `Citizen`
- `Hamlet`
- `Rw`
- `Rt`

### Surat
- `LetterType`
- `LetterRequirement`
- `LetterRequest`
- `LetterRequestFile`
- `LetterApproval`
- `GeneratedLetter`

### Pengaduan
- `Complaint`
- `ComplaintCategory`
- `ComplaintComment`
- `ComplaintAttachment`

## Aturan Implementasi
- UI tidak menyimpan business logic utama; logic dipindah ke `Actions`.
- Status domain gunakan `Enums`.
- Payload form kompleks gunakan `DTOs`.
- Otorisasi utama gunakan `Policies`.
- Domain model tetap tipis; orkestrasi lintas entity diletakkan di `Actions` atau `Services`.

## Status Repo Saat Ini
- Struktur folder DDD dasar sudah disiapkan.
- Domain `User`, `Role`, dan `Permission` sudah memiliki model aktif.
- Domain lain masih berupa skeleton dan siap diisi bertahap sesuai roadmap modul.
