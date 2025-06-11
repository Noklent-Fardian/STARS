<?php

namespace App\Http\Controllers;

use App\Models\Dosen;
use App\Models\Keahlian;
use App\Models\KeahlianDosen;
use App\Models\Prodi;
use App\Models\CompetitionSubmission;
use App\Models\Verifikasi;
use App\Models\Mahasiswa;
use App\Models\Bimbingan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;

class DosenController extends Controller
{
    public function index()
    {
        $dosen = Auth::user()->dosen;

        // Get mahasiswa bimbingan through verifikasi records
        $mahasiswaBimbingan = Mahasiswa::whereHas('verifikasis', function ($query) use ($dosen) {
            $query->where('dosen_id', $dosen->id);
        })
            ->with([
                'prodi',
                'verifikasis' => function ($query) use ($dosen) {
                    $query->where('dosen_id', $dosen->id);
                }
            ])
            ->where('mahasiswa_visible', true)
            ->get();

        // Calculate overall ranking among all dosen
        $overallRank = DB::table('m_dosens')
            ->where('dosen_visible', true)
            ->where('dosen_score', '>', $dosen->dosen_score)
            ->count() + 1;

        $totalDosen = DB::table('m_dosens')
            ->where('dosen_visible', true)
            ->count();

        // Get dosen statistics
        $stats = [
            'total_mahasiswa_bimbingan' => $mahasiswaBimbingan->count(),
            'total_prestasi_bimbingan' => Verifikasi::where('dosen_id', $dosen->id)
                ->whereHas('penghargaan.lomba', function ($query) {
                    $query->where('lomba_terverifikasi', 1);
                })
                ->count(),
            'verified_prestasi' => Verifikasi::where('dosen_id', $dosen->id)
                ->where('verifikasi_dosen_status', 'Diterima')
                ->where('verifikasi_admin_status', 'Diterima')
                ->whereHas('penghargaan.lomba', function ($query) {
                    $query->where('lomba_terverifikasi', 1);
                })
                ->count(),
            'pending_prestasi' => Verifikasi::where('dosen_id', $dosen->id)
                ->where('verifikasi_dosen_status', 'Menunggu')
                ->whereHas('penghargaan.lomba', function ($query) {
                    $query->where('lomba_terverifikasi', 1);
                })
                ->count(),
            'total_lomba_submissions' => CompetitionSubmission::where('dosen_id', $dosen->id)->count(),
            'approved_lomba_submissions' => CompetitionSubmission::where('dosen_id', $dosen->id)
                ->where('pendaftaran_status', 'Diterima')
                ->count(),
            'current_score' => $dosen->dosen_score ?? 0,
            'overall_rank' => $overallRank,
            'total_dosen' => $totalDosen,
        ];

        // Get recent prestasi verifications
        $recentPrestasi = Verifikasi::with(['mahasiswa', 'penghargaan.lomba.tingkatan', 'penghargaan.peringkat'])
            ->where('dosen_id', $dosen->id)
            ->whereHas('penghargaan.lomba', function ($query) {
                $query->where('lomba_terverifikasi', 1);
            })
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        // Get recent lomba submissions
        $recentLombaSubmissions = CompetitionSubmission::with(['lomba.tingkatan'])
            ->where('dosen_id', $dosen->id)
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        // Get ranking comparison data for chart
        $rankingData = $this->getRankingComparisonData($dosen);

        // Get yearly score data for the dosen
        $yearlyScoreData = $this->getYearlyScoreData($dosen);

        return view('dosbim.index', compact(
            'dosen',
            'mahasiswaBimbingan',
            'stats',
            'recentPrestasi',
            'recentLombaSubmissions',
            'rankingData',
            'yearlyScoreData'
        ));
    }

    /**
     * Get yearly score data for charts
     */
    private function getYearlyScoreData($dosen)
    {
        // Get scores by year for this dosen
        $yearlyScores = DB::table('t_verifikasis')
            ->join('m_penghargaans', 't_verifikasis.penghargaan_id', '=', 'm_penghargaans.id')
            ->join('m_lombas', 'm_penghargaans.lomba_id', '=', 'm_lombas.id')
            ->where('t_verifikasis.dosen_id', $dosen->id)
            ->where('t_verifikasis.verifikasi_admin_status', 'Diterima')
            ->where('t_verifikasis.verifikasi_dosen_status', 'Diterima')
            ->where('m_lombas.lomba_terverifikasi', 1)
            ->whereNotNull('t_verifikasis.verifikasi_verified_at')
            ->selectRaw('YEAR(t_verifikasis.verifikasi_verified_at) as year, SUM(m_penghargaans.penghargaan_score) as total_score')
            ->groupBy(DB::raw('YEAR(t_verifikasis.verifikasi_verified_at)'))
            ->orderBy('year')
            ->get();

        // Generate last 5 years data
        $currentYear = now()->year;
        $years = [];
        $scores = [];

        for ($i = 4; $i >= 0; $i--) {
            $year = $currentYear - $i;
            $years[] = $year;

            $yearScore = $yearlyScores->firstWhere('year', $year);
            $scores[] = $yearScore ? floatval($yearScore->total_score) : 0;
        }

        return [
            'years' => $years,
            'scores' => $scores
        ];
    }

