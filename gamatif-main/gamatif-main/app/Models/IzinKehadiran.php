<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Absensi;

class IzinKehadiran extends Model
{
    use HasFactory;

    protected $table = 'izin_kehadiran';

    protected $fillable = [
        'mahasiswa_baru_id',
        'jadwal_kegiatan_id',
        'keterangan',
        'catatan',
        'foto',
    ];

    public function mahasiswa()
    {
        return $this->belongsTo(MahasiswaBaru::class, 'mahasiswa_baru_id');
    }

    public function jadwal()
    {
        return $this->belongsTo(JadwalKegiatan::class, 'jadwal_kegiatan_id');
    }

    protected static function normalizeStatus(string $raw): string
    {
        $s = strtolower(trim($raw));
        $allowed = ['hadir', 'telat', 'izin', 'sakit', 'alpa'];

        if (in_array($s, $allowed, true)) {
            return $s;
        }

        // heuristik: jika mengandung kata izin/sakit
        if (stripos($s, 'izin') !== false) {
            return 'izin';
        }
        if (stripos($s, 'sakit') !== false) {
            return 'sakit';
        }

        // fallback
        return 'izin';
    }

    protected static function booted()
    {
        // sebelum create: cegah duplikat izin (mahasiswa + jadwal)
        static::creating(function ($izin) {
            $exists = static::where('mahasiswa_baru_id', $izin->mahasiswa_baru_id)
                ->where('jadwal_kegiatan_id', $izin->jadwal_kegiatan_id)
                ->exists();

            if ($exists) {
                // batalkan pembuatan duplikat izin
                return false;
            }

            // buat absensi bila belum ada
            $status = static::normalizeStatus($izin->keterangan ?? 'izin');

            $absExists = Absensi::where('mahasiswa_baru_id', $izin->mahasiswa_baru_id)
                ->where('jadwal_kegiatan_id', $izin->jadwal_kegiatan_id)
                ->first();

            if (! $absExists) {
                Absensi::create([
                    'mahasiswa_baru_id'  => $izin->mahasiswa_baru_id,
                    'jadwal_kegiatan_id' => $izin->jadwal_kegiatan_id,
                    'status'             => $status,
                ]);
            } else {
                // kalau sudah ada, sinkronkan status (opsional)
                $absExists->update(['status' => $status]);
            }

            return true;
        });

        // saat update: sinkron seluruh perubahan ke absensi
        static::updated(function ($izin) {
            // original keys sebelum update
            $origMahasiswa = $izin->getOriginal('mahasiswa_baru_id');
            $origJadwal = $izin->getOriginal('jadwal_kegiatan_id');

            // current keys setelah update
            $newMahasiswa = $izin->mahasiswa_baru_id;
            $newJadwal = $izin->jadwal_kegiatan_id;

            $newStatus = static::normalizeStatus($izin->keterangan ?? 'izin');

            // cari absensi yang terkait dengan original keys
            $absensi = Absensi::where('mahasiswa_baru_id', $origMahasiswa)
                ->where('jadwal_kegiatan_id', $origJadwal)
                ->first();

            if ($absensi) {
                // cek apakah sudah ada absensi lain yang menggunakan kombinasi target baru
                $conflict = Absensi::where('mahasiswa_baru_id', $newMahasiswa)
                    ->where('jadwal_kegiatan_id', $newJadwal)
                    ->where('id', '!=', $absensi->id)
                    ->first();

                if ($conflict) {
                    // ada duplikat pada target baru:
                    // - update status pada baris conflict
                    $conflict->update(['status' => $newStatus]);

                    // - hapus baris absensi lama agar tidak ada duplikat
                    $absensi->delete();
                } else {
                    // tidak ada conflict: update absensi lama ke nilai baru
                    $absensi->mahasiswa_baru_id = $newMahasiswa;
                    $absensi->jadwal_kegiatan_id = $newJadwal;
                    $absensi->status = $newStatus;
                    $absensi->save();
                }
            } else {
                // tidak ada absensi lama (mungkin dibuat manual/terhapus)
                // cek apakah ada absensi untuk target baru, update status; jika tidak, buat baru
                $target = Absensi::where('mahasiswa_baru_id', $newMahasiswa)
                    ->where('jadwal_kegiatan_id', $newJadwal)
                    ->first();

                if ($target) {
                    $target->update(['status' => $newStatus]);
                } else {
                    Absensi::create([
                        'mahasiswa_baru_id'  => $newMahasiswa,
                        'jadwal_kegiatan_id' => $newJadwal,
                        'status'             => $newStatus,
                    ]);
                }
            }
        });

        // saat hapus izin: hapus absensi terkait (cari berdasarkan current values dan juga original values untuk aman)
        static::deleting(function ($izin) {
            $mahasiswa = $izin->mahasiswa_baru_id;
            $jadwal = $izin->jadwal_kegiatan_id;

            Absensi::where('mahasiswa_baru_id', $mahasiswa)
                ->where('jadwal_kegiatan_id', $jadwal)
                ->delete();

            // juga coba hapus berdasarkan original (jika record sempat diubah sebelum delete)
            $origMahasiswa = $izin->getOriginal('mahasiswa_baru_id');
            $origJadwal = $izin->getOriginal('jadwal_kegiatan_id');

            if ($origMahasiswa && $origJadwal) {
                Absensi::where('mahasiswa_baru_id', $origMahasiswa)
                    ->where('jadwal_kegiatan_id', $origJadwal)
                    ->delete();
            }
        });
    }
}
