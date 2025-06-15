<?php

namespace App\Http\Controllers;

use App\Models\Lomba;
use App\Models\Tingkatan;
use App\Models\Keahlian;
use App\Models\Peringkat;
use App\Models\CompetitionSubmission;
use App\Models\Penghargaan;
use App\Models\Verifikasi;
use App\Models\Dosen;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CompetitionSubmissionController extends Controller
{
    public function create()
    {
        $lombas = Lomba::with(['keahlians', 'tingkatan'])
            ->where('lomba_visible', true)
            ->orderBy('lomba_terverifikasi', 'desc')
            ->orderBy('created_at', 'desc')
            ->get();

        $tingkatans = Tingkatan::where('tingkatan_visible', true)->get();

        return view('mahasiswa.ajukanVerifikasiPrestasi.create-step1', compact('lombas', 'tingkatans'));
    }

    public function selectCompetition(Request $request)
    {
        $request->validate([
            'lomba_id' => 'required|exists:m_lombas,id'
        ]);

        $selectedLomba = Lomba::with(['keahlians', 'tingkatan'])->find($request->lomba_id);
        $peringkats = Peringkat::where('peringkat_visible', true)->get();
        $dosens = Dosen::where('dosen_visible', true)->get();

        return view('mahasiswa.ajukanVerifikasiPrestasi.create-step2', compact('selectedLomba', 'peringkats', 'dosens'))
            ->with('competitionSubmissionId', null);
    }

    public function store(Request $request)
    {
        $request->validate([
            'lomba_nama' => 'required|string|max:255',
            'lomba_penyelenggara' => 'required|string|max:255',
            'lomba_kategori' => 'required|string|max:255',
            'lomba_tingkatan_id' => 'required|exists:m_tingkatans,id',
            'lomba_keahlian_ids' => 'sometimes|array',
            'lomba_keahlian_ids.*' => 'exists:m_keahlians,id',
            'new_keahlian_names' => 'sometimes|array',
            'new_keahlian_names.*' => 'string|max:255',
            'lomba_tanggal_mulai' => 'required|date',
            'lomba_tanggal_selesai' => 'required|date|after_or_equal:lomba_tanggal_mulai',
            'lomba_link_pendaftaran' => 'nullable|url',
            'lomba_link_poster' => 'nullable|url',
        ]);

        $keahlianIds = $request->lomba_keahlian_ids ?? [];

        // Handle new keahlian names
        if ($request->has('new_keahlian_names')) {
            foreach ($request->new_keahlian_names as $newKeahlianName) {
                // Check if keahlian already exists (case insensitive)
                $existingKeahlian = Keahlian::whereRaw('LOWER(keahlian_nama) = ?', [strtolower(trim($newKeahlianName))])->first();

                if (!$existingKeahlian) {
                    // Create new keahlian
                    $newKeahlian = Keahlian::create([
                        'keahlian_nama' => trim($newKeahlianName),
                        'keahlian_visible' => true
                    ]);
                    $keahlianIds[] = $newKeahlian->id;
                } else {
                    // Use existing keahlian
                    $keahlianIds[] = $existingKeahlian->id;
                }
            }
        }

        if (empty($keahlianIds)) {
            return back()->withErrors(['keahlian' => 'Pilih minimal satu bidang keahlian'])->withInput();
        }

        $keahlianIds = array_values(array_unique(array_map('intval', $keahlianIds)));

        DB::beginTransaction();
        try {
            // Create lomba record with terverifikasi = false
            $lomba = Lomba::create([
                'tingkatan_id' => $request->lomba_tingkatan_id,
                'semester_id' => 1,
                'lomba_nama' => $request->lomba_nama,
                'lomba_penyelenggara' => $request->lomba_penyelenggara,
                'lomba_kategori' => $request->lomba_kategori,
                'lomba_tanggal_mulai' => $request->lomba_tanggal_mulai,
                'lomba_tanggal_selesai' => $request->lomba_tanggal_selesai,
                'lomba_link_pendaftaran' => $request->lomba_link_pendaftaran ?? '',
                'lomba_link_poster' => $request->lomba_link_poster ?? '',
                'lomba_terverifikasi' => false,
                'lomba_visible' => true
            ]);

            // It creates records in the pivot table linking lomba_id to keahlian_id
            $lomba->keahlians()->attach($keahlianIds);

            // Determine user role and set appropriate ID
            $competitionSubmissionData = [
                'lomba_id' => $lomba->id,
                'lomba_nama' => $request->lomba_nama,
                'lomba_penyelenggara' => $request->lomba_penyelenggara,
                'lomba_kategori' => $request->lomba_kategori,
                'lomba_tanggal_mulai' => $request->lomba_tanggal_mulai,
                'lomba_tanggal_selesai' => $request->lomba_tanggal_selesai,
                'lomba_link_pendaftaran' => $request->lomba_link_pendaftaran,
                'lomba_link_poster' => $request->lomba_link_poster,
                'lomba_tingkatan_id' => $request->lomba_tingkatan_id,
                'pendaftaran_tanggal_pendaftaran' => now(),
                'lomba_keahlian_ids' => $keahlianIds,
                'pendaftaran_status' => 'Menunggu',
                'pendaftaran_visible' => true
            ];

            // Check user role and assign appropriate ID
            if (auth()->user()->user_role === 'Dosen') {
                $competitionSubmissionData['dosen_id'] = auth()->user()->dosen->id;
                $competitionSubmissionData['mahasiswa_id'] = null;
            } else {
                $competitionSubmissionData['mahasiswa_id'] = auth()->user()->mahasiswa->id;
                $competitionSubmissionData['dosen_id'] = null;
            }

            // Create competition submission record
            $competitionSubmission = CompetitionSubmission::create($competitionSubmissionData);

            // Create notification for admin about new competition submission
            $admins = \App\Models\Admin::where('admin_visible', true)->get();
            foreach ($admins as $admin) {
                if ($admin->user_id) {
                    createNotification(
                        $admin->user_id,
                        'Pengajuan Lomba Baru',
                        "Pengajuan lomba baru '{$lomba->lomba_nama}' perlu diverifikasi.",
                        route('admin.lombaVerification.show', $competitionSubmission->id),
                        'fas fa-file-alt',
                        'bg-warning',
                        $competitionSubmission->id,
                        'lomba_submission'
                    );
                }
            }

            // Create notification for submitter
            $userId = auth()->user()->id;
            createNotification(
                $userId,
                'Lomba Diajukan',
                "Pengajuan lomba '{$lomba->lomba_nama}' berhasil dikirim dan sedang menunggu verifikasi.",
                auth()->user()->user_role === 'Dosen' ? 
                    route('dosen.riwayatPengajuanLomba.show', $competitionSubmission->id) :
                    route('mahasiswa.riwayatPengajuanLomba.show', $competitionSubmission->id),
                'fas fa-upload',
                'bg-warning',
                $competitionSubmission->id,
                'lomba_submission'
            );

            DB::commit();

            if ($request->expectsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Lomba berhasil diajukan',
                    'redirect' => auth()->user()->user_role === 'Dosen'
                        ? route('dosen.lomba.index')
                        : route('student.achievement.select-competition'),
                    'lomba_id' => $lomba->id
                ]);
            }

            if (auth()->user()->user_role === 'Dosen') {
                return redirect()->route('dosen.lomba.index')->with('success', 'Lomba berhasil diajukan');
            }

            $peringkats = Peringkat::where('peringkat_visible', true)->get();
            $dosens = Dosen::where('dosen_visible', true)->get();

            return view('mahasiswa.ajukanVerifikasiPrestasi.create-step2')
                ->with('selectedLomba', $lomba)
                ->with('competitionSubmissionId', $competitionSubmission->id)
                ->with('peringkats', $peringkats)
                ->with('dosens', $dosens);
        } catch (\Exception $e) {
            DB::rollBack();
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Terjadi kesalahan saat memproses pengajuan: ' . $e->getMessage()
                ], 500);
            }

            return back()->withErrors(['error' => 'Terjadi kesalahan saat memproses pengajuan.'])->withInput();
        }
    }

    public function finalizeSubmission(Request $request)
    {
        $request->validate([
            'penghargaan_judul' => 'required|string|max:255',
            'peringkat_id' => 'required|exists:m_peringkats,id',
            'dosen_id' => 'required|exists:m_dosens,id',
            'penghargaan_tempat' => 'required|string|max:255',
            'penghargaan_url' => 'nullable|url',
            'penghargaan_tanggal_mulai' => 'required|date',
            'penghargaan_tanggal_selesai' => 'required|date|after_or_equal:penghargaan_tanggal_mulai',
            'penghargaan_jumlah_peserta' => 'required|integer|min:1',
            'penghargaan_jumlah_instansi' => 'required|integer|min:1',
            'penghargaan_no_surat_tugas' => 'required|string|max:255',
            'penghargaan_tanggal_surat_tugas' => 'required|date',
            'penghargaan_file_surat_tugas' => 'required|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'penghargaan_file_sertifikat' => 'required|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'penghargaan_file_poster' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'penghargaan_photo_kegiatan' => 'nullable|file|mimes:jpg,jpeg,png|max:2048',
        ]);

        try {
            // Handle file uploads
            $filePaths = [];
            $files = ['penghargaan_file_surat_tugas', 'penghargaan_file_sertifikat', 'penghargaan_file_poster', 'penghargaan_photo_kegiatan'];

            foreach ($files as $file) {
                if ($request->hasFile($file)) {
                    $filePaths[$file] = $request->file($file)->store('prestasi', 'public');
                }
            }

            $peringkat = Peringkat::find($request->peringkat_id);

            $tingkatanId = $request->lomba_id ?
                Lomba::find($request->lomba_id)->tingkatan_id :
                CompetitionSubmission::find($request->competition_submission_id)->lomba_tingkatan_id;

            $tingkatan = Tingkatan::find($tingkatanId);

            $penghargaanScore = $peringkat->peringkat_bobot * $tingkatan->tingkatan_point;

            // Create penghargaan record
            $penghargaan = Penghargaan::create([
                'mahasiswa_id' => Auth::user()->mahasiswa->id,
                'lomba_id' => $request->lomba_id ??
                    CompetitionSubmission::find($request->competition_submission_id)->lomba_id,
                'peringkat_id' => $request->peringkat_id,
                'tingkatan_id' => $request->lomba_id ?
                    Lomba::find($request->lomba_id)->tingkatan_id :
                    CompetitionSubmission::find($request->competition_submission_id)->lomba_tingkatan_id,
                'penghargaan_judul' => $request->penghargaan_judul,
                'penghargaan_tempat' => $request->penghargaan_tempat,
                'penghargaan_url' => $request->penghargaan_url,
                'penghargaan_tanggal_mulai' => $request->penghargaan_tanggal_mulai,
                'penghargaan_tanggal_selesai' => $request->penghargaan_tanggal_selesai,
                'penghargaan_jumlah_peserta' => $request->penghargaan_jumlah_peserta,
                'penghargaan_jumlah_instansi' => $request->penghargaan_jumlah_instansi,
                'penghargaan_no_surat_tugas' => $request->penghargaan_no_surat_tugas,
                'penghargaan_score' => $penghargaanScore,
                'penghargaan_tanggal_surat_tugas' => $request->penghargaan_tanggal_surat_tugas,
                'penghargaan_file_surat_tugas' => $filePaths['penghargaan_file_surat_tugas'] ?? null,
                'penghargaan_file_sertifikat' => $filePaths['penghargaan_file_sertifikat'] ?? null,
                'penghargaan_file_poster' => $filePaths['penghargaan_file_poster'] ?? null,
                'penghargaan_photo_kegiatan' => $filePaths['penghargaan_photo_kegiatan'] ?? null,
                'penghargaan_visible' => true
            ]);

            $verifikasi = Verifikasi::create([
                'mahasiswa_id' => Auth::user()->mahasiswa->id,
                'penghargaan_id' => $penghargaan->id,
                'dosen_id' => $request->dosen_id,
                'verifikasi_admin_status' => 'Menunggu',
                'verifikasi_dosen_status' => 'Menunggu',
                'verifikasi_visible' => true
            ]);

            // Create notification for selected dosen
            $dosen = \App\Models\Dosen::find($request->dosen_id);
            if ($dosen && $dosen->user_id) {
                createNotification(
                    $dosen->user_id,
                    'Verifikasi Prestasi Baru',
                    "Pengajuan prestasi '{$penghargaan->penghargaan_judul}' perlu diverifikasi.",
                    route('dosen.prestasiVerification.show', $verifikasi->id),
                    'fas fa-star',
                    'bg-warning',
                    $verifikasi->id,
                    'prestasi_verification'
                );
            }

            // Create notification for admin
            $admins = \App\Models\Admin::where('admin_visible', true)->get();
            foreach ($admins as $admin) {
                if ($admin->user_id) {
                    createNotification(
                        $admin->user_id,
                        'Verifikasi Prestasi Baru',
                        "Pengajuan prestasi '{$penghargaan->penghargaan_judul}' perlu diverifikasi admin.",
                        route('admin.prestasiVerification.show', $verifikasi->id),
                        'fas fa-star',
                        'bg-warning',
                        $verifikasi->id,
                        'prestasi_verification'
                    );
                }
            }

            // Create notification for student
            createNotification(
                Auth::user()->id,
                'Prestasi Diajukan',
                "Pengajuan prestasi '{$penghargaan->penghargaan_judul}' berhasil dikirim dan sedang menunggu verifikasi.",
                route('mahasiswa.riwayatPengajuanPrestasi.show', $verifikasi->id),
                'fas fa-upload',
                'bg-warning',
                $verifikasi->id,
                'prestasi_verification'
            );

            // Check if AJAX request
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Pengajuan prestasi berhasil disubmit dan sedang menunggu verifikasi.',
                    'redirect' => route('student.achievement.step3'),
                    'penghargaan' => [
                        'id' => $penghargaan->id,
                        'judul' => $penghargaan->penghargaan_judul,
                        'score' => $penghargaan->penghargaan_score
                    ]
                ]);
            }

            return redirect()->route('student.achievement.step3');
        } catch (\Exception $e) {
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Terjadi kesalahan saat memproses pengajuan: ' . $e->getMessage()
                ], 500);
            }

            return back()->withErrors(['error' => 'Terjadi kesalahan saat memproses pengajuan.'])->withInput();
        }
    }

    public function step3()
    {
        return view('mahasiswa.ajukanVerifikasiPrestasi.create-step3');
    }
}
