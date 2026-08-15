<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Banjar;
use App\Models\Bantuan;
use App\Models\Fasilitas;
use App\Models\Kepala_Keluarga;
use App\Models\Anggota_Keluarga;
use App\Models\Bantuan_Penduduk;

/**
 * Data dummy untuk Sangket Desa — supaya frontend bisa langsung dicoba tanpa
 * perlu input data satu-satu lewat form.
 *
 * Cara pakai:
 *   php artisan migrate:fresh   (reset dulu supaya no_kk/nik/kode tidak bentrok)
 *   php artisan db:seed --class=SangketDesaSeeder
 *
 * Atau cukup panggil dari DatabaseSeeder (lihat catatan di bawah).
 */
class SangketDesaSeeder extends Seeder
{
    public function run(): void
    {
        // ─── 1. BANJAR ──────────────────────────────────────────────────────
        $banjarList = [
            ['nama_banjar' => 'Banjar Kaje'],
            ['nama_banjar' => 'Banjar Kelod'],
            ['nama_banjar' => 'Banjar Dangin Margi'],
            ['nama_banjar' => 'Banjar Dauh Margi'],
            ['nama_banjar' => 'Banjar Tengah'],
        ];
        foreach ($banjarList as $b) {
            Banjar::create($b);
        }

        // ─── 2. BANTUAN (program bantuan sosial) ───────────────────────────
        $bantuanList = [
            [
                'kode_bantuan' => 'B001',
                'nama_bantuan' => 'Program Keluarga Harapan (PKH)',
                'keterangan' => 'Bantuan tunai bersyarat untuk keluarga kurang mampu',
                'sumber_dana' => 'nasional',
                'status' => 'aktif',
            ],
            [
                'kode_bantuan' => 'B002',
                'nama_bantuan' => 'Bantuan Pangan Non Tunai (BPNT)',
                'keterangan' => 'Bantuan sembako bulanan',
                'sumber_dana' => 'nasional',
                'status' => 'aktif',
            ],
            [
                'kode_bantuan' => 'B003',
                'nama_bantuan' => 'BLT Dana Desa',
                'keterangan' => 'Bantuan Langsung Tunai dari Anggaran Dana Desa',
                'sumber_dana' => 'dana_desa',
                'status' => 'aktif',
            ],
            [
                'kode_bantuan' => 'B004',
                'nama_bantuan' => 'Bedah Rumah Tidak Layak Huni',
                'keterangan' => 'Bantuan rehabilitasi rumah dari APBD Kabupaten',
                'sumber_dana' => 'daerah',
                'status' => 'nonaktif',
            ],
        ];
        foreach ($bantuanList as $b) {
            Bantuan::create($b);
        }

        // ─── 3. FASILITAS PUBLIK ────────────────────────────────────────────
        $fasilitasList = [
            ['nama_fasilitas' => 'Balai Banjar Kaje', 'jenis_fasilitas' => 'umum', 'lokasi_banjar_id' => 1, 'kondisi' => 'baik', 'keterangan' => 'Direnovasi tahun 2024'],
            ['nama_fasilitas' => 'Pura Dalem Sangket', 'jenis_fasilitas' => 'ibadah', 'lokasi_banjar_id' => 1, 'kondisi' => 'baik', 'keterangan' => 'Pura kahyangan desa'],
            ['nama_fasilitas' => 'SD Negeri 1 Sangket', 'jenis_fasilitas' => 'pendidikan', 'lokasi_banjar_id' => 2, 'kondisi' => 'baik', 'keterangan' => '6 rombongan belajar'],
            ['nama_fasilitas' => 'Posyandu Kelod', 'jenis_fasilitas' => 'kesehatan', 'lokasi_banjar_id' => 2, 'kondisi' => 'rusak_ringan', 'keterangan' => 'Atap perlu perbaikan'],
            ['nama_fasilitas' => 'Lapangan Voli Dangin Margi', 'jenis_fasilitas' => 'olahraga', 'lokasi_banjar_id' => 3, 'kondisi' => 'rusak_ringan', 'keterangan' => 'Net perlu diganti'],
            ['nama_fasilitas' => 'Balai Banjar Dauh Margi', 'jenis_fasilitas' => 'umum', 'lokasi_banjar_id' => 4, 'kondisi' => 'baik', 'keterangan' => null],
            ['nama_fasilitas' => 'Pura Puseh', 'jenis_fasilitas' => 'ibadah', 'lokasi_banjar_id' => 4, 'kondisi' => 'baik', 'keterangan' => null],
            ['nama_fasilitas' => 'Jalan Usaha Tani Tengah', 'jenis_fasilitas' => 'umum', 'lokasi_banjar_id' => 5, 'kondisi' => 'rusak_berat', 'keterangan' => 'Rusak akibat longsor kecil'],
        ];
        foreach ($fasilitasList as $f) {
            Fasilitas::create($f);
        }

        // ─── 4. KEPALA KELUARGA ─────────────────────────────────────────────
        // Titik koordinat di sekitar Desa Sangket, Kec. Buleleng, Bali.
        $kkList = [
            [
                'no_kk' => '5108041209000001', 'nik' => '5108045006900001',
                'nama_kepala_keluarga' => 'I Wayan Sudiartha', 'tempat_lahir' => 'Singaraja',
                'tanggal_lahir' => '1978-05-12', 'jenis_kelamin' => 'Laki-laki', 'agama' => 'Hindu',
                'pendidikan_terakhir' => 'SLTA/Sederajat', 'pekerjaan' => 'Petani',
                'status_perkawinan' => 'Kawin', 'alamat_lengkap' => 'Jalan Merdeka No. 12',
                'rt' => 1, 'rw' => 1, 'banjar_id' => 1,
                'latitude' => -8.112340, 'longitude' => 115.092310,
                'status_penduduk' => 'Permanen', 'alamat_asal' => null, 'tanggal_mulai_tinggal' => null,
            ],
            [
                'no_kk' => '5108041209000002', 'nik' => '5108046203880002',
                'nama_kepala_keluarga' => 'I Made Suarjana', 'tempat_lahir' => 'Buleleng',
                'tanggal_lahir' => '1980-03-24', 'jenis_kelamin' => 'Laki-laki', 'agama' => 'Hindu',
                'pendidikan_terakhir' => 'Diploma III', 'pekerjaan' => 'Wiraswasta',
                'status_perkawinan' => 'Kawin', 'alamat_lengkap' => 'Jalan Pantai Indah No. 5',
                'rt' => 2, 'rw' => 1, 'banjar_id' => 2,
                'latitude' => -8.113920, 'longitude' => 115.094870,
                'status_penduduk' => 'Permanen', 'alamat_asal' => null, 'tanggal_mulai_tinggal' => null,
            ],
            [
                'no_kk' => '5108041209000003', 'nik' => '5108041501920003',
                'nama_kepala_keluarga' => 'I Nyoman Sukanta', 'tempat_lahir' => 'Denpasar',
                'tanggal_lahir' => '1985-01-15', 'jenis_kelamin' => 'Laki-laki', 'agama' => 'Hindu',
                'pendidikan_terakhir' => 'SLTA/Sederajat', 'pekerjaan' => 'Buruh Bangunan',
                'status_perkawinan' => 'Kawin', 'alamat_lengkap' => 'Gang Anggrek No. 3',
                'rt' => 1, 'rw' => 2, 'banjar_id' => 3,
                'latitude' => -8.110870, 'longitude' => 115.090120,
                'status_penduduk' => 'Non-permanen', 'alamat_asal' => 'Denpasar',
                'tanggal_mulai_tinggal' => now()->startOfMonth()->addDays(4)->toDateString(),
            ],
            [
                'no_kk' => '5108041209000004', 'nik' => '5108042208750004',
                'nama_kepala_keluarga' => 'I Ketut Wirawan', 'tempat_lahir' => 'Singaraja',
                'tanggal_lahir' => '1975-08-22', 'jenis_kelamin' => 'Laki-laki', 'agama' => 'Hindu',
                'pendidikan_terakhir' => 'Tamat SD/Sederajat', 'pekerjaan' => 'Nelayan',
                'status_perkawinan' => 'Kawin', 'alamat_lengkap' => 'Jalan Pesisir No. 8',
                'rt' => 2, 'rw' => 1, 'banjar_id' => 1,
                'latitude' => -8.111950, 'longitude' => 115.091640,
                'status_penduduk' => 'Permanen', 'alamat_asal' => null, 'tanggal_mulai_tinggal' => null,
            ],
            [
                'no_kk' => '5108041209000005', 'nik' => '5108046909820005',
                'nama_kepala_keluarga' => 'Ni Wayan Sari Dewi', 'tempat_lahir' => 'Buleleng',
                'tanggal_lahir' => '1982-09-29', 'jenis_kelamin' => 'Perempuan', 'agama' => 'Hindu',
                'pendidikan_terakhir' => 'Diploma IV/Strata I', 'pekerjaan' => 'Guru',
                'status_perkawinan' => 'Cerai Mati', 'alamat_lengkap' => 'Jalan Kenanga No. 21',
                'rt' => 3, 'rw' => 2, 'banjar_id' => 4,
                'latitude' => -8.114650, 'longitude' => 115.093300,
                'status_penduduk' => 'Permanen', 'alamat_asal' => null, 'tanggal_mulai_tinggal' => null,
            ],
            [
                'no_kk' => '5108041209000006', 'nik' => '5108041107870006',
                'nama_kepala_keluarga' => 'I Wayan Arta Yasa', 'tempat_lahir' => 'Singaraja',
                'tanggal_lahir' => '1979-07-11', 'jenis_kelamin' => 'Laki-laki', 'agama' => 'Hindu',
                'pendidikan_terakhir' => 'SLTP/Sederajat', 'pekerjaan' => 'Pedagang',
                'status_perkawinan' => 'Kawin', 'alamat_lengkap' => 'Jalan Melati No. 9',
                'rt' => 1, 'rw' => 1, 'banjar_id' => 2,
                'latitude' => -8.113410, 'longitude' => 115.095210,
                'status_penduduk' => 'Permanen', 'alamat_asal' => null, 'tanggal_mulai_tinggal' => null,
            ],
            [
                'no_kk' => '5108041209000007', 'nik' => '5108042003910007',
                'nama_kepala_keluarga' => 'I Made Sutama', 'tempat_lahir' => 'Karangasem',
                'tanggal_lahir' => '1988-03-20', 'jenis_kelamin' => 'Laki-laki', 'agama' => 'Hindu',
                'pendidikan_terakhir' => 'SLTA/Sederajat', 'pekerjaan' => 'Sopir',
                'status_perkawinan' => 'Kawin', 'alamat_lengkap' => 'Jalan Tengah No. 14',
                'rt' => 1, 'rw' => 1, 'banjar_id' => 5,
                'latitude' => -8.109980, 'longitude' => 115.088740,
                'status_penduduk' => 'Non-permanen', 'alamat_asal' => 'Karangasem',
                'tanggal_mulai_tinggal' => now()->subMonths(8)->toDateString(),
            ],
            [
                'no_kk' => '5108041209000008', 'nik' => '5108041412890008',
                'nama_kepala_keluarga' => 'I Komang Adi Putra', 'tempat_lahir' => 'Singaraja',
                'tanggal_lahir' => '1990-12-14', 'jenis_kelamin' => 'Laki-laki', 'agama' => 'Hindu',
                'pendidikan_terakhir' => 'Diploma III', 'pekerjaan' => 'PNS',
                'status_perkawinan' => 'Kawin', 'alamat_lengkap' => 'Jalan Cendrawasih No. 2',
                'rt' => 2, 'rw' => 2, 'banjar_id' => 3,
                'latitude' => -8.110540, 'longitude' => 115.089870,
                'status_penduduk' => 'Permanen', 'alamat_asal' => null, 'tanggal_mulai_tinggal' => null,
            ],
            [
                'no_kk' => '5108041209000009', 'nik' => '5108042505840009',
                'nama_kepala_keluarga' => 'I Gede Astawa', 'tempat_lahir' => 'Buleleng',
                'tanggal_lahir' => '1984-05-25', 'jenis_kelamin' => 'Laki-laki', 'agama' => 'Hindu',
                'pendidikan_terakhir' => 'SLTA/Sederajat', 'pekerjaan' => 'Petani',
                'status_perkawinan' => 'Kawin', 'alamat_lengkap' => 'Jalan Subak No. 6',
                'rt' => 1, 'rw' => 1, 'banjar_id' => 5,
                'latitude' => -8.109210, 'longitude' => 115.087950,
                'status_penduduk' => 'Permanen', 'alamat_asal' => null, 'tanggal_mulai_tinggal' => null,
            ],
            [
                'no_kk' => '5108041209000010', 'nik' => '5108041809930010',
                'nama_kepala_keluarga' => 'I Made Dwipayana', 'tempat_lahir' => 'Klungkung',
                'tanggal_lahir' => '1993-09-18', 'jenis_kelamin' => 'Laki-laki', 'agama' => 'Islam',
                'pendidikan_terakhir' => 'SLTA/Sederajat', 'pekerjaan' => 'Karyawan Swasta',
                'status_perkawinan' => 'Kawin', 'alamat_lengkap' => 'Jalan Damai No. 17',
                'rt' => 3, 'rw' => 1, 'banjar_id' => 4,
                'latitude' => -8.115120, 'longitude' => 115.094010,
                'status_penduduk' => 'Non-permanen', 'alamat_asal' => 'Klungkung',
                'tanggal_mulai_tinggal' => now()->startOfMonth()->addDays(11)->toDateString(),
            ],
        ];
        foreach ($kkList as $kk) {
            Kepala_Keluarga::create($kk);
        }

        // ─── 5. ANGGOTA KELUARGA (istri & anak dari sebagian KK) ───────────
        $anggotaList = [
            // Keluarga I Wayan Sudiartha (no_kk ...0001)
            ['no_kk' => '5108041209000001', 'hubungan_keluarga' => 'Istri', 'nik' => '5108045803820011', 'nama_anggota_keluarga' => 'Ni Made Sukerti', 'tempat_lahir' => 'Singaraja', 'tanggal_lahir' => '1980-03-08', 'jenis_kelamin' => 'Perempuan', 'agama' => 'Hindu', 'pendidikan_terakhir' => 'SLTA/Sederajat', 'pekerjaan' => 'Ibu Rumah Tangga', 'status_perkawinan' => 'Kawin'],
            ['no_kk' => '5108041209000001', 'hubungan_keluarga' => 'Anak', 'nik' => '5108046509050012', 'nama_anggota_keluarga' => 'Ni Kadek Ayu Lestari', 'tempat_lahir' => 'Singaraja', 'tanggal_lahir' => '2005-09-25', 'jenis_kelamin' => 'Perempuan', 'agama' => 'Hindu', 'pendidikan_terakhir' => 'SLTA/Sederajat', 'pekerjaan' => 'Pelajar', 'status_perkawinan' => 'Belum Kawin'],
            ['no_kk' => '5108041209000001', 'hubungan_keluarga' => 'Anak', 'nik' => '5108041203120013', 'nama_anggota_keluarga' => 'I Komang Bagus Aditya', 'tempat_lahir' => 'Singaraja', 'tanggal_lahir' => '2012-03-12', 'jenis_kelamin' => 'Laki-laki', 'agama' => 'Hindu', 'pendidikan_terakhir' => 'Tamat SD/Sederajat', 'pekerjaan' => 'Pelajar', 'status_perkawinan' => 'Belum Kawin'],

            // Keluarga I Made Suarjana (no_kk ...0002)
            ['no_kk' => '5108041209000002', 'hubungan_keluarga' => 'Istri', 'nik' => '5108046112840014', 'nama_anggota_keluarga' => 'Ni Luh Putu Widiastuti', 'tempat_lahir' => 'Buleleng', 'tanggal_lahir' => '1984-12-01', 'jenis_kelamin' => 'Perempuan', 'agama' => 'Hindu', 'pendidikan_terakhir' => 'Diploma III', 'pekerjaan' => 'Bidan', 'status_perkawinan' => 'Kawin'],
            ['no_kk' => '5108041209000002', 'hubungan_keluarga' => 'Anak', 'nik' => '5108042701100015', 'nama_anggota_keluarga' => 'I Putu Bayu Pratama', 'tempat_lahir' => 'Buleleng', 'tanggal_lahir' => '2010-01-27', 'jenis_kelamin' => 'Laki-laki', 'agama' => 'Hindu', 'pendidikan_terakhir' => 'Tamat SD/Sederajat', 'pekerjaan' => 'Pelajar', 'status_perkawinan' => 'Belum Kawin'],

            // Keluarga I Nyoman Sukanta (no_kk ...0003, pendatang)
            ['no_kk' => '5108041209000003', 'hubungan_keluarga' => 'Istri', 'nik' => '5108044505950016', 'nama_anggota_keluarga' => 'Ni Ketut Rai Suartini', 'tempat_lahir' => 'Denpasar', 'tanggal_lahir' => '1995-05-05', 'jenis_kelamin' => 'Perempuan', 'agama' => 'Hindu', 'pendidikan_terakhir' => 'SLTA/Sederajat', 'pekerjaan' => 'Pedagang', 'status_perkawinan' => 'Kawin'],

            // Keluarga I Ketut Wirawan (no_kk ...0004)
            ['no_kk' => '5108041209000004', 'hubungan_keluarga' => 'Istri', 'nik' => '5108046308780017', 'nama_anggota_keluarga' => 'Ni Wayan Sudarmini', 'tempat_lahir' => 'Singaraja', 'tanggal_lahir' => '1978-08-03', 'jenis_kelamin' => 'Perempuan', 'agama' => 'Hindu', 'pendidikan_terakhir' => 'Tamat SD/Sederajat', 'pekerjaan' => 'Ibu Rumah Tangga', 'status_perkawinan' => 'Kawin'],
            ['no_kk' => '5108041209000004', 'hubungan_keluarga' => 'Anak', 'nik' => '5108041904020018', 'nama_anggota_keluarga' => 'I Kadek Yoga Pratama', 'tempat_lahir' => 'Singaraja', 'tanggal_lahir' => '2002-04-19', 'jenis_kelamin' => 'Laki-laki', 'agama' => 'Hindu', 'pendidikan_terakhir' => 'SLTA/Sederajat', 'pekerjaan' => 'Belum/Tidak Bekerja', 'status_perkawinan' => 'Belum Kawin'],

            // Keluarga Ni Wayan Sari Dewi (no_kk ...0005, janda — tanpa "Suami" krn enum DB tidak punya nilai itu)
            ['no_kk' => '5108041209000005', 'hubungan_keluarga' => 'Anak', 'nik' => '5108046211110019', 'nama_anggota_keluarga' => 'I Gusti Ngurah Bagus', 'tempat_lahir' => 'Buleleng', 'tanggal_lahir' => '2011-11-22', 'jenis_kelamin' => 'Laki-laki', 'agama' => 'Hindu', 'pendidikan_terakhir' => 'Tamat SD/Sederajat', 'pekerjaan' => 'Pelajar', 'status_perkawinan' => 'Belum Kawin'],

            // Keluarga I Komang Adi Putra (no_kk ...0008)
            ['no_kk' => '5108041209000008', 'hubungan_keluarga' => 'Istri', 'nik' => '5108044109920020', 'nama_anggota_keluarga' => 'Ni Putu Ari Wulandari', 'tempat_lahir' => 'Singaraja', 'tanggal_lahir' => '1992-09-01', 'jenis_kelamin' => 'Perempuan', 'agama' => 'Hindu', 'pendidikan_terakhir' => 'Diploma IV/Strata I', 'pekerjaan' => 'Perawat', 'status_perkawinan' => 'Kawin'],

            // Keluarga I Made Dwipayana (no_kk ...0010, pendatang bulan ini)
            ['no_kk' => '5108041209000010', 'hubungan_keluarga' => 'Istri', 'nik' => '5108044602960021', 'nama_anggota_keluarga' => 'Siti Nur Halimah', 'tempat_lahir' => 'Klungkung', 'tanggal_lahir' => '1996-02-06', 'jenis_kelamin' => 'Perempuan', 'agama' => 'Islam', 'pendidikan_terakhir' => 'SLTA/Sederajat', 'pekerjaan' => 'Wiraswasta', 'status_perkawinan' => 'Kawin'],
        ];
        foreach ($anggotaList as $a) {
            Anggota_Keluarga::create($a);
        }

        // ─── 6. BANTUAN PENDUDUK (penerima bantuan per KK) ─────────────────
        $bantuanPendudukList = [
            ['penduduk_no_kk' => '5108041209000001', 'bantuan_kode' => 'B001', 'tanggal_menerima' => now()->subMonths(3)->toDateString()],
            ['penduduk_no_kk' => '5108041209000003', 'bantuan_kode' => 'B001', 'tanggal_menerima' => now()->subMonth()->toDateString()],
            ['penduduk_no_kk' => '5108041209000007', 'bantuan_kode' => 'B001', 'tanggal_menerima' => now()->subMonths(2)->toDateString()],
            ['penduduk_no_kk' => '5108041209000002', 'bantuan_kode' => 'B002', 'tanggal_menerima' => now()->subMonths(4)->toDateString()],
            ['penduduk_no_kk' => '5108041209000004', 'bantuan_kode' => 'B002', 'tanggal_menerima' => now()->subMonths(4)->toDateString()],
            ['penduduk_no_kk' => '5108041209000008', 'bantuan_kode' => 'B002', 'tanggal_menerima' => now()->subMonths(1)->toDateString()],
            ['penduduk_no_kk' => '5108041209000009', 'bantuan_kode' => 'B003', 'tanggal_menerima' => now()->subMonths(2)->toDateString()],
        ];
        foreach ($bantuanPendudukList as $bp) {
            Bantuan_Penduduk::create($bp);
        }
    }
}
