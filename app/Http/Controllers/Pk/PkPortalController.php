<?php

namespace App\Http\Controllers\Pk;

use App\Http\Controllers\Controller;
use App\Models\DataMahasiswa;
use App\Models\MahasiswaBaru;
use App\Models\JadwalKegiatan;
use App\Models\IzinKehadiran;
use Illuminate\Http\Request;
use App\Models\NamaBarangBawaan;
use Illuminate\Support\Facades\Auth;

class PkPortalController extends Controller
{

    private function getBarangColumns(): array
    {
        return [
            'day_1' => [
                'makanan_berat_day_1',
                'susu_superhero_day_1',
                'raja_dangdut_day_1',
                'snack_rindu_day_1',
                'wafer_terkenal_day_1',
            ],
            'day_2' => [
                'makanan_berat_day_2',
                'susu_monyet_day_2',
                'roti_ketawa_day_2',
                'cokelat_berjerawat_day_2',
                'bintang_selanjutnya_day_2',
            ],
            'day_3' => [
                'makanan_berat_day_3',
                'biskuit_3_cara_day_3',
                'air_keringat_atlet_day_3',
                'susu_puncak_day_3',
                'stik_sayuran_day_3',
            ],
        ];
    }
    public function index(Request $request)
    {
        $user = Auth::user();
        $kelompokId = $user->kelompok_id;
        $kelompok = $user->kelompok;

        $mabas = MahasiswaBaru::where('kelompok_id', $kelompokId)->get();
        $dataMahasiswas = DataMahasiswa::where('kelompok_id', $kelompokId)->get();
        $jadwals = JadwalKegiatan::orderBy('tanggal', 'asc')->get();
        $izinList = IzinKehadiran::whereIn('mahasiswa_baru_id', $mabas->pluck('id'))->latest()->get();

        // AMBIL DATA DARI TABEL NAMA BARANG BAWAANS (urutkan berdasarkan id)
        $masterBarang = [
            'day_1' => NamaBarangBawaan::where('hari', 'day_1')->orderBy('id', 'asc')->pluck('nama_barang')->toArray(),
            'day_2' => NamaBarangBawaan::where('hari', 'day_2')->orderBy('id', 'asc')->pluck('nama_barang')->toArray(),
            'day_3' => NamaBarangBawaan::where('hari', 'day_3')->orderBy('id', 'asc')->pluck('nama_barang')->toArray(),
        ];

        // Kirim mapping kolom ke view
        $barangColumns = $this->getBarangColumns();

        return view('pk.dashboard', compact('user', 'kelompok', 'mabas', 'dataMahasiswas', 'jadwals', 'izinList', 'barangColumns', 'masterBarang'));
    }

    public function toggleBarang(Request $request)
    {
        try {
            $request->validate([
                'id' => 'required',
                'field' => 'required|string',
            ]);

            $data = DataMahasiswa::find($request->id);

            if (!$data) {
                return response()->json(['status' => 'error', 'message' => 'Data mahasiswa tidak ditemukan'], 404);
            }

            $field = $request->field;
            $currentVal = (int) ($data->$field ?? 0);
            $newVal = $currentVal === 1 ? 0 : 1;

            $data->$field = $newVal;
            $data->save();

            return response()->json(['status' => 'success', 'new_value' => $newVal]);
        } catch (\Throwable $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()], 500);
        }
    }

    public function updateKehadiran(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:data_mahasiswa,id',
            'day' => 'required|in:day_1,day_2,day_3',
            'status' => 'required|in:0,1,2',
        ]);

        $data = DataMahasiswa::where('id', $request->id)
            ->where('kelompok_id', Auth::user()->kelompok_id)
            ->firstOrFail();

        $day = $request->day;
        $data->$day = $request->status;
        $data->save();

        return response()->json(['status' => 'success']);
    }

    public function storeIzin(Request $request)
    {
        $request->validate([
            'mahasiswa_baru_id' => 'required|exists:mahasiswa_baru,id',
            'jadwal_kegiatan_id' => 'required|exists:jadwal_kegiatan,id',
            'keterangan' => 'required|in:izin,sakit',
            'catatan' => 'required|string',
            'foto' => 'nullable|image|max:2048',
        ]);

        $fotoPath = $request->hasFile('foto') ? $request->file('foto')->store('bukti_izin', 'public') : null;

        IzinKehadiran::create([
            'mahasiswa_baru_id' => $request->mahasiswa_baru_id,
            'jadwal_kegiatan_id' => $request->jadwal_kegiatan_id,
            'keterangan' => $request->keterangan,
            'catatan' => $request->catatan,
            'foto' => $fotoPath,
        ]);

        return back()->with('success', 'Surat izin berhasil disimpan!');
    }

    // Checklist semua barang bawaan sekaligus untuk 1 mahasiswa
    public function checkAllBarang(Request $request)
    {
        try {
            $request->validate([
                'id' => 'required',
                'day' => 'required|in:day_1,day_2,day_3',
            ]);

            $data = DataMahasiswa::find($request->id);

            if (!$data) {
                return response()->json(['status' => 'error', 'message' => 'Data mahasiswa tidak ditemukan'], 404);
            }

            $columns = $this->getBarangColumns()[$request->day] ?? [];

            foreach ($columns as $column) {
                $data->$column = 1;
            }

            $data->save();

            return response()->json(['status' => 'success']);
        } catch (\Throwable $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()], 500);
        }
    }

    public function showLogin()
    {
        // Jika sudah login dan memiliki role PK, langsung arahkan ke dashboard
        if (Auth::check() && Auth::user()->role === 'pk') {
            return redirect()->route('pk.dashboard');
        }

        return view('pk.auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
        ]);

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $user = Auth::user();

            // Pastikan hanya user dengan role 'pk' yang diizinkan masuk
            if ($user->role === 'pk') {
                $request->session()->regenerate();
                return redirect()->intended(route('pk.dashboard'));
            }

            // Jika bukan PK (misal admin murni atau akun lain), logout dan tolak
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return back()->withErrors([
                'email' => 'Akun ini tidak memiliki hak akses sebagai PK / House Leader.',
            ])->onlyInput('email');
        }

        return back()->withErrors([
            'email' => 'Email atau password salah.',
        ])->onlyInput('email');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('pk.login');
    }
}