# Database Schema

## Prioritas Implementasi
### Phase 1
- `users`
- `roles`
- `permissions`
- `villages`
- `village_profiles`

### Phase 2
- `posts`
- `post_categories`
- `media`

### Phase 3
- `potentials`
- `potential_categories`

### Phase 4
- `households`
- `citizens`
- `hamlets`
- `rws`
- `rts`

### Phase 5
- `letter_types`
- `letter_requests`
- `generated_letters`

### Phase 6
- `complaints`
- `complaint_comments`

## Tabel Inti dan Kolom Minimum
### users
| Kolom | Tipe | Catatan |
| --- | --- | --- |
| id | bigint | PK |
| name | string | Nama lengkap |
| email | string | Unik |
| nik | string nullable | Untuk warga |
| phone | string nullable | Kontak |
| password | string | Hash |
| status | string | active, inactive |
| village_id | bigint nullable | Scope desa |
| created_at | timestamp |  |
| updated_at | timestamp |  |

### villages
| Kolom | Tipe | Catatan |
| --- | --- | --- |
| id | bigint | PK |
| code | string | Kode desa |
| name | string | Nama desa |
| district | string | Kecamatan |
| regency | string | Kabupaten |
| province | string | Provinsi |
| postal_code | string nullable | Kode pos |
| created_at | timestamp |  |
| updated_at | timestamp |  |

### village_profiles
| Kolom | Tipe | Catatan |
| --- | --- | --- |
| id | bigint | PK |
| village_id | bigint | FK |
| description | text nullable | Profil singkat |
| vision | text nullable | Visi desa |
| mission | text nullable | Misi desa |
| address | text nullable | Alamat kantor |
| phone | string nullable | Kontak |
| email | string nullable | Email resmi |
| website | string nullable | Domain |
| logo_path | string nullable | Media |
| created_at | timestamp |  |
| updated_at | timestamp |  |

### posts
| Kolom | Tipe | Catatan |
| --- | --- | --- |
| id | bigint | PK |
| village_id | bigint | FK |
| category_id | bigint | FK |
| author_id | bigint | FK users |
| title | string |  |
| slug | string | Unik |
| excerpt | text nullable | Ringkasan |
| content | longText | Isi |
| status | string | draft, review, published |
| published_at | timestamp nullable |  |
| created_at | timestamp |  |
| updated_at | timestamp |  |

### households
| Kolom | Tipe | Catatan |
| --- | --- | --- |
| id | bigint | PK |
| village_id | bigint | FK |
| no_kk | string | Unik |
| head_citizen_id | bigint nullable | FK citizens |
| hamlet_id | bigint | FK |
| rw_id | bigint | FK |
| rt_id | bigint | FK |
| address | text |  |
| created_at | timestamp |  |
| updated_at | timestamp |  |

### citizens
| Kolom | Tipe | Catatan |
| --- | --- | --- |
| id | bigint | PK |
| household_id | bigint nullable | FK |
| nik | string | Unik |
| full_name | string |  |
| gender | string |  |
| birth_place | string nullable |  |
| birth_date | date nullable |  |
| religion | string nullable |  |
| marital_status | string nullable |  |
| occupation | string nullable |  |
| education | string nullable |  |
| address | text nullable |  |
| status | string | active, moved, deceased |
| created_at | timestamp |  |
| updated_at | timestamp |  |

### letter_types
| Kolom | Tipe | Catatan |
| --- | --- | --- |
| id | bigint | PK |
| village_id | bigint | FK |
| name | string | Nama surat |
| slug | string | Unik |
| code | string | Kode surat |
| template_path | string nullable | Template PDF |
| is_active | boolean | Status |
| created_at | timestamp |  |
| updated_at | timestamp |  |

### letter_requests
| Kolom | Tipe | Catatan |
| --- | --- | --- |
| id | bigint | PK |
| village_id | bigint | FK |
| letter_type_id | bigint | FK |
| applicant_user_id | bigint | FK users |
| citizen_id | bigint nullable | FK citizens |
| request_number | string | Unik |
| form_payload | json | Data form dinamis |
| status | string | submitted, verified, reviewed, approved, rejected, completed |
| submitted_at | timestamp |  |
| approved_at | timestamp nullable |  |
| created_at | timestamp |  |
| updated_at | timestamp |  |

### complaints
| Kolom | Tipe | Catatan |
| --- | --- | --- |
| id | bigint | PK |
| village_id | bigint | FK |
| category_id | bigint nullable | FK |
| citizen_user_id | bigint | FK users |
| assigned_to | bigint nullable | FK users |
| ticket_number | string | Unik |
| title | string |  |
| description | longText |  |
| status | string | submitted, verified, assigned, in_progress, resolved, rejected |
| priority | string nullable | low, medium, high |
| submitted_at | timestamp |  |
| resolved_at | timestamp nullable |  |
| created_at | timestamp |  |
| updated_at | timestamp |  |

## Konvensi Umum
- Semua tabel transaksional memiliki `created_at` dan `updated_at`.
- Gunakan `softDeletes` untuk data sensitif yang tidak boleh hilang.
- Gunakan `json` hanya untuk data fleksibel seperti payload form surat.
- Seluruh tabel domain desa memiliki `village_id` untuk kesiapan multi-tenant ringan.
