<?php

namespace App\Http\Controllers;

use App\Models\AdminKelolaPrestasi;
use App\Models\Mahasiswa;
use App\Models\AdminKelolaLomba;
use App\Models\Peringkat;
use App\Models\Tingkatan;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Yajra\DataTables\Facades\DataTables;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;

class AdminKelolaPrestasiController extends Controller
{
    public function index()
    {
        $page = (object)[
            'title' => 'Data Prestasi',
        ];

        return view('admin.adminKelolaPrestasi.index', compact('page'));
    }

    public function getPrestasiList(Request $request)
    {
        $prestasi = AdminKelolaPrestasi::with(['mahasiswa', 'lomba', 'peringkat', 'tingkatan'])
            ->where('penghargaan_visible', true);

        return DataTables::of($prestasi)
            ->addColumn('mahasiswa_nama', fn($p) => $p->mahasiswa->mahasiswa_nama ?? '-')
            ->addColumn('lomba_nama', fn($p) => $p->lomba->lomba_nama ?? '-')
            ->addColumn('peringkat_nama', fn($p) => $p->peringkat->peringkat_nama ?? '-')
            ->addColumn('tingkatan_nama', fn($p) => $p->tingkatan->tingkatan_nama ?? '-')
            ->addColumn('aksi', function ($p) {
                $view = '<a href="' . url('/admin/adminKelolaPrestasi/show/' . $p->id) . '" class="btn btn-sm btn-info"><i class="fas fa-eye"></i> Detail</a>';
                $edit = '<button onclick="modalAction(\'' . route('admin.adminKelolaPrestasi.editAjax', $p->id) . '\')" class="btn btn-sm btn-warning"><i class="fas fa-edit"></i> Edit</button>';
                $delete = '<button onclick="modalAction(\'' . route('admin.adminKelolaPrestasi.confirmAjax', $p->id) . '\')" class="btn btn-sm btn-danger"><i class="fas fa-trash"></i> Hapus</button>';
                return $view . ' ' . $edit . ' ' . $delete;
            })
            ->rawColumns(['aksi'])
            ->make(true);
    }

    public function createAjax()
    {
        $mahasiswas = Mahasiswa::all();
        $lombas = AdminKelolaLomba::all();
        $peringkats = Peringkat::all();
        $tingkatans = Tingkatan::all();

        return view('admin.adminKelolaPrestasi.create_ajax', compact('mahasiswas', 'lombas', 'peringkats', 'tingkatans'));
    }

    public function storeAjax(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'mahasiswa_id' => 'required|exists:m_mahasiswas,id',
            'lomba_id' => 'required|exists:m_lombas,id',
            'peringkat_id' => 'required|exists:m_peringkats,id',
            'tingkatan_id' => 'required|exists:m_tingkatans,id',
            'penghargaan_judul' => 'required|string|max:255',
            'penghargaan_tempat' => 'nullable|string|max:255',
            'penghargaan_url' => 'nullable|url',
            'penghargaan_tanggal_mulai' => 'required|date',
            'penghargaan_tanggal_selesai' => 'required|date|after_or_equal:penghargaan_tanggal_mulai',
            'penghargaan_jumlah_peserta' => 'nullable|integer|min:1',
            'penghargaan_jumlah_instansi' => 'nullable|integer|min:1',
            'penghargaan_no_surat_tugas' => 'nullable|string|max:255',
            'penghargaan_tanggal_surat_tugas' => 'nullable|date',
            'penghargaan_file_surat_tugas' => 'nullable|string',
            'penghargaan_file_sertifikat' => 'nullable|string',
            'penghargaan_file_poster' => 'nullable|string',
            'penghargaan_photo_kegiatan' => 'nullable|string',
            'penghargaan_score' => 'nullable|numeric',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validasi gagal',
                'msgField' => $validator->errors(),
            ]);
        }

        AdminKelolaPrestasi::create($validator->validated() + [
            'penghargaan_visible' => 1,
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Prestasi berhasil ditambahkan',
        ]);
    }

    public function show($id)
    {
        $prestasi = AdminKelolaPrestasi::with(['mahasiswa', 'lomba', 'peringkat', 'tingkatan'])->findOrFail($id);
        $page = (object)[
            'title' => 'Detail Prestasi',
        ];

        return view('admin.adminKelolaPrestasi.show', compact('prestasi', 'page'));
    }

    public function editAjax($id)
    {
        $prestasi = AdminKelolaPrestasi::findOrFail($id);
        $mahasiswas = Mahasiswa::all();
        $lombas = AdminKelolaLomba::all();
        $peringkats = Peringkat::all();
        $tingkatans = Tingkatan::all();

        return view('admin.adminKelolaPrestasi.edit_ajax', compact('prestasi', 'mahasiswas', 'lombas', 'peringkats', 'tingkatans'));
    }

    public function updateAjax(Request $request, $id)
    {
        $prestasi = AdminKelolaPrestasi::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'mahasiswa_id' => 'required|exists:mahasiswas,id',
            'lomba_id' => 'required|exists:m_lombas,id',
            'peringkat_id' => 'required|exists:m_peringkats,id',
            'tingkatan_id' => 'required|exists:m_tingkatans,id',
            'penghargaan_judul' => 'required|string|max:255',
            'penghargaan_tempat' => 'nullable|string|max:255',
            'penghargaan_url' => 'nullable|url',
            'penghargaan_tanggal_mulai' => 'required|date',
            'penghargaan_tanggal_selesai' => 'required|date|after_or_equal:penghargaan_tanggal_mulai',
            'penghargaan_jumlah_peserta' => 'nullable|integer|min:1',
            'penghargaan_jumlah_instansi' => 'nullable|integer|min:1',
            'penghargaan_no_surat_tugas' => 'nullable|string|max:255',
            'penghargaan_tanggal_surat_tugas' => 'nullable|date',
            'penghargaan_file_surat_tugas' => 'nullable|string',
            'penghargaan_file_sertifikat' => 'nullable|string',
            'penghargaan_file_poster' => 'nullable|string',
            'penghargaan_photo_kegiatan' => 'nullable|string',
            'penghargaan_score' => 'nullable|numeric',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validasi gagal',
                'msgField' => $validator->errors(),
            ]);
        }

        $prestasi->update($validator->validated());

        return response()->json([
            'status' => true,
            'message' => 'Prestasi berhasil diperbarui',
            'self' => true,
        ]);
    }

    public function confirmAjax($id)
    {
        $prestasi = AdminKelolaPrestasi::findOrFail($id);
        return view('admin.adminKelolaPrestasi.confirm_ajax', compact('prestasi'));
    }

    public function destroyAjax($id)
    {
        $prestasi = AdminKelolaPrestasi::find($id);

        if (!$prestasi) {
            return response()->json([
                'status' => false,
                'message' => 'Data tidak ditemukan.',
            ]);
        }

        DB::beginTransaction();
        try {
            $prestasi->update([
                'penghargaan_judul' => $prestasi->penghargaan_judul . ' (Dihapus pada ' . now()->format('H:i d/m/Y') . ')',
                'penghargaan_visible' => false,
            ]);
            DB::commit();

            return response()->json([
                'status' => true,
                'message' => 'Prestasi berhasil dihapus.',
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'status' => false,
                'message' => 'Gagal menghapus: ' . $e->getMessage(),
            ]);
        }
    }
}
