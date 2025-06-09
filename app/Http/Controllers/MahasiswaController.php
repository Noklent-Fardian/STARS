<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use App\Models\CompetitionSubmission;
use App\Models\Verifikasi;
use Yajra\DataTables\Facades\DataTables;
use App\Models\Prodi;
use App\Models\Keahlian;
use App\Models\Lomba;


class MahasiswaController extends Controller
{
    /**
     * Display mahasiswa dashboard.
     */
    public function index()
    {
        $mahasiswa = Auth::user()->mahasiswa->load(['prodi', 'keahlianUtama', 'keahlianTambahan']);

        // Calculate overall ranking
        $overallRank = DB::table('m_mahasiswas')
            ->where('mahasiswa_visible', true)
            ->where('mahasiswa_score', '>', $mahasiswa->mahasiswa_score)
            ->count() + 1;

        $totalMahasiswa = DB::table('m_mahasiswas')
            ->where('mahasiswa_visible', true)
            ->count();

        // Calculate ranking in angkatan (year)
        $angkatanRank = DB::table('m_mahasiswas')
            ->where('mahasiswa_visible', true)
            ->where('mahasiswa_angkatan', $mahasiswa->mahasiswa_angkatan)
            ->where('mahasiswa_score', '>', $mahasiswa->mahasiswa_score)
            ->count() + 1;

        $totalMahasiswaAngkatan = DB::table('m_mahasiswas')
            ->where('mahasiswa_visible', true)
            ->where('mahasiswa_angkatan', $mahasiswa->mahasiswa_angkatan)
            ->count();

        // Get mahasiswa statistics
        $stats = [
            'total_prestasi' => Verifikasi::where('mahasiswa_id', $mahasiswa->id)->count(),
            'verified_prestasi' => Verifikasi::where('mahasiswa_id', $mahasiswa->id)
                ->where('verifikasi_admin_status', 'Diterima')
                ->where('verifikasi_dosen_status', 'Diterima')
                ->count(),
            'pending_prestasi' => Verifikasi::where('mahasiswa_id', $mahasiswa->id)
                ->where(function ($query) {
                    $query->where('verifikasi_admin_status', 'Menunggu')
                        ->orWhere('verifikasi_dosen_status', 'Menunggu');
                })
                ->count(),
            'total_lomba_submissions' => CompetitionSubmission::where('mahasiswa_id', $mahasiswa->id)->count(),
            'approved_lomba_submissions' => CompetitionSubmission::where('mahasiswa_id', $mahasiswa->id)
                ->where('pendaftaran_status', 'Diterima')
                ->count(),
            'current_score' => $mahasiswa->mahasiswa_score ?? 0,
            'overall_rank' => $overallRank,
            'total_mahasiswa' => $totalMahasiswa,
            'angkatan_rank' => $angkatanRank,
            'total_mahasiswa_angkatan' => $totalMahasiswaAngkatan,
        ];

        // Get recent activities (prestasi)
        $recentPrestasi = Verifikasi::with(['penghargaan.lomba.tingkatan', 'penghargaan.peringkat'])
            ->where('mahasiswa_id', $mahasiswa->id)
            ->whereHas('penghargaan.lomba', function ($query) {
                $query->where('lomba_terverifikasi', 1);
            })
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        // Get recent lomba submissions
        $recentLombaSubmissions = CompetitionSubmission::with(['lomba.tingkatan'])
            ->where('mahasiswa_id', $mahasiswa->id)
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        // Get ranking comparison data for chart
        $rankingData = $this->getRankingComparisonData($mahasiswa);

        // Get yearly score data for the student
        $yearlyScoreData = $this->getYearlyScoreData($mahasiswa);

        return view('mahasiswa.index', compact(
            'mahasiswa',
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
    private function getYearlyScoreData($mahasiswa)
    {
        // Get scores by year for this mahasiswa
        $yearlyScores = DB::table('t_verifikasis')
            ->join('m_penghargaans', 't_verifikasis.penghargaan_id', '=', 'm_penghargaans.id')
            ->join('m_lombas', 'm_penghargaans.lomba_id', '=', 'm_lombas.id')
            ->where('t_verifikasis.mahasiswa_id', $mahasiswa->id)
            ->where('t_verifikasis.verifikasi_admin_status', 'Diterima')
            ->where('t_verifikasis.verifikasi_dosen_status', 'Diterima')
            ->where('m_lombas.lomba_terverifikasi', 1)
            ->whereNotNull('t_verifikasis.verifikasi_verified_at')
            ->selectRaw('YEAR(t_verifikasis.verifikasi_verified_at) as year, SUM(m_penghargaans.penghargaan_score) as total_score')
            ->groupBy(DB::raw('YEAR(t_verifikasis.verifikasi_verified_at)'))  // Fixed this line
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
    private function getRankingComparisonData($mahasiswa)
    {
        // Get top 10 students for comparison
        $topStudents = DB::table('m_mahasiswas')
            ->select('mahasiswa_nama', 'mahasiswa_score', 'mahasiswa_nim')
            ->where('mahasiswa_visible', true)
            ->orderBy('mahasiswa_score', 'desc')
            ->limit(10)
            ->get();

        // Get students in same angkatan
        $angkatanStudents = DB::table('m_mahasiswas')
            ->select('mahasiswa_nama', 'mahasiswa_score', 'mahasiswa_nim')
            ->where('mahasiswa_visible', true)
            ->where('mahasiswa_angkatan', $mahasiswa->mahasiswa_angkatan)
            ->orderBy('mahasiswa_score', 'desc')
            ->limit(10)
            ->get();

        return [
            'top_students' => $topStudents,
            'angkatan_students' => $angkatanStudents,
            'current_student' => [
                'nama' => $mahasiswa->mahasiswa_nama,
                'nim' => $mahasiswa->mahasiswa_nim,
                'score' => $mahasiswa->mahasiswa_score
            ]
        ];
    }

    public function profile()
    {
        $mahasiswa = Auth::user()->mahasiswa->load(['keahlianUtama', 'keahlianTambahan']);
        return view('mahasiswa.profile.index', compact('mahasiswa'));
    }

    public function editProfile()
    {
        $mahasiswa = Auth::user()->mahasiswa;
        // Ambil data prodi dan keahlian untuk dropdown
        $prodis =  Prodi::all();
        $keahlians =  Keahlian::all();
        return view('mahasiswa.profile.edit', compact('mahasiswa', 'prodis', 'keahlians'));
    }

    public function updateProfile(Request $request)
    {
        $mahasiswa = Auth::user()->mahasiswa;

        $validated = $request->validate([
            'mahasiswa_nomor_telepon' => 'nullable|string|max:20',
            'keahlian_id' => 'required|exists:m_keahlians,id',
            'keahlian_tambahan' => 'array',
            'keahlian_tambahan.*' => 'exists:m_keahlians,id',
            'mahasiswa_provinsi' => 'nullable|string|max:100',
            'mahasiswa_kota' => 'nullable|string|max:100',
            'mahasiswa_kecamatan' => 'nullable|string|max:100',
            'mahasiswa_desa' => 'nullable|string|max:100',
            'profile_picture' => 'nullable|image|mimes:jpeg,jpg,png,webp|max:2048',
            'keahlian_sertifikat' => 'nullable|url',
            'keahlian_sertifikat_tambahan' => 'array',
            'keahlian_sertifikat_tambahan.*' => 'nullable|url',
        ]);

        try {
            if ($request->hasFile('profile_picture')) {
                $file = $request->file('profile_picture');
                $path = $file->store('mahasiswa_photos', 'public');
                $validated['mahasiswa_photo'] = $path;
            }

            // Update keahlian utama, sertifikat utama, dan field lain
            $mahasiswa->update([
                'mahasiswa_nomor_telepon' => $validated['mahasiswa_nomor_telepon'] ?? null,
                'keahlian_id' => $validated['keahlian_id'],
                'keahlian_sertifikat' => $validated['keahlian_sertifikat'] ?? null,
                'mahasiswa_provinsi' => $validated['mahasiswa_provinsi'] ?? null,
                'mahasiswa_kota' => $validated['mahasiswa_kota'] ?? null,
                'mahasiswa_kecamatan' => $validated['mahasiswa_kecamatan'] ?? null,
                'mahasiswa_desa' => $validated['mahasiswa_desa'] ?? null,
                'mahasiswa_photo' => $validated['mahasiswa_photo'] ?? $mahasiswa->mahasiswa_photo,
            ]);

            // Update keahlian tambahan (many-to-many) beserta sertifikatnya
            $keahlianTambahan = $validated['keahlian_tambahan'] ?? [];
            $sertifikatTambahan = $validated['keahlian_sertifikat_tambahan'] ?? [];
            $pivotData = [];
            foreach ($keahlianTambahan as $kid) {
                $pivotData[$kid] = [
                    'keahlian_sertifikat' => $sertifikatTambahan[$kid] ?? null
                ];
            }
            $mahasiswa->keahlianTambahan()->sync($pivotData);

            if ($request->ajax()) {
                return response()->json(['message' => 'Profil berhasil diperbarui.']);
            }
            return redirect()->route('mahasiswa.profile')->with('success', 'Profil berhasil diperbarui.');
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

        return redirect()->route('mahasiswa.profile')->with('success', 'Password berhasil diubah.');
    }

    public function changePassword(Request $request)
    {
        $messages = [
            'current_password.required' => 'Kata sandi saat ini diperlukan.',
            'new_password.required'     => 'Kata sandi baru diperlukan.',
            'new_password.min'          => 'Kata sandi baru minimal 6 karakter.',
            'confirm_password.required' => 'Konfirmasi kata sandi diperlukan.',
            'confirm_password.same'     => 'Konfirmasi kata sandi baru tidak cocok.',
        ];

        $validator = Validator::make($request->all(), [
            'current_password' => 'required',
            'new_password'     => 'required|min:6',
            'confirm_password' => 'required|same:new_password',
        ], $messages);

        if ($validator->fails()) {
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'errors'  => $validator->errors(),
                    'message' => $validator->errors()->first(),
                ], 422);
            }

            return redirect()->route('mahasiswa.profile')
                ->with('error', $validator->errors()->first())
                ->withErrors($validator);
        }

        $user = Auth::user();

        // Check if current password matches
        if (!password_verify($request->current_password, $user->user_password)) {
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'errors'  => [
                        'current_password' => ['Kata sandi saat ini tidak valid.'],
                    ],
                    'message' => 'Kata sandi saat ini tidak valid.',
                ], 422);
            }

            return redirect()->route('mahasiswa.profile')
                ->with('error', 'Kata sandi saat ini tidak valid.');
        }