    /**
     * Get ranking comparison data for charts
     */
    private function getRankingComparisonData($dosen)
    {
        // Get top 10 dosen for comparison
        $topDosen = DB::table('m_dosens')
            ->select('dosen_nama', 'dosen_score', 'dosen_nip')
            ->where('dosen_visible', true)
            ->orderBy('dosen_score', 'desc')
            ->limit(10)
            ->get();

        return [
            'top_dosen' => $topDosen,
            'current_dosen' => [
                'nama' => $dosen->dosen_nama,
                'nip' => $dosen->dosen_nip,
                'score' => $dosen->dosen_score
            ]
        ];
    }

    public function profile()
    {
        $dosen = Auth::user()->dosen->load(['keahlianUtama', 'keahlianTambahan']);
        return view('dosbim.profile.index', compact('dosen'));
    }

    public function editProfile()
    {
        $dosen = Auth::user()->dosen;
        $prodis = Prodi::all();
        $keahlians = Keahlian::all();
        return view('dosbim.profile.edit', compact('dosen', 'prodis', 'keahlians'));
    }
    public function updateProfile(Request $request)
    {
        $dosen = Auth::user()->dosen;

        $validated = $request->validate([
            'dosen_nomor_telepon' => 'nullable|string|max:20',
            'keahlian_id' => 'required|exists:m_keahlians,id',
            'keahlian_tambahan' => 'array',
            'keahlian_tambahan.*' => 'exists:m_keahlians,id',
            'dosen_provinsi' => 'nullable|string|max:100',
            'dosen_kota' => 'nullable|string|max:100',
            'dosen_kecamatan' => 'nullable|string|max:100',
            'dosen_desa' => 'nullable|string|max:100',
            'dosen_provinsi_text' => 'nullable|string|max:100',
            'dosen_kota_text' => 'nullable|string|max:100',
            'dosen_kecamatan_text' => 'nullable|string|max:100',
            'dosen_desa_text' => 'nullable|string|max:100',
            'dosen_photo' => 'nullable|image|mimes:jpeg,jpg,png,webp|max:2048',
            'keahlian_sertifikat' => 'nullable|url',
            'keahlian_sertifikat_tambahan' => 'array',
            'keahlian_sertifikat_tambahan.*' => 'nullable|url',
        ]);

        try {
            if ($request->hasFile('dosen_photo')) {
                $file = $request->file('dosen_photo');
                $path = $file->store('dosen_photo', 'public');
                $validated['dosen_photo'] = $path;
            }

            $dosen->update([
                'dosen_nomor_telepon' => $validated['dosen_nomor_telepon'] ?? null,
                'keahlian_id' => $validated['keahlian_id'],
                'keahlian_sertifikat' => $validated['keahlian_sertifikat'] ?? null,
                'dosen_provinsi' => $request->dosen_provinsi,
                'dosen_kota' => $request->dosen_kota,
                'dosen_kecamatan' => $request->dosen_kecamatan,
                'dosen_desa' => $request->dosen_desa,
                'dosen_provinsi_text' => $request->dosen_provinsi_text,
                'dosen_kota_text' => $request->dosen_kota_text,
                'dosen_kecamatan_text' => $request->dosen_kecamatan_text,
                'dosen_desa_text' => $request->dosen_desa_text,
                'dosen_photo' => $validated['dosen_photo'] ?? $dosen->dosen_photo,
            ]);

            $keahlianTambahan = $validated['keahlian_tambahan'] ?? [];
            $sertifikatTambahan = $validated['keahlian_sertifikat_tambahan'] ?? [];
            $pivotData = [];
            foreach ($keahlianTambahan as $kid) {
                $pivotData[$kid] = [
                    'keahlian_sertifikat' => $sertifikatTambahan[$kid] ?? null
                ];
            }
            $dosen->keahlianTambahan()->sync($pivotData);

            if ($request->ajax()) {
                return response()->json(['message' => 'Profil berhasil diperbarui.']);
            }
            return redirect()->route('dosen.profile')->with('success', 'Profil berhasil diperbarui.');
        } catch (\Exception $e) {
            if ($request->ajax()) {
                return response()->json(['message' => 'Profil gagal diperbarui.'], 500);
            }
            return redirect()->back()->withErrors(['error' => 'Profil gagal diperbarui.']);
        }
    }
    public function updatePassword(Request $request)
    {
        $request->validate([
            'password' => 'required|string|min:6|confirmed',
        ]);

        $user = Auth::user();
        $user->user_password = bcrypt($request->password);
        $user->save();

        if ($request->ajax()) {
            return response()->json(['message' => 'Password berhasil diubah.']);
        }

        return redirect()->route('dosen.profile')->with('success', 'Password berhasil diubah.');
    }

