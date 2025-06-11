<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\CompetitionSubmission;
use App\Models\Lomba;
use App\Models\Semester;
use App\Models\Keahlian;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class LombaVerificationController extends Controller
{
    private function validateSubmissionData($submission)
    {
        $requiredFields = [
            'lomba_nama' => 'Nama Lomba',
            'lomba_penyelenggara' => 'Penyelenggara',
            'lomba_kategori' => 'Kategori',
            'lomba_tanggal_mulai' => 'Tanggal Mulai',
            'lomba_tanggal_selesai' => 'Tanggal Selesai',
            'lomba_tingkatan_id' => 'Tingkatan',
            'lomba_link_pendaftaran' => 'Link Pendaftaran'
        ];

        $missingFields = [];

        foreach ($requiredFields as $field => $label) {
            if (empty($submission->$field)) {
                $missingFields[] = $label;
            }
        }

        if (!$submission->mahasiswa && !$submission->dosen) {
            $missingFields[] = 'Data Penginput (Mahasiswa atau Dosen)';
        }

        if (!$submission->tingkatan) {
            $missingFields[] = 'Data Tingkatan';
        }

        return $missingFields;
    }

    public function index(Request $request)
    {
        $query = CompetitionSubmission::with(['mahasiswa', 'tingkatan']);

        // Filter berdasarkan status verifikasi
        if ($request->has('status') && $request->status !== '') {
            $query->where('pendaftaran_status', $request->status);
        }

        // Search berdasarkan nama lomba atau penyelenggara
        if ($request->has('search') && $request->search !== '') {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('lomba_nama', 'LIKE', "%{$search}%")
                    ->orWhere('lomba_penyelenggara', 'LIKE', "%{$search}%");
            });
        }

        // Urutkan berdasarkan tanggal terbaru
        $submissions = $query->orderBy('created_at', 'desc')->paginate(10);

        return view('admin.lombaVerification.index', compact('submissions'));
    }

    public function list(Request $request)
    {
        $submissions = CompetitionSubmission::with(['mahasiswa', 'tingkatan']);
        // ->where('pendaftaran_visible', true);

        if ($request->status && $request->status !== '') {
            $submissions->where('pendaftaran_status', $request->status);
        }

        return DataTables::of($submissions)
            ->addColumn('aksi', function ($row) {
                $missingFields = $this->validateSubmissionData($row);

                if (!empty($missingFields)) {
                    return '<span class="badge badge-warning" title="Data tidak lengkap: ' . implode(', ', $missingFields) . '">
                                <i class="fas fa-exclamation-triangle"></i> Data Tidak Lengkap
                            </span>';
                } else {
                    return '<a href="' . route('admin.lombaVerification.show', $row->id) . '" 
                               class="btn btn-info btn-sm" 
                               title="Lihat Detail & Verifikasi">
                                <i class="fas fa-eye"></i> Verifikasi
                            </a>';
                }
            })
            ->addColumn('mahasiswa_nama', function ($row) {
                return $row->mahasiswa->mahasiswa_nama ?? null;
            })
            ->addColumn('mahasiswa_nim', function ($row) {
                return $row->mahasiswa->mahasiswa_nim ?? null;
            })
            ->addColumn('dosen_nama', function ($row) {
                return $row->dosen->dosen_nama ?? null;
            })
            ->addColumn('dosen_nip', function ($row) {
                return $row->dosen->dosen_nip ?? null;
            })
            ->addColumn('penginput', function ($row) {
                if ($row->dosen) {
                    return $row->dosen->dosen_nama;
                } elseif ($row->mahasiswa) {
                    return $row->mahasiswa->mahasiswa_nama;
                }
                return 'N/A';
            })
            ->addColumn('nama_lomba', function ($row) {
                return $row->lomba_nama ?? 'N/A';
            })
            ->addColumn('penyelenggara', function ($row) {
                return $row->lomba_penyelenggara ?? 'N/A';
            })
            ->addColumn('tanggal_input', function ($row) {
                return $row->created_at ? $row->created_at->format('d/m/Y') : 'N/A';
            })
            ->addColumn('status', function ($row) {
                $statusClass = '';
                switch ($row->pendaftaran_status) {
                    case 'Menunggu':
                        $statusClass = 'badge badge-warning';
                        break;
                    case 'Diterima':
                        $statusClass = 'badge badge-success';
                        break;
                    case 'Ditolak':
                        $statusClass = 'badge badge-danger';
                        break;
                    default:
                        $statusClass = 'badge badge-secondary';
                }
                return '<span class="' . $statusClass . '">' . $row->pendaftaran_status . '</span>';
            })
            ->addColumn('kelengkapan_data', function ($row) {
                $missingFields = $this->validateSubmissionData($row);

                if (empty($missingFields)) {
                    return '<span class="badge badge-success"><i class="fas fa-check"></i> Lengkap</span>';
                } else {
                    return '<span class="badge badge-danger" title="Field yang kurang: ' . implode(', ', $missingFields) . '">
                                <i class="fas fa-times"></i> Tidak Lengkap (' . count($missingFields) . ')
                            </span>';
                }
            })
            ->with([
                'statistics' => [
                    'pending' => CompetitionSubmission::where('pendaftaran_status', 'Menunggu')->count(),
                    'approved' => CompetitionSubmission::where('pendaftaran_status', 'Diterima')->count(),
                    'rejected' => CompetitionSubmission::where('pendaftaran_status', 'Ditolak')->count(),
                    'total' => CompetitionSubmission::count()
                ]
            ])
            ->rawColumns(['aksi', 'status', 'kelengkapan_data'])
            ->make(true);
    }

    public function show($id)
    {
        $submission = CompetitionSubmission::with(['mahasiswa', 'tingkatan'])->findOrFail($id);

        $missingFields = $this->validateSubmissionData($submission);
        $canVerify = empty($missingFields);

        $keahlians = collect();
        if ($submission->lomba_keahlian_ids && !empty($submission->lomba_keahlian_ids)) {
            $keahlians = Keahlian::whereIn('id', $submission->lomba_keahlian_ids)->get();
        }

        return view('admin.lombaVerification.show', compact('submission', 'keahlians', 'missingFields', 'canVerify'));
    }

    public function approve(Request $request, $id)
    {
        try {
            DB::beginTransaction();

            $submission = CompetitionSubmission::findOrFail($id);

            if ($submission->pendaftaran_status !== 'Menunggu') {
                return redirect()->back()->with('error', 'Submission sudah diverifikasi sebelumnya');
            }

            $missingFields = $this->validateSubmissionData($submission);
            if (!empty($missingFields)) {
                return redirect()->back()->with('error', 'Data tidak lengkap. Field yang kurang: ' . implode(', ', $missingFields));
            }

            if ($submission->lomba_id) {
                $lomba = Lomba::findOrFail($submission->lomba_id);
                $lomba->update([
                    'lomba_terverifikasi' => 1,
                    'lomba_visible' => true,
                ]);
            } else {
                $currentSemester = Semester::where('semester_visible', true)->first();
                if (!$currentSemester) {
                    return redirect()->back()->with('error', 'Semester aktif tidak ditemukan');
                }
            }

            $submission->update([
                'pendaftaran_status' => 'Diterima',
                'pendaftaran_tanggal_pendaftaran' => now(),
            ]);

            // Create notification for submitter
            if ($submission->mahasiswa_id && $submission->mahasiswa->user_id) {
                createNotification(
                    $submission->mahasiswa->user_id,
                    'Lomba Disetujui',
                    "Pengajuan lomba '{$submission->lomba_nama}' telah disetujui oleh admin!",
                    route('mahasiswa.riwayatPengajuanLomba.show', $submission->id),
                    'fas fa-trophy',
                    'bg-success',
                    $submission->id,
                    'lomba_submission'
                );
            }

            if ($submission->dosen_id && $submission->dosen->user_id) {
                createNotification(
                    $submission->dosen->user_id,
                    'Lomba Disetujui',
                    "Pengajuan lomba '{$submission->lomba_nama}' telah disetujui oleh admin!",
                    route('dosen.riwayatPengajuanLomba.show', $submission->id),
                    'fas fa-trophy',
                    'bg-success',
                    $submission->id,
                    'lomba_submission'
                );
            }

            DB::commit();

            return redirect()->route('admin.lombaVerification.index')
                ->with('success', 'Lomba berhasil disetujui');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function reject(Request $request, $id)
    {
        try {
            DB::beginTransaction();

            $submission = CompetitionSubmission::findOrFail($id);

            if ($submission->pendaftaran_status !== 'Menunggu') {
                return redirect()->back()->with('error', 'Submission sudah diverifikasi sebelumnya');
            }

            $submission->update([
                'pendaftaran_status' => 'Ditolak',
                'pendaftaran_visible' => false,
                'pendaftaran_tanggal_pendaftaran' => now(),
            ]);

            if ($submission->lomba_id) {
                $lomba = Lomba::find($submission->lomba_id);
                if ($lomba) {
                    $lomba->update([
                        'lomba_terverifikasi' => 0,
                        'lomba_visible' => false,
                    ]);
                }
            }

            // Create notification for submitter
            if ($submission->mahasiswa_id && $submission->mahasiswa->user_id) {
                createNotification(
                    $submission->mahasiswa->user_id,
                    'Lomba Ditolak',
                    "Pengajuan lomba '{$submission->lomba_nama}' ditolak. Silakan periksa dan ajukan kembali.",
                    route('mahasiswa.riwayatPengajuanLomba.show', $submission->id),
                    'fas fa-ban',
                    'bg-danger',
                    $submission->id,
                    'lomba_submission'
                );
            }

            if ($submission->dosen_id && $submission->dosen->user_id) {
                createNotification(
                    $submission->dosen->user_id,
                    'Lomba Ditolak',
                    "Pengajuan lomba '{$submission->lomba_nama}' ditolak. Silakan periksa dan ajukan kembali.",
                    route('dosen.riwayatPengajuanLomba.show', $submission->id),
                    'fas fa-ban',
                    'bg-danger',
                    $submission->id,
                    'lomba_submission'
                );
            }

            DB::commit();

            return redirect()->route('admin.lombaVerification.index')
                ->with('success', 'Lomba berhasil ditolak');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}
