<?php

namespace App\Http\Controllers;

use App\Models\Bimbingan;
use App\Models\Mahasiswa;
use App\Models\Lomba;
use App\Models\Verifikasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class BimbinganController extends Controller
{
    public function index()
    {
        return view('dosbim.bimbingan.index');
    }

    public function list(Request $request)
    {
        $dosen = Auth::user()->dosen;
        
        $bimbingans = Bimbingan::with(['mahasiswa.prodi', 'lomba.tingkatan'])
            ->where('dosen_id', $dosen->id)
            ->where('bimbingan_visible', true);

        if ($request->status && $request->status != '') {
            $bimbingans->where('bimbingan_status', $request->status);
        }

        return DataTables::of($bimbingans)
            ->addIndexColumn()
            ->addColumn('mahasiswa_info', function ($row) {
                return [
                    'nama' => $row->mahasiswa->mahasiswa_nama ?? 'N/A',
                    'nim' => $row->mahasiswa->mahasiswa_nim ?? 'N/A',
                    'prodi' => $row->mahasiswa->prodi->prodi_nama ?? 'N/A',
                    'angkatan' => $row->mahasiswa->mahasiswa_angkatan ?? 'N/A'
                ];
            })
            ->addColumn('lomba_info', function ($row) {
                return [
                    'nama' => $row->lomba->lomba_nama ?? 'N/A',
                    'tingkatan' => $row->lomba->tingkatan->tingkatan_nama ?? 'N/A',
                    'kategori' => $row->lomba->lomba_kategori ?? 'N/A'
                ];
            })
            ->addColumn('status_badge', function ($row) {
                $badgeClass = $row->status_badge;
                $statusText = ucfirst($row->bimbingan_status);
                return "<span class=\"badge badge-{$badgeClass}\">{$statusText}</span>";
            })
            ->addColumn('aksi', function ($row) {
                return '<a href="' . route('dosen.bimbingan.show', $row->id) . '" 
                           class="btn btn-info btn-sm" title="Lihat Detail">
                            <i class="fas fa-eye"></i> Detail
                        </a>';
            })
            ->rawColumns(['status_badge', 'aksi'])
            ->make(true);
    }

    public function show($id)
    {
        $dosen = Auth::user()->dosen;
        $bimbingan = Bimbingan::with(['mahasiswa.prodi', 'lomba.tingkatan'])
            ->where('dosen_id', $dosen->id)
            ->findOrFail($id);

        return view('dosbim.bimbingan.show', compact('bimbingan'));
    }

    public function getMahasiswaBimbingan($dosenId)
    {
        // Get students under this dosen's guidance through verifications
        return Mahasiswa::whereHas('verifikasis', function ($query) use ($dosenId) {
            $query->where('dosen_id', $dosenId);
        })
        ->with(['prodi', 'verifikasis' => function ($query) use ($dosenId) {
            $query->where('dosen_id', $dosenId);
        }])
        ->where('mahasiswa_visible', true)
        ->get();
    }

    public function getStatistics($dosenId)
    {
        $stats = [
            'total_mahasiswa_bimbingan' => $this->getMahasiswaBimbingan($dosenId)->count(),
            'total_prestasi_bimbingan' => Verifikasi::where('dosen_id', $dosenId)->count(),
            'prestasi_verified' => Verifikasi::where('dosen_id', $dosenId)
                ->where('verifikasi_dosen_status', 'Diterima')
                ->where('verifikasi_admin_status', 'Diterima')
                ->count(),
            'prestasi_pending' => Verifikasi::where('dosen_id', $dosenId)
                ->where('verifikasi_dosen_status', 'Menunggu')
                ->count(),
            'total_bimbingan_berlangsung' => Bimbingan::where('dosen_id', $dosenId)
                ->where('bimbingan_status', 'berlangsung')
                ->count(),
            'total_bimbingan_selesai' => Bimbingan::where('dosen_id', $dosenId)
                ->where('bimbingan_status', 'selesai')
                ->count()
        ];

        return $stats;
    }
}
