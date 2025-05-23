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

    public function exportPDF()
    {
        $prestasi = AdminKelolaPrestasi::with(['mahasiswa', 'lomba', 'peringkat', 'tingkatan'])
            ->where('penghargaan_visible', true)
            ->get();

        $pdf = Pdf::loadView('admin.adminKelolaPrestasi.export_pdf', compact('prestasi'));
        return $pdf->download('data_prestasi.pdf');
    }

    public function exportExcel()
    {
        $prestasi = AdminKelolaPrestasi::with(['mahasiswa', 'lomba', 'peringkat', 'tingkatan'])
            ->where('penghargaan_visible', true)
            ->get();

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Header
        $headers = [
            'ID', 'Mahasiswa', 'Lomba', 'Peringkat', 'Tingkatan', 'Judul', 'Tempat', 'Tanggal Mulai', 'Tanggal Selesai',
            'Jumlah Peserta', 'Jumlah Instansi', 'No Surat Tugas', 'Tanggal Surat', 'File Surat', 'File Sertifikat',
            'File Poster', 'Foto Kegiatan', 'Skor', 'Visible'
        ];
        $col = 'A';
        foreach ($headers as $header) {
            $sheet->setCellValue($col . '1', $header);
            $col++;
        }

        // Data
        $row = 2;
        foreach ($prestasi as $item) {
            $sheet->setCellValue('A' . $row, $item->id);
            $sheet->setCellValue('B' . $row, $item->mahasiswa->mahasiswa_nama ?? '-');
            $sheet->setCellValue('C' . $row, $item->lomba->lomba_nama ?? '-');
            $sheet->setCellValue('D' . $row, $item->peringkat->peringkat_nama ?? '-');
            $sheet->setCellValue('E' . $row, $item->tingkatan->tingkatan_nama ?? '-');
            $sheet->setCellValue('F' . $row, $item->penghargaan_judul);
            $sheet->setCellValue('G' . $row, $item->penghargaan_tempat);
            $sheet->setCellValue('H' . $row, $item->penghargaan_tanggal_mulai);
            $sheet->setCellValue('I' . $row, $item->penghargaan_tanggal_selesai);
            $sheet->setCellValue('J' . $row, $item->penghargaan_jumlah_peserta);
            $sheet->setCellValue('K' . $row, $item->penghargaan_jumlah_instansi);
            $sheet->setCellValue('L' . $row, $item->penghargaan_no_surat_tugas);
            $sheet->setCellValue('M' . $row, $item->penghargaan_tanggal_surat_tugas);
            $sheet->setCellValue('N' . $row, $item->penghargaan_file_surat_tugas);
            $sheet->setCellValue('O' . $row, $item->penghargaan_file_sertifikat);
            $sheet->setCellValue('P' . $row, $item->penghargaan_file_poster);
            $sheet->setCellValue('Q' . $row, $item->penghargaan_photo_kegiatan);
            $sheet->setCellValue('R' . $row, $item->penghargaan_score);
            $sheet->setCellValue('S' . $row, $item->penghargaan_visible ? 'Ya' : 'Tidak');
            $row++;
        }

        $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
        $filename = 'data_prestasi.xlsx';

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $filename . '"');
        header('Cache-Control: max-age=0');
        $writer->save('php://output');
        exit;
    }

    public function importForm()
    {
        return view('admin.adminKelolaPrestasi.import');
    }

    public function importExcel(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'file_prestasi' => 'required|mimes:xlsx,xls|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validasi gagal',
                'msgField' => $validator->errors()
            ]);
        }

        try {
            $file = $request->file('file_prestasi');
            $spreadsheet = IOFactory::load($file->getRealPath());
            $sheet = $spreadsheet->getActiveSheet();

            $data = $sheet->toArray();
            $headers = array_shift($data);

            $expectedHeaders = [
                'Mahasiswa ID',
                'Lomba ID',
                'Peringkat ID',
                'Tingkatan ID',
                'Judul',
                'Tempat',
                'Tanggal Mulai',
                'Tanggal Selesai',
                'Jumlah Peserta',
                'Jumlah Instansi',
                'No Surat Tugas',
                'Tanggal Surat',
                'File Surat',
                'File Sertifikat',
                'File Poster',
                'Foto Kegiatan',
                'Skor'
            ];

            if ($headers !== $expectedHeaders) {
                return response()->json([
                    'status' => false,
                    'message' => 'Format header tidak sesuai. Silakan download template terlebih dahulu.'
                ]);
            }

            $errors = [];
            $duplicateErrors = [];
            $insertData = [];

            foreach ($data as $rowIndex => $row) {
                $rowNumber = $rowIndex + 2;

                if (empty(array_filter($row))) {
                    continue;
                }

                if (empty($row[0]) || empty($row[1]) || empty($row[2]) || empty($row[3]) || empty($row[4])) {
                    $errors[] = "Baris $rowNumber: Data wajib diisi (Mahasiswa ID, Lomba ID, Peringkat ID, Tingkatan ID, Judul)";
                    continue;
                }

                $existing = AdminKelolaPrestasi::where('mahasiswa_id', $row[0])
                    ->where('lomba_id', $row[1])
                    ->where('penghargaan_judul', $row[4])
                    ->where('penghargaan_visible', true)
                    ->exists();

                if ($existing) {
                    $duplicateErrors[] = "Baris $rowNumber: Prestasi dengan judul '{$row[4]}' sudah terdaftar untuk mahasiswa dan lomba ini";
                    continue;
                }

                try {
                    $tanggal_mulai = date_format(date_create($row[6]), 'Y-m-d');
                    $tanggal_selesai = date_format(date_create($row[7]), 'Y-m-d');
                } catch (\Exception $e) {
                    $errors[] = "Baris $rowNumber: Format tanggal tidak valid (harus YYYY-MM-DD)";
                    continue;
                }

                if ($tanggal_selesai < $tanggal_mulai) {
                    $errors[] = "Baris $rowNumber: Tanggal selesai harus setelah tanggal mulai";
                    continue;
                }

                $insertData[] = [
                    'mahasiswa_id' => $row[0],
                    'lomba_id' => $row[1],
                    'peringkat_id' => $row[2],
                    'tingkatan_id' => $row[3],
                    'penghargaan_judul' => $row[4],
                    'penghargaan_tempat' => $row[5],
                    'penghargaan_tanggal_mulai' => $tanggal_mulai,
                    'penghargaan_tanggal_selesai' => $tanggal_selesai,
                    'penghargaan_jumlah_peserta' => $row[8] ?? null,
                    'penghargaan_jumlah_instansi' => $row[9] ?? null,
                    'penghargaan_no_surat_tugas' => $row[10] ?? null,
                    'penghargaan_tanggal_surat_tugas' => $row[11] ?? null,
                    'penghargaan_file_surat_tugas' => $row[12] ?? null,
                    'penghargaan_file_sertifikat' => $row[13] ?? null,
                    'penghargaan_file_poster' => $row[14] ?? null,
                    'penghargaan_photo_kegiatan' => $row[15] ?? null,
                    'penghargaan_score' => $row[16] ?? null,
                    'penghargaan_visible' => true,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }

            if (!empty($duplicateErrors)) {
                return response()->json([
                    'status' => false,
                    'message' => 'Terdapat prestasi yang sudah ada di database',
                    'errors' => $duplicateErrors
                ]);
            }

            if (!empty($errors)) {
                return response()->json([
                    'status' => false,
                    'message' => 'Terdapat kesalahan pada data',
                    'errors' => $errors
                ]);
            }

            if (empty($insertData)) {
                return response()->json([
                    'status' => false,
                    'message' => 'Tidak ada data yang valid untuk diimport'
                ]);
            }

            DB::beginTransaction();
            try {
                AdminKelolaPrestasi::insert($insertData);
                DB::commit();

                return response()->json([
                    'status' => true,
                    'message' => 'Berhasil mengimport ' . count($insertData) . ' data prestasi',
                    'count' => count($insertData)
                ]);
            } catch (\Exception $e) {
                DB::rollBack();
                return response()->json([
                    'status' => false,
                    'message' => 'Gagal menyimpan data: ' . $e->getMessage()
                ]);
            }

        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Error membaca file: ' . $e->getMessage()
            ]);
        }
    }

    public function generateTemplate()
    {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->setCellValue('A1', 'Mahasiswa ID');
        $sheet->setCellValue('B1', 'Lomba ID');
        $sheet->setCellValue('C1', 'Peringkat ID');
        $sheet->setCellValue('D1', 'Tingkatan ID');
        $sheet->setCellValue('E1', 'Judul');
        $sheet->setCellValue('F1', 'Tempat');
        $sheet->setCellValue('G1', 'Tanggal Mulai');
        $sheet->setCellValue('H1', 'Tanggal Selesai');
        $sheet->setCellValue('I1', 'Jumlah Peserta');
        $sheet->setCellValue('J1', 'Jumlah Instansi');
        $sheet->setCellValue('K1', 'No Surat Tugas');
        $sheet->setCellValue('L1', 'Tanggal Surat');
        $sheet->setCellValue('M1', 'File Surat');
        $sheet->setCellValue('N1', 'File Sertifikat');
        $sheet->setCellValue('O1', 'File Poster');
        $sheet->setCellValue('P1', 'Foto Kegiatan');
        $sheet->setCellValue('Q1', 'Skor');

        // Contoh data pada baris kedua
        $sheet->setCellValue('A2', '1');
        $sheet->setCellValue('B2', '1');
        $sheet->setCellValue('C2', '1');
        $sheet->setCellValue('D2', '1');
        $sheet->setCellValue('E2', 'Juara 1 Lomba Web');
        $sheet->setCellValue('F2', 'Jakarta');
        $sheet->setCellValue('G2', '2025-05-01');
        $sheet->setCellValue('H2', '2025-05-03');
        $sheet->setCellValue('I2', '100');
        $sheet->setCellValue('J2', '10');
        $sheet->setCellValue('K2', '123/ABC/2025');
        $sheet->setCellValue('L2', '2025-04-20');
        $sheet->setCellValue('M2', 'file_surat.pdf');
        $sheet->setCellValue('N2', 'file_sertifikat.pdf');
        $sheet->setCellValue('O2', 'file_poster.jpg');
        $sheet->setCellValue('P2', 'foto_kegiatan.jpg');
        $sheet->setCellValue('Q2', '90');

        $sheet->getStyle('A1:Q1')->getFont()->setBold(true);
        $sheet->getStyle('A1:Q1')->getFill()
            ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
            ->getStartColor()->setRGB('102044');
        $sheet->getStyle('A1:Q1')->getFont()->getColor()->setRGB('FFFFFF');

        foreach (range('A', 'Q') as $column) {
            $sheet->getColumnDimension($column)->setAutoSize(true);
        }

        $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
        $path = public_path('excel/template_prestasi.xlsx');

        if (!file_exists(dirname($path))) {
            mkdir(dirname($path), 0755, true);
        }

        $writer->save($path);

        return response()->download($path, 'template_prestasi.xlsx');
    }
}