        try {
            DB::table('m_users')
                ->where('id', $user->id)
                ->update(['user_password' => bcrypt($request->new_password)]);

            if ($request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Kata sandi berhasil diubah.',
                ]);
            }

            return redirect()->route('mahasiswa.profile')
                ->with('success', 'Kata sandi berhasil diubah.');
        } catch (\Exception $e) {
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Terjadi kesalahan saat mengubah kata sandi. Silakan coba lagi.',
                ], 500);
            }

            return redirect()->route('mahasiswa.profile')
                ->with('error', 'Terjadi kesalahan saat mengubah kata sandi. Silakan coba lagi.');
        }
    }

    public function updatePhoto(Request $request)
    {
        $messages = [
            'profile_picture.required' => 'Silakan pilih foto terlebih dahulu.',
            'profile_picture.image'    => 'File harus berupa gambar.',
            'profile_picture.mimes'    => 'Format foto harus jpeg, jpg, png, atau webp.',
            'profile_picture.max'      => 'Ukuran foto tidak boleh lebih dari 2MB.',
        ];

        $validator = Validator::make($request->all(), [
            'profile_picture' => 'required|image|mimes:jpeg,jpg,png,webp|max:2048',
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

        $mahasiswa = Auth::user()->mahasiswa;

        // Delete old photo if exists
        if ($mahasiswa->mahasiswa_photo && Storage::disk('public')->exists($mahasiswa->mahasiswa_photo)) {
            Storage::disk('public')->delete($mahasiswa->mahasiswa_photo);
        }

        try {
            if ($request->hasFile('profile_picture')) {
                $file = $request->file('profile_picture');
                $path = $file->store('mahasiswa_photos', 'public');
                $mahasiswa->mahasiswa_photo = $path;
                $mahasiswa->save();
            }

            if ($request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Foto profil berhasil diubah.',
                    'photo_url' => asset('storage/' . $mahasiswa->mahasiswa_photo)
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



    public function lombaShow($id)
    {
        $lomba =  Lomba::with(['tingkatan', 'semester', 'keahlians'])
            ->where('lomba_visible', true)
            ->findOrFail($id);

        return view('mahasiswa.lomba.show', compact('lomba'));
    }

    public function riwayatPengajuanLombaIndex()
    {
        return view('mahasiswa.riwayatPengajuanLomba.index');
    }

    public function riwayatPengajuanLombaList(Request $request)
    {
        $mahasiswa = Auth::user()->mahasiswa;

        $submissions = CompetitionSubmission::with(['lomba.tingkatan', 'lomba.keahlians'])
            ->where('mahasiswa_id', $mahasiswa->id)
            ->select('*');

        if ($request->status && $request->status != '') {
            $submissions->where('pendaftaran_status', $request->status);
        }

        return DataTables::of($submissions)
            ->addIndexColumn()
            ->addColumn('aksi', function ($row) {
                return '<a href="' . route('mahasiswa.riwayatPengajuanLomba.show', $row->id) . '" 
                           class="btn btn-info btn-sm" 
                           title="Lihat Detail">
                            <i class="fas fa-eye"> Detail</i>
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
                    'pending' => CompetitionSubmission::where('mahasiswa_id', $mahasiswa->id)->where('pendaftaran_status', 'Menunggu')->count(),
                    'approved' => CompetitionSubmission::where('mahasiswa_id', $mahasiswa->id)->where('pendaftaran_status', 'Diterima')->count(),
                    'rejected' => CompetitionSubmission::where('mahasiswa_id', $mahasiswa->id)->where('pendaftaran_status', 'Ditolak')->count(),
                    'total' => CompetitionSubmission::where('mahasiswa_id', $mahasiswa->id)->count(),
                ]
            ])
            ->rawColumns(['aksi', 'pendaftaran_status'])
            ->make(true);
    }

    public function riwayatPengajuanLombaShow($id)
    {
        $mahasiswa = Auth::user()->mahasiswa;
        $submission = CompetitionSubmission::with(['lomba.tingkatan', 'lomba.keahlians', 'lomba.semester'])
            ->where('mahasiswa_id', $mahasiswa->id)
            ->findOrFail($id);

        return view('mahasiswa.riwayatPengajuanLomba.show', compact('submission'));
    }

    public function riwayatPengajuanPrestasiIndex()
    {
        return view('mahasiswa.riwayatPengajuanPrestasi.index');
    }

    public function riwayatPengajuanPrestasiList(Request $request)
    {
        $mahasiswa = Auth::user()->mahasiswa;

        $verifikasis = Verifikasi::with(['penghargaan.lomba.tingkatan', 'penghargaan.peringkat', 'dosen', 'admin'])
            ->where('mahasiswa_id', $mahasiswa->id)
            ->select('*');

        // Filter by dosen verification status
        if ($request->status_dosen && $request->status_dosen != '') {
            $verifikasis->where('verifikasi_dosen_status', $request->status_dosen);
        }

        // Filter by admin verification status
        if ($request->status_admin && $request->status_admin != '') {
            $verifikasis->where('verifikasi_admin_status', $request->status_admin);
        }

        return DataTables::of($verifikasis)
            ->addIndexColumn()
            ->addColumn('prestasi_nama', function ($row) {
                return $row->penghargaan->penghargaan_judul ?? 'N/A';
            })
            ->addColumn('lomba_nama', function ($row) {
                return $row->penghargaan->lomba->lomba_nama ?? 'N/A';
            })
            ->addColumn('peringkat', function ($row) {
                return $row->penghargaan->peringkat->peringkat_nama ?? 'N/A';
            })
            ->addColumn('tingkatan', function ($row) {
                return $row->penghargaan->lomba->tingkatan->tingkatan_nama ?? 'N/A';
            })
            ->addColumn('status_verifikasi_dosen', function ($row) {
                $dosenStatus = $row->verifikasi_dosen_status;

                if ($dosenStatus === 'Ditolak') {
                    return '<span class="badge badge-danger"><i class="fas fa-times mr-1"></i> Ditolak</span>';
                } elseif ($dosenStatus === 'Diterima') {
                    return '<span class="badge badge-success"><i class="fas fa-check mr-1"></i> Diterima</span>';
                } else {
                    return '<span class="badge badge-warning"><i class="fas fa-clock mr-1"></i> Menunggu</span>';
                }
            })
            ->addColumn('status_verifikasi_admin', function ($row) {
                $adminStatus = $row->verifikasi_admin_status;

                if ($adminStatus === 'Ditolak') {
                    return '<span class="badge badge-danger"><i class="fas fa-times mr-1"></i> Ditolak</span>';
                } elseif ($adminStatus === 'Diterima') {
                    return '<span class="badge badge-success"><i class="fas fa-check mr-1"></i> Diterima</span>';
                } else {
                    return '<span class="badge badge-warning"><i class="fas fa-clock mr-1"></i> Menunggu</span>';
                }
            })
            ->addColumn('status_verifikasi_keseluruhan', function ($row) {
                // Overall verification status based on both admin and dosen
                if ($row->verifikasi_admin_status === 'Diterima' && $row->verifikasi_dosen_status === 'Diterima') {
                    return '<span class="badge badge-success"><i class="fas fa-check-double mr-1"></i> Terverifikasi</span>';
                } elseif ($row->verifikasi_admin_status === 'Ditolak' || $row->verifikasi_dosen_status === 'Ditolak') {
                    return '<span class="badge badge-danger"><i class="fas fa-times mr-1"></i> Ditolak</span>';
                } else {
                    return '<span class="badge badge-warning"><i class="fas fa-clock mr-1"></i> Menunggu</span>';
                }
            })
            ->addColumn('prestasi_score', function ($row) {
                return $row->penghargaan->penghargaan_score ?? 0;
            })
            ->addColumn('aksi', function ($row) {
                return '<a href="' . route('mahasiswa.riwayatPengajuanPrestasi.show', $row->id) . '" 
                           class="btn btn-info btn-sm" 
                           title="Lihat Detail">
                            <i class="fas fa-eye"> Detail</i>
                        </a>';
            })
            ->with([
                'statistics' => [
                    'pending' => Verifikasi::where('mahasiswa_id', $mahasiswa->id)
                        ->where(function ($query) {
                            $query->where('verifikasi_admin_status', 'Menunggu')
                                ->orWhere('verifikasi_dosen_status', 'Menunggu');
                        })->count(),
                    'approved' => Verifikasi::where('mahasiswa_id', $mahasiswa->id)
                        ->where('verifikasi_admin_status', 'Diterima')
                        ->where('verifikasi_dosen_status', 'Diterima')->count(),
                    'rejected' => Verifikasi::where('mahasiswa_id', $mahasiswa->id)
                        ->where(function ($query) {
                            $query->where('verifikasi_admin_status', 'Ditolak')
                                ->orWhere('verifikasi_dosen_status', 'Ditolak');
                        })->count(),
                    'total' => Verifikasi::where('mahasiswa_id', $mahasiswa->id)->count(),
                ]
            ])
            ->rawColumns(['aksi', 'status_verifikasi_dosen', 'status_verifikasi_admin'])
            ->make(true);
    }

    public function riwayatPengajuanPrestasiShow($id)
    {
        $mahasiswa = Auth::user()->mahasiswa;
        $verifikasi = Verifikasi::with([
            'penghargaan.lomba.tingkatan',
            'penghargaan.lomba.keahlians',
            'penghargaan.lomba.semester',
            'penghargaan.peringkat',
            'dosen',
            'admin'
        ])
            ->where('mahasiswa_id', $mahasiswa->id)
            ->findOrFail($id);

        return view('mahasiswa.riwayatPengajuanPrestasi.show', compact('verifikasi'));
    }
}
