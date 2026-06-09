# API Specification

## Tujuan
Spesifikasi awal API untuk persiapan aplikasi mobile dan integrasi frontend lain.

## Prinsip
- Gunakan prefix `/api`.
- Gunakan autentikasi token untuk client mobile.
- Versioning disarankan dengan `/api/v1` saat implementasi final.
- Response JSON konsisten dengan `data`, `meta`, dan `message` jika perlu.

## Endpoint Scope
### Authentication
- `/api/auth/*`

### News
- `/api/news/*`

### Announcements
- `/api/announcements/*`

### Potentials
- `/api/potentials/*`

### Complaints
- `/api/complaints/*`

### Letters
- `/api/letters/*`

### Citizens
- `/api/citizens/*`

## Endpoint Draft
### Auth
| Method | Endpoint | Keterangan |
| --- | --- | --- |
| POST | `/api/v1/auth/login` | Login mobile |
| POST | `/api/v1/auth/logout` | Logout |
| GET | `/api/v1/auth/me` | Profil user aktif |

### News
| Method | Endpoint | Keterangan |
| --- | --- | --- |
| GET | `/api/v1/news` | List berita publish |
| GET | `/api/v1/news/{slug}` | Detail berita |

### Announcements
| Method | Endpoint | Keterangan |
| --- | --- | --- |
| GET | `/api/v1/announcements` | List pengumuman |
| GET | `/api/v1/announcements/{id}` | Detail pengumuman |

### Potentials
| Method | Endpoint | Keterangan |
| --- | --- | --- |
| GET | `/api/v1/potentials` | List potensi desa |
| GET | `/api/v1/potentials/{slug}` | Detail potensi |

### Complaints
| Method | Endpoint | Keterangan |
| --- | --- | --- |
| GET | `/api/v1/complaints` | Daftar pengaduan milik warga |
| POST | `/api/v1/complaints` | Buat pengaduan |
| GET | `/api/v1/complaints/{id}` | Detail pengaduan |
| POST | `/api/v1/complaints/{id}/comments` | Tambah komentar |

### Letters
| Method | Endpoint | Keterangan |
| --- | --- | --- |
| GET | `/api/v1/letters/types` | List jenis surat |
| GET | `/api/v1/letters/requests` | Riwayat pengajuan |
| POST | `/api/v1/letters/requests` | Ajukan surat |
| GET | `/api/v1/letters/requests/{id}` | Detail pengajuan |
| GET | `/api/v1/letters/requests/{id}/download` | Unduh PDF final |

### Citizens
| Method | Endpoint | Keterangan |
| --- | --- | --- |
| GET | `/api/v1/citizens/profile` | Profil warga login |
| GET | `/api/v1/citizens/household` | Data KK |

## Format Response
```json
{
  "data": {},
  "meta": {
    "request_id": "uuid"
  },
  "message": "OK"
}
```

## Status Code
- `200` sukses baca data
- `201` berhasil membuat data
- `401` belum login
- `403` tidak punya akses
- `422` validasi gagal
- `500` error server

## Catatan Implementasi
- Resource API sebaiknya dipisah dari model langsung.
- Gunakan rate limiting untuk auth, complaints, dan letters.
- Upload file surat dan pengaduan memerlukan endpoint multipart khusus atau signed upload flow.
