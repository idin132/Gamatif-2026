<?php

namespace App\Http\Controllers\Peserta;

use App\Http\Controllers\Controller;
use App\Models\Kelompok;
use App\Models\JadwalKegiatan;
use App\Models\PengaturanWeb;
use App\Models\SosialMedia;
use App\Models\IzinKehadiran;
use App\Models\Menfess;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\KetuaAngkatan;
use App\Models\KritikSaran;
use App\Models\Absensi;
use Illuminate\Support\Facades\Hash;
use App\Models\MahasiswaBaru;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{

    public function landingPage()
    {
        $pengaturan = PengaturanWeb::first();
        $jadwals = JadwalKegiatan::orderBy('tanggal', 'asc')->get();
        $calonKetua = KetuaAngkatan::all();
        $sosmed = SosialMedia::all();
        $menfesses = Menfess::latest()->take(6)->get();

        return view('landing', compact('pengaturan', 'jadwals', 'calonKetua', 'sosmed', 'menfesses'));
    }

    public function kirimKritikSaran(Request $request)
    {
        $request->validate([
            'nama' => ['nullable', 'string', 'max:255'],
            'pesan' => ['required', 'string'],
        ]);

        KritikSaran::create([
            'nama' => $request->nama ?: 'Anonim',
            'pesan' => $request->pesan,
        ]);

        return back()->with('success', 'Pesan kritik & saran berhasil dikirim.');
    }
    public function index()
    {
        $peserta = Auth::guard('peserta')->user()->load(['kelompok']);
        $kelompoks = Kelompok::withCount('mahasiswaBarus')->get();
        $jadwals = JadwalKegiatan::orderBy('tanggal', 'asc')->get();
        $pengaturan = PengaturanWeb::first();
        $sosmed = SosialMedia::all();

        // Rekap absensi khusus mahasiswa yang sedang login
        $riwayatAbsensi = Absensi::with('jadwalKegiatan')
            ->where('mahasiswa_baru_id', $peserta->id)
            ->get();

        return view('peserta.dashboard', compact(
            'peserta',
            'kelompoks',
            'jadwals',
            'pengaturan',
            'sosmed',
            'riwayatAbsensi'
        ));
    }

    public function pilihKelompok(Request $request)
    {
        $request->validate([
            'kelompok_id' => ['required', 'exists:kelompoks,id'],
        ]);

        $peserta = Auth::guard('peserta')->user();

        if ($peserta->kelompok_id) {
            return back()->with('error', 'Anda sudah memilih House!');
        }

        $peserta->update([
            'kelompok_id' => $request->kelompok_id,
        ]);

        return back()->with('success', 'Berhasil bergabung dengan House!');
    }

    public function ajukanIzin(Request $request)
    {
        $request->validate([
            'jadwal_kegiatan_id' => ['required', 'exists:jadwal_kegiatan,id'],
            'keterangan' => ['required', 'in:izin,sakit'],
            'catatan' => ['required', 'string', 'max:255'],
            'foto' => ['nullable', 'image', 'max:2048'],
        ]);

        $peserta = Auth::guard('peserta')->user();
        $fotoPath = $request->hasFile('foto') ? $request->file('foto')->store('bukti_izin', 'public') : null;

        IzinKehadiran::create([
            'mahasiswa_baru_id' => $peserta->id,
            'jadwal_kegiatan_id' => $request->jadwal_kegiatan_id,
            'keterangan' => $request->keterangan,
            'catatan' => $request->catatan,
            'foto' => $fotoPath,
        ]);

        return back()->with('success', 'Pengajuan izin berhasil dikirim.');
    }

    public function kirimMenfess(Request $request)
    {
        $request->validate([
            'from' => ['required', 'string', 'max:255'],
            'to' => ['required', 'string', 'max:255'],
            'message' => ['required', 'string'],
        ]);

        Menfess::create($request->only('from', 'to', 'message'));

        return back()->with('success', 'Pesan menfess berhasil dikirim!');
    }

    public function updateProfil(Request $request)
    {
        $peserta = Auth::guard('peserta')->user();

        $validated = $request->validate([
            'nama_lengkap' => ['required', 'string', 'max:255'],
            'nomor_whatsapp' => ['required', 'string', 'max:255'],
            'alamat' => ['required', 'string'],
            'password' => ['nullable', 'string', 'min:6', 'confirmed'],
        ]);

        $peserta->nama_lengkap = $validated['nama_lengkap'];
        $peserta->nomor_whatsapp = $validated['nomor_whatsapp'];
        $peserta->alamat = $validated['alamat'];

        if (!empty($validated['password'])) {
            $peserta->password = Hash::make($validated['password']);
        }

        $peserta->save();

        return back()->with('success', 'Profil berhasil diperbarui!');
    }

    public function gachaKelompok(Request $request)
    {
        $peserta = auth()->guard('peserta')->user();

        if ($peserta->kelompok_id) {
            return response()->json([
                'status' => 'error',
                'message' => 'Anda sudah memiliki House!',
            ], 400);
        }

        // Eksekusi penentuan kelompok dengan lock transaksi agar anti-bentrok
        $assignedKelompok = DB::transaction(function () use ($peserta) {
            $gender = $peserta->jenis_kelamin;

            // Ambil kelompok yang memiliki anggota dengan gender yang sama paling sedikit
            $kelompok = Kelompok::withCount([
                'mahasiswaBarus as same_gender_count' => function ($query) use ($gender) {
                    $query->where('jenis_kelamin', $gender);
                },
                'mahasiswaBarus as total_count'
            ])
                ->lockForUpdate()
                ->orderBy('same_gender_count', 'asc') // Prioritaskan gender paling sedikit
                ->orderBy('total_count', 'asc')       // Jika seri, prioritaskan total terkecil
                ->inRandomOrder()                     // Acak jika ada lebih dari 1 kelompok dengan jumlah sama persis
                ->first();

            if (!$kelompok) {
                throw new \Exception('Data kelompok belum tersedia di sistem.');
            }

            $peserta->update([
                'kelompok_id' => $kelompok->id,
            ]);

            return $kelompok;
        });

        return response()->json([
            'status' => 'success',
            'kelompok' => [
                'id' => $assignedKelompok->id,
                'nama' => $assignedKelompok->nama_kelompok,
                'url_grub' => $assignedKelompok->url_grub,
            ],
        ]);
    }
}