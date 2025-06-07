<?php

namespace App\Http\Controllers;

use App\Models\Verifikasi;
use App\Models\Mahasiswa;
use App\Models\Dosen;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class PrestasiVerificationController extends Controller
{
    // For Dosen
    public function dosenIndex()
    {
        return view('dosbim.prestasiVerification.index');
    }

    public function dosenList(Request $request)
    {
        $dosen = Auth::user()->dosen;

        $verifikasis = Verifikasi::with([
            'mahasiswa.prodi',
            'penghargaan.lomba.tingkatan',
            'penghargaan.peringkat'
        ])
            ->where('dosen_id', $dosen->id)
            ->whereHas('penghargaan.lomba', function ($query) {
                $query->where('lomba_terverifikasi', 1);
            });

        if ($request->status && $request->status != '') {
            $verifikasis->where('verifikasi_dosen_status', $request->status);
        }

        return DataTables::of($verifikasis)
            ->addIndexColumn()
            ->filter(function ($instance) use ($request) {
                if ($request->get('search')['value']) {
                    $search = $request->get('search')['value'];
                    $instance->where(function ($w) use ($search) {
                        $w->whereHas('mahasiswa', function ($q) use ($search) {
                            $q->where('mahasiswa_nama', 'LIKE', "%$search%")
                              ->orWhere('mahasiswa_nim', 'LIKE', "%$search%");
                        })
                        ->orWhereHas('mahasiswa.prodi', function ($q) use ($search) {
                            $q->where('prodi_nama', 'LIKE', "%$search%");
                        })
                        ->orWhereHas('penghargaan', function ($q) use ($search) {
                            $q->where('penghargaan_judul', 'LIKE', "%$search%");
                        })
                        ->orWhereHas('penghargaan.lomba', function ($q) use ($search) {
                            $q->where('lomba_nama', 'LIKE', "%$search%");
                        });
                    });
                }
            })
            ->addColumn('mahasiswa_info', function ($row) {
                return [
                    'nama' => $row->mahasiswa->mahasiswa_nama ?? 'N/A',
                    'nim' => $row->mahasiswa->mahasiswa_nim ?? 'N/A',
                    'prodi' => $row->mahasiswa->prodi->prodi_nama ?? 'N/A'
                ];
            })
            ->addColumn('prestasi_info', function ($row) {
                return [
                    'judul' => $row->penghargaan->penghargaan_judul ?? 'N/A',
                    'lomba' => $row->penghargaan->lomba->lomba_nama ?? 'N/A',
                    'peringkat' => $row->penghargaan->peringkat->peringkat_nama ?? 'N/A',
                    'score' => $row->penghargaan->penghargaan_score ?? 0
                ];
            })
            ->addColumn('status_verifikasi', function ($row) {
                if ($row->verifikasi_dosen_status === 'Diterima') {
                    return '<span class="badge badge-success"><i class="fas fa-check mr-1"></i> Diterima</span>';
                } elseif ($row->verifikasi_dosen_status === 'Ditolak') {
                    return '<span class="badge badge-danger"><i class="fas fa-times mr-1"></i> Ditolak</span>';
                } else {
                    return '<span class="badge badge-warning"><i class="fas fa-clock mr-1"></i> Menunggu</span>';
                }
            })
            ->addColumn('aksi', function ($row) {
                return '<a href="' . route('dosen.prestasiVerification.show', $row->id) . '" 
                           class="btn btn-warning btn-sm" 
                           title="Verifikasi">
                            <i class="fas fa-eye"> Beri Keputusan</i>
                        </a>';
            })
            ->with([
                'statistics' => [
                    'pending' => Verifikasi::where('dosen_id', $dosen->id)
                        ->where('verifikasi_dosen_status', 'Menunggu')
                        ->whereHas('penghargaan.lomba', function ($query) {
                            $query->where('lomba_terverifikasi', 1);
                        })
                        ->count(),
                    'approved' => Verifikasi::where('dosen_id', $dosen->id)
                        ->where('verifikasi_dosen_status', 'Diterima')
                        ->whereHas('penghargaan.lomba', function ($query) {
                            $query->where('lomba_terverifikasi', 1);
                        })
                        ->count(),
                    'rejected' => Verifikasi::where('dosen_id', $dosen->id)
                        ->where('verifikasi_dosen_status', 'Ditolak')
                        ->whereHas('penghargaan.lomba', function ($query) {
                            $query->where('lomba_terverifikasi', 1);
                        })
                        ->count(),
                    'total' => Verifikasi::where('dosen_id', $dosen->id)
                        ->whereHas('penghargaan.lomba', function ($query) {
                            $query->where('lomba_terverifikasi', 1);
                        })
                        ->count(),
                ]
            ])
            ->rawColumns(['status_verifikasi', 'aksi'])
            ->make(true);
    }

    public function dosenShow($id)
    {
        $dosen = Auth::user()->dosen;
        $verifikasi = Verifikasi::with([
            'mahasiswa.prodi',
            'penghargaan.lomba.tingkatan',
            'penghargaan.peringkat',
            'admin'
        ])
            ->where('dosen_id', $dosen->id)
            ->findOrFail($id);

        return view('dosbim.prestasiVerification.show', compact('verifikasi'));
    }

    public function dosenVerify(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:Diterima,Ditolak',
            'keterangan' => 'nullable|string|max:500'
        ]);

        $dosen = Auth::user()->dosen;
        $verifikasi = Verifikasi::where('dosen_id', $dosen->id)->findOrFail($id);

        try {
            DB::beginTransaction();

            $verifikasi->update([
                'verifikasi_dosen_status' => $request->status,
                'verifikasi_dosen_keterangan' => $request->keterangan,
                'verifikasi_dosen_tanggal' => now()
            ]);

            // If both dosen and admin approved, update scores
            if ($request->status === 'Diterima' && $verifikasi->verifikasi_admin_status === 'Diterima') {
                $this->updateScores($verifikasi);
                $verifikasi->update(['verifikasi_verified_at' => now()]);
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Verifikasi berhasil disimpan.'
            ]);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat menyimpan verifikasi.'
            ], 500);
        }
    }

    // For Admin
    public function adminIndex()
    {
        return view('admin.prestasiVerification.index');
    }

    public function adminList(Request $request)
    {
        $verifikasis = Verifikasi::with([
            'mahasiswa.prodi',
            'penghargaan.lomba.tingkatan',
            'penghargaan.peringkat',
            'dosen'
        ])
            ->whereHas('penghargaan.lomba', function ($query) {
                $query->where('lomba_terverifikasi', 1);
            });

        if ($request->status && $request->status != '') {
            $verifikasis->where('verifikasi_admin_status', $request->status);
        }

        return DataTables::of($verifikasis)
            ->addIndexColumn()
            ->filter(function ($instance) use ($request) {
                if ($request->get('search')['value']) {
                    $search = $request->get('search')['value'];
                    $instance->where(function ($w) use ($search) {
                        $w->whereHas('mahasiswa', function ($q) use ($search) {
                            $q->where('mahasiswa_nama', 'LIKE', "%$search%")
                              ->orWhere('mahasiswa_nim', 'LIKE', "%$search%");
                        })
                        ->orWhereHas('mahasiswa.prodi', function ($q) use ($search) {
                            $q->where('prodi_nama', 'LIKE', "%$search%");
                        })
                        ->orWhereHas('penghargaan', function ($q) use ($search) {
                            $q->where('penghargaan_judul', 'LIKE', "%$search%");
                        })
                        ->orWhereHas('penghargaan.lomba', function ($q) use ($search) {
                            $q->where('lomba_nama', 'LIKE', "%$search%");
                        })
                        ->orWhereHas('dosen', function ($q) use ($search) {
                            $q->where('dosen_nama', 'LIKE', "%$search%");
                        });
                    });
                }
            })
            ->addColumn('mahasiswa_info', function ($row) {
                return [
                    'nama' => $row->mahasiswa->mahasiswa_nama ?? 'N/A',
                    'nim' => $row->mahasiswa->mahasiswa_nim ?? 'N/A',
                    'prodi' => $row->mahasiswa->prodi->prodi_nama ?? 'N/A'
                ];
            })
            ->addColumn('prestasi_info', function ($row) {
                return [
                    'judul' => $row->penghargaan->penghargaan_judul ?? 'N/A',
                    'lomba' => $row->penghargaan->lomba->lomba_nama ?? 'N/A',
                    'peringkat' => $row->penghargaan->peringkat->peringkat_nama ?? 'N/A',
                    'score' => $row->penghargaan->penghargaan_score ?? 0
                ];
            })
            ->addColumn('dosen_pembimbing', function ($row) {
                return $row->dosen->dosen_nama ?? 'N/A';
            })
            ->addColumn('status_verifikasi_dosen', function ($row) {
                if ($row->verifikasi_dosen_status === 'Diterima') {
                    return '<span class="badge badge-success"><i class="fas fa-check mr-1"></i> Diterima</span>';
                } elseif ($row->verifikasi_dosen_status === 'Ditolak') {
                    return '<span class="badge badge-danger"><i class="fas fa-times mr-1"></i> Ditolak</span>';
                } else {
                    return '<span class="badge badge-warning"><i class="fas fa-clock mr-1"></i> Menunggu</span>';
                }
            })
            ->addColumn('status_verifikasi', function ($row) {
                if ($row->verifikasi_admin_status === 'Diterima') {
                    return '<span class="badge badge-success"><i class="fas fa-check mr-1"></i> Diterima</span>';
                } elseif ($row->verifikasi_admin_status === 'Ditolak') {
                    return '<span class="badge badge-danger"><i class="fas fa-times mr-1"></i> Ditolak</span>';
                } else {
                    return '<span class="badge badge-warning"><i class="fas fa-clock mr-1"></i> Menunggu</span>';
                }
            })
            ->addColumn('aksi', function ($row) {
                return '<a href="' . route('admin.prestasiVerification.show', $row->id) . '" 
                            class="btn btn-warning btn-sm" 
                           title="Verifikasi">
                            <i class="fas fa-eye"> Beri Keputusan</i>
                        </a>';
            })
            ->with([
                'statistics' => [
                    'pending' => Verifikasi::where('verifikasi_admin_status', 'Menunggu')
                        ->whereHas('penghargaan.lomba', function ($query) {
                            $query->where('lomba_terverifikasi', 1);
                        })
                        ->count(),
                    'approved' => Verifikasi::where('verifikasi_admin_status', 'Diterima')
                        ->whereHas('penghargaan.lomba', function ($query) {
                            $query->where('lomba_terverifikasi', 1);
                        })
                        ->count(),
                    'rejected' => Verifikasi::where('verifikasi_admin_status', 'Ditolak')
                        ->whereHas('penghargaan.lomba', function ($query) {
                            $query->where('lomba_terverifikasi', 1);
                        })
                        ->count(),
                    'total' => Verifikasi::whereHas('penghargaan.lomba', function ($query) {
                        $query->where('lomba_terverifikasi', 1);
                    })
                        ->count(),
                ]
            ])

            ->rawColumns(['status_verifikasi', 'status_verifikasi_dosen', 'aksi'])
            ->make(true);
    }

    public function adminShow($id)
    {
        $verifikasi = Verifikasi::with([
            'mahasiswa.prodi',
            'penghargaan.lomba.tingkatan',
            'penghargaan.peringkat',
            'dosen'
        ])->findOrFail($id);

        return view('admin.prestasiVerification.show', compact('verifikasi'));
    }

    public function adminVerify(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:Diterima,Ditolak',
            'keterangan' => 'nullable|string|max:500'
        ]);

        $verifikasi = Verifikasi::findOrFail($id);

        try {
            DB::beginTransaction();

            $verifikasi->update([
                'verifikasi_admin_status' => $request->status,
                'verifikasi_admin_keterangan' => $request->keterangan,
                'verifikasi_admin_tanggal' => now(),
                'admin_id' => Auth::user()->admin->id
            ]);

            // If both dosen and admin approved, update scores
            if ($request->status === 'Diterima' && $verifikasi->verifikasi_dosen_status === 'Diterima') {
                $this->updateScores($verifikasi);
                $verifikasi->update(['verifikasi_verified_at' => now()]);
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Verifikasi berhasil disimpan.'
            ]);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat menyimpan verifikasi.'
            ], 500);
        }
    }

    private function updateScores($verifikasi)
    {
        $score = $verifikasi->penghargaan->penghargaan_score ?? 0;

        // Update mahasiswa score
        $mahasiswa = $verifikasi->mahasiswa;
        $mahasiswa->increment('mahasiswa_score', $score);

        // Update dosen score
        $dosen = $verifikasi->dosen;
        $dosen->increment('dosen_score', $score);
    }
}
