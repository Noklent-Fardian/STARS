<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\Mahasiswa;
use App\Models\Dosen;
use App\Models\AdminKelolaLomba;
use App\Models\AdminKelolaPrestasi;
use App\Models\CompetitionSubmission;
use App\Models\Verifikasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;


class AdminController extends Controller
{
    private function getYearlyVerificationStatistics()
    {
        $years = [];
        $verifiedData = [];

        // Get data for the last 5 years
        for ($i = 4; $i >= 0; $i--) {
            $year = Carbon::now()->subYears($i)->year;
            $years[] = $year;

            $verifiedCount = Verifikasi::whereYear('created_at', $year)
                ->where('verifikasi_dosen_status', 'Diterima')
                ->where('verifikasi_admin_status', 'Diterima')
                ->whereHas('penghargaan.lomba', function ($query) {
                    $query->where('lomba_terverifikasi', 1);
                })
                ->count();

            $verifiedData[] = $verifiedCount;
        }

        return [
            'years' => $years,
            'verified' => $verifiedData
        ];
    }

    public function index()
    {
        $admin = Auth::user()->admin;

        // Dashboard Statistics
        $stats = [
            'total_mahasiswa' => Mahasiswa::where('mahasiswa_visible', true)->count(),
            'total_dosen' => Dosen::where('dosen_visible', true)->count(),
            'total_admin' => Admin::where('admin_visible', true)->count(),
            'total_lomba' => AdminKelolaLomba::where('lomba_visible', true)->count(),
            'total_prestasi' => AdminKelolaPrestasi::count(),
            'verified_prestasi' => Verifikasi::where('verifikasi_dosen_status', 'Diterima')
                ->where('verifikasi_admin_status', 'Diterima')
                ->whereHas('penghargaan.lomba', function ($query) {
                    $query->where('lomba_terverifikasi', 1);
                })
                ->count(),
            'pending_verifikasi_prestasi' => Verifikasi::where('verifikasi_admin_status', 'Menunggu')->count(),
            'pending_verifikasi_lomba' => CompetitionSubmission::where('pendaftaran_status', 'Menunggu')->count(),
        ];

        // Recent Activities - Fixed null created_at issue
        $recentPrestasi = AdminKelolaPrestasi::with(['mahasiswa', 'lomba', 'peringkat'])
            ->whereNotNull('created_at')
            ->whereHas('verifikasi', function ($query) {
                $query->where('verifikasi_dosen_status', 'Diterima')
                    ->where('verifikasi_admin_status', 'Diterima');
            })
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();

        $recentLomba = AdminKelolaLomba::with(['tingkatan'])
            ->where('lomba_visible', true)
            ->where('lomba_terverifikasi', 1)
            ->whereNotNull('created_at')
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();

        // Monthly Statistics
        $monthlyData = $this->getMonthlyStatistics();

        // Yearly Verification Statistics
        $yearlyVerificationData = $this->getYearlyVerificationStatistics();

        // Prestasi by Tingkatan - Fixed to use proper table names
        $prestasiByTingkatan = DB::table('m_penghargaans')
            ->join('m_lombas', 'm_penghargaans.lomba_id', '=', 'm_lombas.id')
            ->join('m_tingkatans', 'm_lombas.tingkatan_id', '=', 'm_tingkatans.id')
            ->join('t_verifikasis', 'm_penghargaans.id', '=', 't_verifikasis.penghargaan_id')
            ->where('t_verifikasis.verifikasi_admin_status', 'Diterima')
            ->where('t_verifikasis.verifikasi_dosen_status', 'Diterima')
            ->select('m_tingkatans.tingkatan_nama', 'm_tingkatans.id as tingkatan_id', DB::raw('count(*) as total'))
            ->groupBy('m_tingkatans.tingkatan_nama', 'm_tingkatans.id')
            ->orderBy('m_tingkatans.id')
            ->get();

        // Verified Prestasi by Tingkatan - New chart data
        $verifiedPrestasiByTingkatan = DB::table('m_penghargaans')
            ->join('m_lombas', 'm_penghargaans.lomba_id', '=', 'm_lombas.id')
            ->join('m_tingkatans', 'm_lombas.tingkatan_id', '=', 'm_tingkatans.id')
            ->join('t_verifikasis', 'm_penghargaans.id', '=', 't_verifikasis.penghargaan_id')
            ->where('t_verifikasis.verifikasi_admin_status', 'Diterima')
            ->where('t_verifikasis.verifikasi_dosen_status', 'Diterima')
            ->where('m_lombas.lomba_terverifikasi', 1)
            ->select('m_tingkatans.tingkatan_nama', 'm_tingkatans.id as tingkatan_id', DB::raw('count(*) as verified_total'))
            ->groupBy('m_tingkatans.tingkatan_nama', 'm_tingkatans.id')
            ->orderBy('m_tingkatans.id')
            ->get();

        // Quick actions data
        $quickActions = [
            'pending_mahasiswa' => Mahasiswa::where('mahasiswa_visible', false)->count(),
            'pending_dosen' => Dosen::where('dosen_visible', false)->count(),
            'recent_submissions' => CompetitionSubmission::where('pendaftaran_status', 'Menunggu')
                ->whereDate('created_at', '>=', Carbon::today())
                ->count(),
        ];

        return view('admin.index', compact(
            'admin',
            'stats',
            'recentPrestasi',
            'recentLomba',
            'monthlyData',
            'yearlyVerificationData',
            'prestasiByTingkatan',
            'verifiedPrestasiByTingkatan',
            'quickActions'
        ));
    }

