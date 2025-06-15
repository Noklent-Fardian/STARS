<?php

namespace App\Http\Controllers;

use App\Models\Bobot;
use App\Models\Lomba;
use App\Models\Mahasiswa;
use App\Models\keahlianMahasiswa;
use App\Models\Penghargaan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use App\Services\TopsisService;
use App\Services\SawService;
use Carbon\Carbon;

class RekomendasiController extends Controller
{
    public function index()
    {
        try {
            $lombaAkanDatang = Lomba::where('lomba_tanggal_mulai', '>', Carbon::now())
                ->where('lomba_visible', true)
                ->orderBy('lomba_tanggal_mulai', 'asc')
                ->get();

            return view('admin.rekomendasiTopsis.index', compact('lombaAkanDatang'));
        } catch (\Exception $e) {
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
            'm_mahasiswas.mahasiswa_nomor_telepon',
            'm_mahasiswas.mahasiswa_photo',
            'm_mahasiswas.mahasiswa_angkatan',
            DB::raw('COUNT(DISTINCT t_keahlian_mahasiswas.keahlian_id) as jumlah_keahlian_tambahan'),
            DB::raw('COUNT(DISTINCT m_penghargaans.id) as jumlah_lomba')
        ])
            ->leftJoin('m_keahlians as keahlian_utama', 'm_mahasiswas.keahlian_id', '=', 'keahlian_utama.id')
            ->leftJoin('t_keahlian_mahasiswas', 'm_mahasiswas.id', '=', 't_keahlian_mahasiswas.mahasiswa_id')
            ->leftJoin('m_penghargaans', 'm_mahasiswas.id', '=', 'm_penghargaans.mahasiswa_id')
            ->where('m_mahasiswas.mahasiswa_visible', true)
            ->groupBy([
                'm_mahasiswas.id',
                'm_mahasiswas.mahasiswa_nama',
                'm_mahasiswas.mahasiswa_nim',
                'm_mahasiswas.mahasiswa_score',
                'm_mahasiswas.keahlian_id',
                'keahlian_utama.keahlian_nama',
                'm_mahasiswas.mahasiswa_nomor_telepon',
                'm_mahasiswas.mahasiswa_photo',
                'm_mahasiswas.mahasiswa_angkatan'
            ])
            ->get();
    }

    public function kirimRekomendasi(Request $request)
    {
        try {
            $mahasiswaId = $request->mahasiswa_id;
            $lombaId = $request->lomba_id;
            $rekomendasiData = $request->rekomendasi_data;

            $mahasiswa = Mahasiswa::with('user')->findOrFail($mahasiswaId);
            $lomba = Lomba::findOrFail($lombaId);

            // Prepare other qualified students data with additional info
            $otherQualifiedStudents = [];
            foreach ($rekomendasiData as $item) {
                if ($item['mahasiswa']['id'] != $mahasiswaId) {
                    $otherQualifiedStudents[] = [
                        'ranking' => $item['ranking'],
                        'nama' => $item['mahasiswa']['nama'] ?? 'Nama tidak tersedia',
                        'nim' => $item['mahasiswa']['nim'] ?? 'NIM tidak tersedia',
                        'nomor_telepon' => $item['mahasiswa']['mahasiswa_nomor_telepon'] ?? 'Tidak tersedia',
                        'photo' => $item['mahasiswa']['mahasiswa_photo'] ?? 'default-avatar.png',
                        'angkatan' => $item['mahasiswa']['mahasiswa_angkatan'] ?? 'Tidak tersedia',
                        'skor_preferensi' => number_format($item['skor_preferensi'], 4),
                        'keahlian_utama' => $item['mahasiswa']['keahlian_utama'] ?? 'Tidak ada'
                    ];
                }
            }

            // Find current student's ranking
            $currentStudentRanking = null;
            foreach ($rekomendasiData as $item) {
                if ($item['mahasiswa']['id'] == $mahasiswaId) {
                    $currentStudentRanking = $item['ranking'];
                    break;
                }
            }

            // Create detailed notification message
            $notificationMessage = "Anda direkomendasikan untuk mengikuti lomba '{$lomba->lomba_nama}' (Ranking #{$currentStudentRanking}). " .
                "Total " . count($rekomendasiData) . " mahasiswa direkomendasikan untuk lomba ini.";

            // Prepare notification data
            $notificationData = [
                'lomba_id' => $lombaId,
                'lomba_nama' => $lomba->lomba_nama,
                'ranking' => $currentStudentRanking,
                'total_recommended' => count($rekomendasiData),
                'other_qualified' => $otherQualifiedStudents,
                'lomba_details' => [
                    'penyelenggara' => $lomba->lomba_penyelenggara,
                    'tanggal_mulai' => $lomba->lomba_tanggal_mulai,
                    'tanggal_selesai' => $lomba->lomba_tanggal_selesai,
                    'link_pendaftaran' => $lomba->lomba_link_pendaftaran
                ]
            ];

            // Check if mahasiswa has user_id
            if (!$mahasiswa->user_id) {
                return response()->json([
                    'success' => false,
                    'message' => 'Mahasiswa tidak memiliki akun user yang terhubung.'
                ], 400);
            }

            // Create notification using the existing createNotification function
            createNotification(
                $mahasiswa->user_id,
                'Rekomendasi Lomba',
                $notificationMessage,
                route('mahasiswa.rekomendasi.index'),
                'fas fa-trophy',
                'bg-success',
                $lombaId,
                'Rekomendasi Lomba',
                $notificationData
            );

            return response()->json([
                'success' => true,
                'message' => 'Rekomendasi berhasil dikirim ke mahasiswa!',
                'data' => [
                    'other_qualified_students' => $otherQualifiedStudents,
                    'current_student_ranking' => $currentStudentRanking,
                    'total_recommended' => count($rekomendasiData)
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }

    public function kirimRekomendasiSaw(Request $request)
    {
        try {
            $mahasiswaId = $request->mahasiswa_id;
            $lombaId = $request->lomba_id;
            $rekomendasiData = $request->rekomendasi_data;

            $mahasiswa = Mahasiswa::with('user')->findOrFail($mahasiswaId);
            $lomba = Lomba::findOrFail($lombaId);

            // Prepare other qualified students data for SAW with additional info
            $otherQualifiedStudents = [];
            $currentStudentRanking = null;

            foreach ($rekomendasiData as $index => $item) {
                $ranking = $index + 1;

                if ($item['mahasiswa']['id'] == $mahasiswaId) {
                    $currentStudentRanking = $ranking;
                } else {
                    $otherQualifiedStudents[] = [
                        'ranking' => $ranking,
                        'nama' => $item['mahasiswa']['nama'] ?? 'Nama tidak tersedia',
                        'nim' => $item['mahasiswa']['nim'] ?? 'NIM tidak tersedia',
                        'nomor_telepon' => $item['mahasiswa']['mahasiswa_nomor_telepon'] ?? 'Tidak tersedia',
                        'photo' => $item['mahasiswa']['mahasiswa_photo'] ?? 'default-avatar.png',
                        'angkatan' => $item['mahasiswa']['mahasiswa_angkatan'] ?? 'Tidak tersedia',
                        'skor_preferensi' => number_format($item['skor_preferensi'], 4),
                        'keahlian_utama' => $item['mahasiswa']['keahlian_utama'] ?? 'Tidak ada'
                    ];
                }
            }

            // Create detailed notification message
            $notificationMessage = "Anda direkomendasikan untuk mengikuti lomba '{$lomba->lomba_nama}' (Ranking #{$currentStudentRanking}). " .
                "Total " . count($rekomendasiData) . " mahasiswa direkomendasikan untuk lomba ini.";

            // Prepare notification data
            $notificationData = [
                'lomba_id' => $lombaId,
                'lomba_nama' => $lomba->lomba_nama,
                'ranking' => $currentStudentRanking,
                'total_recommended' => count($rekomendasiData),
                'other_qualified' => $otherQualifiedStudents,
                'lomba_details' => [
                    'penyelenggara' => $lomba->lomba_penyelenggara,
                    'tanggal_mulai' => $lomba->lomba_tanggal_mulai,
                    'tanggal_selesai' => $lomba->lomba_tanggal_selesai,
                    'link_pendaftaran' => $lomba->lomba_link_pendaftaran
                ]
            ];

            // Check if mahasiswa has user_id
            if (!$mahasiswa->user_id) {
                return response()->json([
                    'success' => false,
                    'message' => 'Mahasiswa tidak memiliki akun user yang terhubung.'
                ], 400);
            }

            // Create notification
            createNotification(
                $mahasiswa->user_id,
                'Rekomendasi Lomba (SAW)',
                $notificationMessage,
                route('mahasiswa.rekomendasi.index'),
                'fas fa-trophy',
                'bg-success',
                $lombaId,
                'Rekomendasi Lomba (SAW)',
                $notificationData  
            );

            return response()->json([
                'success' => true,
                'message' => 'Rekomendasi berhasil dikirim ke mahasiswa!'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
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
