<?php

namespace App\Http\Controllers;

use App\Models\Bobot;
use App\Models\Lomba;
use App\Models\Mahasiswa;
use App\Models\keahlianMahasiswa;
use App\Models\Penghargaan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use App\Services\TopsisService;
use App\Services\SawService;
use Carbon\Carbon;

class RekomendasiController extends Controller
{
    public function index()
    {
        try {
            // Debug: Check if we can connect to database
            // dd('Starting rekomendasi index method');
            
            // Fix: Use correct column names from your migration
            $lombaAkanDatang = Lomba::where('lomba_tanggal_mulai', '>', Carbon::now())
                ->where('lomba_visible', true) // Only show visible competitions
                ->orderBy('lomba_tanggal_mulai', 'asc')
                ->get();

            // Debug: Check what we found
            // dd('Found ' . $lombaAkanDatang->count() . ' upcoming competitions', $lombaAkanDatang->toArray());

            return view('admin.rekomendasiTopsis.index', compact('lombaAkanDatang'));
            
        } catch (\Exception $e) {
            // Debug: Show the error
            dd('Error in rekomendasi index: ' . $e->getMessage(), $e->getTraceAsString());
            
            // Return view with empty collection and error message
            $lombaAkanDatang = collect();
            return view('admin.rekomendasiTopsis.index', compact('lombaAkanDatang'))
                ->with('error', 'Terjadi kesalahan saat memuat data: ' . $e->getMessage());
        }
    }

    public function generateRekomendasi(Request $request)
    {
        $request->validate([
            'lomba_id' => 'required|exists:m_lombas,id',
            'jumlah_rekomendasi' => 'required|integer|min:1|max:20'
        ]);

        $lombaId = $request->lomba_id;
        $jumlahRekomendasi = $request->jumlah_rekomendasi;

        $lomba = Lomba::findOrFail($lombaId);
        $keahlianLomba = DB::table('t_keahlian_lombas')
            ->where('lomba_id', $lombaId)
            ->pluck('keahlian_id')
            ->toArray();
        $bobots = Bobot::pluck('bobot', 'kriteria')->toArray();
        $mahasiswas = $this->getMahasiswaData();

        if ($mahasiswas->isEmpty()) {
            return redirect()->back()->with('error', 'Tidak ada data mahasiswa yang tersedia.');
        }

        // Pakai service
        $topsis = new TopsisService();
        $hasilTopsis = $topsis->hitung($mahasiswas, $bobots, $keahlianLomba);

        $rekomendasi = collect($hasilTopsis)->take($jumlahRekomendasi);

        return view('admin.rekomendasiTopsis.hasil', compact('lomba', 'rekomendasi', 'bobots'));
    }

    private function getMahasiswaData()
    {
        return Mahasiswa::select([
            'm_mahasiswas.id',
            'm_mahasiswas.mahasiswa_nama as nama',
            'm_mahasiswas.mahasiswa_nim as nim',
            'm_mahasiswas.mahasiswa_score',
            'm_mahasiswas.keahlian_id as keahlian_utama_id',
            'keahlian_utama.keahlian_nama as keahlian_utama',
            DB::raw('COUNT(DISTINCT t_keahlian_mahasiswas.keahlian_id) as jumlah_keahlian_tambahan'),
            DB::raw('COUNT(DISTINCT m_penghargaans.id) as jumlah_lomba')
        ])
        ->leftJoin('m_keahlians as keahlian_utama', 'm_mahasiswas.keahlian_id', '=', 'keahlian_utama.id')
        ->leftJoin('t_keahlian_mahasiswas', 'm_mahasiswas.id', '=', 't_keahlian_mahasiswas.mahasiswa_id')
        ->leftJoin('m_penghargaans', 'm_mahasiswas.id', '=', 'm_penghargaans.mahasiswa_id')
        ->groupBy([
            'm_mahasiswas.id',
            'm_mahasiswas.mahasiswa_nama',
            'm_mahasiswas.mahasiswa_nim',
            'm_mahasiswas.mahasiswa_score',
            'm_mahasiswas.keahlian_id',
            'keahlian_utama.keahlian_nama'
        ])
        ->get();
    }

    // filepath: [RekomendasiController.php](http://_vscodecontentref_/0)
    public function kirimRekomendasi(Request $request)
    {
        $request->validate([
            'mahasiswa_id' => 'required|exists:m_mahasiswas,id',
            'lomba_id' => 'required|exists:m_lombas,id',
            'rekomendasi_data' => 'required|array'
        ]);

        $lomba = \App\Models\Lomba::findOrFail($request->lomba_id);

        // Ambil notifikasi lama dari session
        $notifikasi = session()->get('notifikasi_mahasiswa', []);

        // Tambahkan notifikasi untuk semua mahasiswa yang direkomendasikan
        foreach ($request->rekomendasi_data as $item) {
            $notifikasi[] = [
                'judul' => 'Rekomendasi Lomba: ' . $lomba->lomba_nama,
                'pesan' => 'Anda direkomendasikan untuk mengikuti lomba ini.',
                'lomba' => [
                    'lomba_nama' => $lomba->lomba_nama,
                    'lomba_id' => $lomba->id,
                ],
                'mahasiswa' => [
                    'mahasiswa_nama' => $item['mahasiswa']['nama'],
                    'mahasiswa_telepon' => $item['mahasiswa']['telepon'],
                ],
                'data_ranking' => json_encode($request->rekomendasi_data),
                'is_read' => false,
                'created_at' => now(),
            ];
        }

        session()->put('notifikasi_mahasiswa', $notifikasi);

        return response()->json(['success' => true, 'message' => 'Notifikasi berhasil dikirim ke mahasiswa.']);
    }

    public function indexSaw()
    {
        try {
            $lombaAkanDatang = Lomba::with('keahlians')
                ->where('lomba_tanggal_mulai', '>', Carbon::now())
                ->where('lomba_visible', true)
                ->orderBy('lomba_tanggal_mulai', 'asc')
                ->get();

            return view('admin.rekomendasiSaw.index', compact('lombaAkanDatang'));
        } catch (\Exception $e) {
            $lombaAkanDatang = collect();
            return view('admin.rekomendasiSaw.index', compact('lombaAkanDatang'))
                ->with('error', 'Terjadi kesalahan saat memuat data: ' . $e->getMessage());
        }
    }

    public function generateRekomendasiSaw(Request $request)
    {
        $request->validate([
            'lomba_id' => 'required|exists:m_lombas,id',
            'jumlah_rekomendasi' => 'required|integer|min:1|max:20'
        ]);

        $lombaId = $request->lomba_id;
        $jumlahRekomendasi = $request->jumlah_rekomendasi;

        $lomba = Lomba::findOrFail($lombaId);
        $keahlianLomba = DB::table('t_keahlian_lombas')
            ->where('lomba_id', $lombaId)
            ->pluck('keahlian_id')
            ->toArray();
        $bobots = Bobot::pluck('bobot', 'kriteria')->toArray();
        $mahasiswas = $this->getMahasiswaData();

        if ($mahasiswas->isEmpty()) {
            return redirect()->back()->with('error', 'Tidak ada data mahasiswa yang tersedia.');
        }

        $saw = new SawService();
        $hasilSaw = $saw->hitung($mahasiswas, $bobots, $keahlianLomba);

        $rekomendasi = collect($hasilSaw)->take($jumlahRekomendasi);

        return view('admin.rekomendasiSaw.hasil', compact('lomba', 'rekomendasi', 'bobots'));
    }
}