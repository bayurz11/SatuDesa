# Generator Commands

## Tujuan
Command ini dipakai untuk membuat file baru sesuai struktur DDD SatuDesa tanpa harus menulis path manual.

## Command Utama
```bash
php artisan satudesa:make {type} {name} [--domain=DomainName] [--area=AreaName]
```

## Tipe Yang Didukung
- `model`
- `action`
- `dto`
- `enum`
- `policy`
- `service`
- `livewire`

## Contoh Pemakaian

### Domain Model
```bash
php artisan satudesa:make model Citizen --domain=Citizen
```
Hasil:
```text
app/Domains/Citizen/Models/Citizen.php
```

### Domain Action
```bash
php artisan satudesa:make action CreateCitizen --domain=Citizen
```
Hasil:
```text
app/Domains/Citizen/Actions/CreateCitizen.php
```

### Domain DTO
```bash
php artisan satudesa:make dto CitizenFormData --domain=Citizen
```

### Root Service
```bash
php artisan satudesa:make service LetterNumberService
```
Hasil:
```text
app/Services/LetterNumberService.php
```

### Root Action
```bash
php artisan satudesa:make action SyncVillageStats
```
Hasil:
```text
app/Actions/SyncVillageStats.php
```

### Livewire Admin
```bash
php artisan satudesa:make livewire Letters/LetterTable --area=Admin
```
Hasil:
```text
app/Livewire/Admin/Letters/LetterTable.php
resources/views/livewire/admin/letters/letter-table.blade.php
```

### Livewire Citizen
```bash
php artisan satudesa:make livewire Complaints/ComplaintForm --area=Citizen
```

## Catatan
- Untuk `model`, `--domain` wajib diisi.
- Untuk `livewire`, `--area` opsional. Default: `Admin`.
- Nama boleh nested, misalnya `Letters/ApproveLetter`.
- Gunakan `--force` jika ingin overwrite file yang sudah ada.