    /**
     * Get monthly statistics for charts
     */
    private function getMonthlyStatistics()
    {
        $months = [];
        $lombaData = [];
        $prestasiData = [];

        for ($i = 11; $i >= 0; $i--) {
            $date = Carbon::now()->subMonths($i);
            $months[] = $date->format('M Y');

            $lombaCount = CompetitionSubmission::whereYear('created_at', $date->year)
                ->whereMonth('created_at', $date->month)
                ->where('pendaftaran_status', 'Diterima')
                ->count();
            $lombaData[] = $lombaCount;

            $prestasiCount = Verifikasi::whereYear('created_at', $date->year)
                ->whereMonth('created_at', $date->month)
                ->where('verifikasi_dosen_status', 'Diterima')
                ->where('verifikasi_admin_status', 'Diterima')
                ->whereHas('penghargaan.lomba', function ($query) {
                    $query->where('lomba_terverifikasi', 1);
                })
                ->count();
            $prestasiData[] = $prestasiCount;
        }

        return [
            'months' => $months,
            'lomba' => $lombaData,
            'prestasi' => $prestasiData
        ];
    }

    public function mahasiswaIndex()
    {
        return view('admin.mahasiswaManagement.index');
    }

    public function dosenIndex()
    {
        return view('admin.dosenManagement.index');
    }

    public function adminIndex()
    {
        return redirect()->route('admin.adminManagement.index');
    }

    public function prestasiVerification()
    {
        return view('admin.prestasiVerification.index');
    }

    public function prestasiAkademik()
    {
        return view('admin.prestasi.akademik');
    }

    public function prestasiNonAkademik()
    {
        return view('admin.prestasi.non-akademik');
    }

    public function prestasiIndex()
    {
        return view('admin.adminKelolaPrestasi.index');
    }

    public function prestasiReport()
    {
        return view('admin.prestasi.report');
    }

    public function lombaVerification()
    {
        return view('admin.lombaVerification.index');
    }

    public function lombaIndex()
    {
        return view('admin.adminKelolaLomba.index');
    }

    public function masterPeriode()
    {
        return view('admin.semester.index');
    }

    public function masterProdi()
    {
        return view('admin.master.prodi');
    }
    public function masterKeahlian()
    {
        //return view('admin.master.bidangKeahlian');
        return view('admin.bidangKeahlian.index');
    }
    // tingkatanLomba
    public function masterTingkatanLomba()
    {
        return view('admin.master.tingkatanLomba');
    }
    public function masterPeringkatLomba()
    {
        return view('admin.master.peringkatLomba');
    }

    public function profile()
    {
        $admin = Auth::user()->admin;
        return view('admin.profile.profile', compact('admin'));
    }

    public function editProfile()
    {
        $user  = Auth::user();
        $admin = Admin::where('user_id', $user->id)->first();
        return view('admin.profile.edit_profile', compact('admin'));
    }

    public function updateProfile(Request $request)
    {
        try {
            $user  = Auth::user();
            $admin = Admin::where('user_id', $user->id)->first();

            $data = [
                'admin_name'          => $request->admin_name,
                'admin_nomor_telepon' => $request->admin_nomor_telepon,
                'admin_gender'        => $request->admin_gender,
            ];

            $admin->update($data);

            return redirect()->route('admin.profile')->with('success', 'Profil berhasil diperbarui.');
        } catch (\Exception $e) {
            return redirect()->route('admin.profile')->with('error', 'Terjadi kesalahan saat memperbarui profil. Silakan coba lagi.');
        }
    }

