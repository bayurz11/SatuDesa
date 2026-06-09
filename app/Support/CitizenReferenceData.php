<?php

namespace App\Support;

class CitizenReferenceData
{
    public static function genderOptions(): array
    {
        return [
            'L' => 'Laki-laki',
            'P' => 'Perempuan',
        ];
    }

    public static function religionOptions(): array
    {
        return [
            'Islam',
            'Kristen',
            'Katolik',
            'Hindu',
            'Buddha',
            'Khonghucu',
            'Kepercayaan Terhadap Tuhan YME',
        ];
    }

    public static function occupationOptions(): array
    {
        return [
            'Belum/Tidak Bekerja',
            'Mengurus Rumah Tangga',
            'Pelajar/Mahasiswa',
            'Pensiunan',
            'Pegawai Negeri Sipil',
            'Tentara Nasional Indonesia',
            'Kepolisian RI',
            'Perdagangan',
            'Petani/Pekebun',
            'Peternak',
            'Nelayan/Perikanan',
            'Industri',
            'Konstruksi',
            'Transportasi',
            'Karyawan Swasta',
            'Karyawan BUMN',
            'Karyawan BUMD',
            'Karyawan Honorer',
            'Buruh Harian Lepas',
            'Buruh Tani/Perkebunan',
            'Buruh Nelayan/Perikanan',
            'Buruh Peternakan',
            'Pembantu Rumah Tangga',
            'Tukang Cukur',
            'Tukang Listrik',
            'Tukang Batu',
            'Tukang Kayu',
            'Tukang Sol Sepatu',
            'Tukang Las/Pandai Besi',
            'Tukang Jahit',
            'Penata Rias',
            'Penata Busana',
            'Penata Rambut',
            'Mekanik',
            'Seniman',
            'Tabib',
            'Paraji',
            'Perancang Busana',
            'Penterjemah',
            'Imam Masjid',
            'Pendeta',
            'Pastor',
            'Wartawan',
            'Ustadz/Mubaligh',
            'Juru Masak',
            'Promotor Acara',
            'Anggota DPR-RI',
            'Anggota DPD',
            'Anggota BPK',
            'Presiden',
            'Wakil Presiden',
            'Anggota Mahkamah Konstitusi',
            'Anggota Kabinet/Kementerian',
            'Duta Besar',
            'Gubernur',
            'Wakil Gubernur',
            'Bupati',
            'Wakil Bupati',
            'Wali Kota',
            'Wakil Wali Kota',
            'Anggota DPRD Provinsi',
            'Anggota DPRD Kabupaten/Kota',
            'Dosen',
            'Guru',
            'Pilot',
            'Pengacara',
            'Notaris',
            'Arsitek',
            'Akuntan',
            'Konsultan',
            'Dokter',
            'Bidan',
            'Perawat',
            'Apoteker',
            'Psikiater/Psikolog',
            'Penyiar Televisi',
            'Penyiar Radio',
            'Wiraswasta',
            'Lainnya',
        ];
    }

    public static function educationOptions(): array
    {
        return [
            'Tidak/Belum Sekolah',
            'Belum Tamat SD/Sederajat',
            'Tamat SD/Sederajat',
            'SLTP/Sederajat',
            'SLTA/Sederajat',
            'Diploma I/II',
            'Akademi/Diploma III/S. Muda',
            'Diploma IV/Strata I',
            'Strata II',
            'Strata III',
        ];
    }

    public static function citizenshipOptions(): array
    {
        return [
            'WNI',
            'WNA',
        ];
    }

    public static function statusOptions(): array
    {
        return [
            'active' => 'Aktif',
            'inactive' => 'Tidak Aktif',
            'moved' => 'Pindah',
            'deceased' => 'Meninggal',
        ];
    }

    public static function maritalStatusOptions(): array
    {
        return [
            'Belum Kawin',
            'Kawin',
            'Cerai Hidup',
            'Cerai Mati',
        ];
    }

    public static function familyRelationshipOptions(): array
    {
        return [
            'Kepala Keluarga',
            'Suami',
            'Istri',
            'Anak',
            'Menantu',
            'Cucu',
            'Orang Tua',
            'Mertua',
            'Famili Lain',
            'Pembantu',
            'Lainnya',
        ];
    }

    public static function arrivalReasonOptions(): array
    {
        return [
            'Pekerjaan',
            'Pendidikan',
            'Mengikuti Orang Tua/Keluarga',
            'Perkawinan',
            'Keamanan',
            'Kesehatan',
            'Perumahan',
            'Lainnya',
        ];
    }

    public static function arrivalClassificationOptions(): array
    {
        return [
            'Antar Desa/Kelurahan',
            'Antar Kecamatan',
            'Antar Kabupaten/Kota',
            'Antar Provinsi',
            'Luar Negeri',
        ];
    }

    public static function deathCauseOptions(): array
    {
        return [
            'Sakit Biasa/Tua',
            'Wabah Penyakit',
            'Kecelakaan',
            'Kriminalitas',
            'Bunuh Diri',
            'Lainnya',
        ];
    }

    public static function birthTypeOptions(): array
    {
        return [
            'Tunggal',
            'Kembar 2',
            'Kembar 3',
            'Kembar 4 atau lebih',
        ];
    }

    public static function birthAttendantOptions(): array
    {
        return [
            'Dokter',
            'Bidan/Perawat',
            'Dukun Bayi/Paraji',
            'Lainnya',
        ];
    }

    public static function reporterRelationOptions(): array
    {
        return [
            'Kepala Keluarga',
            'Suami',
            'Istri',
            'Anak',
            'Orang Tua',
            'Saudara',
            'Wali',
            'Tetangga',
            'Perangkat Desa',
            'Lainnya',
        ];
    }

    public static function normalizeGender(?string $value): ?string
    {
        $value = trim((string) $value);

        return match (mb_strtolower($value)) {
            'l', 'laki-laki', 'laki laki', 'male' => 'L',
            'p', 'perempuan', 'female' => 'P',
            '', null => null,
            default => $value,
        };
    }

    public static function normalizeCitizenship(?string $value): ?string
    {
        $value = trim((string) $value);

        return match (mb_strtoupper($value)) {
            'WNI', 'INDONESIA', 'WN INDONESIA' => 'WNI',
            'WNA', 'ASING' => 'WNA',
            '', null => null,
            default => $value,
        };
    }
}