    public function updatePhoto(Request $request)
    {
        $messages = [
            'dosen_photo.required' => 'Silakan pilih foto terlebih dahulu.',
            'dosen_photo.image' => 'File harus berupa gambar.',
            'dosen_photo.mimes' => 'Format foto harus jpeg, jpg, png, atau webp.',
            'dosen_photo.max' => 'Ukuran foto tidak boleh lebih dari 2MB.',
        ];

        $validator = Validator::make($request->all(), [
            'dosen_photo' => 'required|image|mimes:jpeg,jpg,png,webp|max:2048',
        ], $messages);

        if ($validator->fails()) {
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => $validator->errors()->first(),
                ], 422);
            }
            return redirect()->back()->with('error', $validator->errors()->first());
        }

        $dosen = Auth::user()->dosen;

        // Delete old photo if exists
        if ($dosen->dosen_photo && Storage::disk('public')->exists($dosen->dosen_photo)) {
            Storage::disk('public')->delete($dosen->dosen_photo);
        }

        try {
            if ($request->hasFile('dosen_photo')) {
                $file = $request->file('dosen_photo');
                $path = $file->store('dosen_photos', 'public');
                $dosen->dosen_photo = $path;
                $dosen->save();
            }

            if ($request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Foto profil berhasil diubah.',
                    'photo_url' => asset('storage/' . $dosen->dosen_photo)
                ]);
            }

            return redirect()->back()->with('success', 'Foto profil berhasil diubah.');
        } catch (\Exception $e) {
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Terjadi kesalahan saat mengunggah foto. Silakan coba lagi.',
                ], 500);
            }
            return redirect()->back()->with('error', 'Terjadi kesalahan saat mengunggah foto.');
        }
    }


    public function riwayatPengajuanLombaIndex()
    {
        return view('dosbim.riwayatPengajuanLomba.index');
    }

    public function riwayatPengajuanLombaList(Request $request)
    {
        $dosen = Auth::user()->dosen;

        $submissions = CompetitionSubmission::with(['lomba.tingkatan', 'lomba.keahlians'])
            ->where('dosen_id', $dosen->id)
            ->select('*');

        if ($request->status && $request->status != '') {
            $submissions->where('pendaftaran_status', $request->status);
        }

        return DataTables::of($submissions)
            ->addIndexColumn()
            ->addColumn('aksi', function ($row) {
                return '<a href="' . route('dosen.riwayatPengajuanLomba.show', $row->id) . '" 
                           class="btn btn-info btn-sm" 
                           title="Lihat Detail">
                            <i class="fas fa-eye">Detail</i>
                        </a>';
            })
            ->editColumn('pendaftaran_status', function ($row) {
                if ($row->pendaftaran_status === 'Menunggu') {
                    return '<span class="badge badge-warning"><i class="fas fa-clock mr-1"></i> Menunggu</span>';
                } elseif ($row->pendaftaran_status === 'Diterima') {
                    return '<span class="badge badge-success"><i class="fas fa-check mr-1"></i> Diterima</span>';
                } else {
                    return '<span class="badge badge-danger"><i class="fas fa-times mr-1"></i> Ditolak</span>';
                }
            })
            ->with([
                'statistics' => [
                    'pending' => CompetitionSubmission::where('dosen_id', $dosen->id)->where('pendaftaran_status', 'Menunggu')->count(),
                    'approved' => CompetitionSubmission::where('dosen_id', $dosen->id)->where('pendaftaran_status', 'Diterima')->count(),
                    'rejected' => CompetitionSubmission::where('dosen_id', $dosen->id)->where('pendaftaran_status', 'Ditolak')->count(),
                    'total' => CompetitionSubmission::where('dosen_id', $dosen->id)->count(),
                ]
            ])
            ->rawColumns(['aksi', 'pendaftaran_status'])
            ->make(true);
    }

    public function riwayatPengajuanLombaShow($id)
    {
        $dosen = Auth::user()->dosen;
        $submission = CompetitionSubmission::with(['lomba.tingkatan', 'lomba.keahlians', 'lomba.semester'])
            ->where('dosen_id', $dosen->id)
            ->findOrFail($id);

        return view('dosbim.riwayatPengajuanLomba.show', compact('submission'));
    }
}