    public function updatePhoto(Request $request)
    {
        $messages = [
            'admin_photo.required' => 'Silakan pilih foto terlebih dahulu.',
            'admin_photo.image'    => 'File harus berupa gambar.',
            'admin_photo.mimes'    => 'Format foto harus jpeg, png, atau jpg.',
            'admin_photo.max'      => 'Ukuran foto tidak boleh lebih dari 2MB.',
        ];

        $validator = Validator::make($request->all(), [
            'admin_photo' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ], $messages);

        if ($validator->fails()) {
            return redirect()->route('admin.profile')
                ->with('error', $validator->errors()->first())
                ->withErrors($validator);
        }

        $user  = Auth::user();
        $admin = Admin::where('user_id', $user->id)->first();
        if ($admin->admin_photo && Storage::disk('public')->exists('admin_photos/' . $admin->admin_photo)) {
            Storage::disk('public')->delete('admin_photos/' . $admin->admin_photo);
        }

        try {
            $photo     = $request->file('admin_photo');
            $photoName = time() . '_' . $user->id . '.' . $photo->getClientOriginalExtension();
            $photo->storeAs('admin_photos', $photoName, 'public');

            $admin->update([
                'admin_photo' => $photoName,
            ]);

            return redirect()->route('admin.profile')->with('success', 'Foto profil berhasil diperbarui.');
        } catch (\Exception $e) {
            return redirect()->route('admin.profile')->with('error', 'Terjadi kesalahan saat mengunggah foto. Silakan coba lagi.');
        }
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
                ], 422);
            }

            return redirect()->route('admin.profile')
                ->with('error', $validator->errors()->first())
                ->withErrors($validator);
        }

        $user = Auth::user();

        // Check if current password matches

        if (! password_verify($request->current_password, $user->user_password)) {
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'errors'  => [
                        'current_password' => ['Kata sandi saat ini tidak valid.'],
                    ],
                ], 422);
            }

            return redirect()->route('admin.profile')
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

            return redirect()->route('admin.profile')
                ->with('success', 'Kata sandi berhasil diubah.');
        } catch (\Exception $e) {
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Terjadi kesalahan saat mengubah kata sandi. Silakan coba lagi.',
                ], 500);
            }

            return redirect()->route('admin.profile')
                ->with('error', 'Terjadi kesalahan saat mengubah kata sandi. Silakan coba lagi.');
        }
    }
    public function exportDashboardPDF()
    {
        try {
            $pdfSetting = \App\Models\PdfSetting::first();

            // Collect all dashboard statistics
            $admin = Auth::user()->admin;

            // Basic Statistics
            $stats = [
                'total_mahasiswa' => Mahasiswa::where('mahasiswa_visible', true)->count(),
                'total_dosen' => Dosen::where('dosen_visible', true)->count(),
                'total_admin' => Admin::where('admin_visible', true)->count(),
                'total_lomba' => AdminKelolaLomba::where('lomba_visible', true)->count(),
                'total_prestasi' => AdminKelolaPrestasi::count(),
                'verified_prestasi' => Verifikasi::where('verifikasi_dosen_status', 'Diterima')
                    ->where('verifikasi_admin_status', 'Diterima')
                    ->whereHas('penghargaan.lomba', function ($query) {
                        $query->where('lomba_terverifikasi', 1);
                    })
                    ->count(),
                'pending_verifikasi_prestasi' => Verifikasi::where('verifikasi_admin_status', 'Menunggu')->count(),
                'pending_verifikasi_lomba' => CompetitionSubmission::where('pendaftaran_status', 'Menunggu')->count(),
            ];

            // Monthly Statistics for the last 12 months
            $monthlyData = $this->getMonthlyStatistics();

            // Yearly Verification Statistics for the last 5 years
            $yearlyVerificationData = $this->getYearlyVerificationStatistics();

            // Prestasi by Tingkatan
            $prestasiByTingkatan = DB::table('m_penghargaans')
                ->join('m_lombas', 'm_penghargaans.lomba_id', '=', 'm_lombas.id')
                ->join('m_tingkatans', 'm_lombas.tingkatan_id', '=', 'm_tingkatans.id')
                ->join('t_verifikasis', 'm_penghargaans.id', '=', 't_verifikasis.penghargaan_id')
                ->where('t_verifikasis.verifikasi_admin_status', 'Diterima')
                ->where('t_verifikasis.verifikasi_dosen_status', 'Diterima')
                ->select('m_tingkatans.tingkatan_nama', 'm_tingkatans.id as tingkatan_id', DB::raw('count(*) as total'))
                ->groupBy('m_tingkatans.tingkatan_nama', 'm_tingkatans.id')
                ->orderBy('m_tingkatans.id')
                ->get();

            // Prestasi by Program Studi
            $prestasiByProdi = DB::table('m_penghargaans')
                ->join('m_mahasiswas', 'm_penghargaans.mahasiswa_id', '=', 'm_mahasiswas.id')
                ->join('m_prodis', 'm_mahasiswas.prodi_id', '=', 'm_prodis.id')
                ->join('t_verifikasis', 'm_penghargaans.id', '=', 't_verifikasis.penghargaan_id')
                ->where('t_verifikasis.verifikasi_admin_status', 'Diterima')
                ->where('t_verifikasis.verifikasi_dosen_status', 'Diterima')
                ->select('m_prodis.prodi_nama', DB::raw('count(*) as total'))
                ->groupBy('m_prodis.prodi_nama')
                ->orderBy('total', 'desc')
                ->get();

            // Top Performing Students
            $topStudents = Mahasiswa::select('m_mahasiswas.*', 'm_prodis.prodi_nama')
                ->join('m_prodis', 'm_mahasiswas.prodi_id', '=', 'm_prodis.id')
                ->where('m_mahasiswas.mahasiswa_visible', true)
                ->orderBy('m_mahasiswas.mahasiswa_score', 'desc')
                ->limit(10)
                ->get();

            // Top Contributing Lecturers
            $topLecturers = Dosen::select('m_dosens.*', 'm_prodis.prodi_nama')
                ->leftJoin('m_prodis', 'm_dosens.prodi_id', '=', 'm_prodis.id')
                ->where('m_dosens.dosen_visible', true)
                ->orderBy('m_dosens.dosen_score', 'desc')
                ->limit(10)
                ->get();

            // Recent Activities
            $recentActivities = AdminKelolaPrestasi::with(['mahasiswa', 'lomba', 'peringkat'])
                ->whereNotNull('created_at')
                ->whereHas('verifikasi', function ($query) {
                    $query->where('verifikasi_dosen_status', 'Diterima')
                        ->where('verifikasi_admin_status', 'Diterima');
                })
                ->orderBy('created_at', 'desc')
                ->limit(20)
                ->get();

            // System Performance Metrics
            $performanceMetrics = [
                'verification_rate' => $stats['total_prestasi'] > 0 ?
                    round(($stats['verified_prestasi'] / $stats['total_prestasi']) * 100, 2) : 0,
                'pending_rate' => $stats['total_prestasi'] > 0 ?
                    round(($stats['pending_verifikasi_prestasi'] / $stats['total_prestasi']) * 100, 2) : 0,
                'avg_score_per_student' => $stats['total_mahasiswa'] > 0 ?
                    round(Mahasiswa::where('mahasiswa_visible', true)->avg('mahasiswa_score'), 2) : 0,
                'avg_score_per_lecturer' => $stats['total_dosen'] > 0 ?
                    round(Dosen::where('dosen_visible', true)->avg('dosen_score'), 2) : 0,
            ];

            // Competition Categories Analysis
            $competitionCategories = AdminKelolaLomba::select('lomba_kategori', DB::raw('count(*) as total'))
                ->where('lomba_visible', true)
                ->where('lomba_terverifikasi', true)
                ->groupBy('lomba_kategori')
                ->orderBy('total', 'desc')
                ->get();

            $pdf = PDF::loadView('admin.export_pdf', compact(
                'pdfSetting',
                'admin',
                'stats',
                'monthlyData',
                'yearlyVerificationData',
                'prestasiByTingkatan',
                'prestasiByProdi',
                'topStudents',
                'topLecturers',
                'recentActivities',
                'performanceMetrics',
                'competitionCategories'
            ))->setPaper('A4', 'portrait');

            return $pdf->download('Laporan_Statistik_Sistem_STAR_' . now()->format('Y-m-d') . '.pdf');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan saat mengekspor laporan: ' . $e->getMessage());
        }
    }
}
