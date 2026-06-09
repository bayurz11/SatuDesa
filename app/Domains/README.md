# Domain Structure

Folder `app/Domains` menjadi pusat bounded context aplikasi.

Setiap domain mengikuti pola dasar berikut:

```text
app/Domains/<Domain>/
├── Models/
├── Actions/
├── DTOs/
├── Enums/
└── Policies/
```

Konvensi pemakaian:

- `Models` untuk Eloquent model dan relasi domain.
- `Actions` untuk use case spesifik, misalnya `SubmitLetterRequest`, `PublishPost`, `AssignComplaint`.
- `DTOs` untuk payload input/output antar layer.
- `Enums` untuk status dan konstanta domain.
- `Policies` untuk otorisasi domain-level.

Domain yang sudah disiapkan:

- `User`, `Role`, `Permission`
- `Village`, `VillageProfile`, `VillageOfficial`
- `Post`, `PostCategory`, `PostTag`, `Announcement`, `Agenda`, `Gallery`, `Media`
- `Potential`, `PotentialCategory`
- `Business`, `BusinessCategory`, `BusinessProduct`
- `BumdesUnit`, `BumdesTransaction`
- `Budget`, `BudgetCategory`, `BudgetRealization`, `BudgetYear`
- `Household`, `Citizen`, `Hamlet`, `Rw`, `Rt`
- `LetterType`, `LetterRequirement`, `LetterRequest`, `LetterRequestFile`, `LetterApproval`, `GeneratedLetter`
- `Complaint`, `ComplaintCategory`, `ComplaintComment`, `ComplaintAttachment`
- `Setting`, `Audit`

Area presentasi dipisah dari domain:

- `app/Livewire/Admin`
- `app/Livewire/Public`
- `app/Livewire/Citizen`

Area aplikasi umum:

- `app/Services`
- `app/Actions`
- `app/Policies`
- `app/Enums`
- `app/DTOs`
