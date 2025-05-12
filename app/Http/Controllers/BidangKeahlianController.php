<?php

namespace App\Http\Controllers;

use App\Models\Keahlian;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use Illuminate\Validation\Rule;
use Yajra\DataTables\Facades\DataTables;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;

class BidangKeahlianController extends Controller
{
    public function index()
    {
        $keahlians = Keahlian::all(); // Ambil semua data dari tabel m_keahlians
        return view('admin.bidangKeahlian.index', compact('keahlians'));
    }

    public function getBidangKeahlianList(Request $request)
    {
        // Ambil data bidang keahlian
        $bidangKeahlian = Keahlian::select('id', 'keahlian_nama', 'keahlian_sertifikat', 'keahlian_visible')
            ->where('keahlian_visible', true);

        // Cek jika request datang dari DataTables
        if ($request->ajax()) {
            return DataTables::of($bidangKeahlian)
                // Menambahkan kolom aksi (untuk edit, view, delete)
                ->addColumn('aksi', function ($keahlian) {
                    $view = '<a href="' . url('/admin/master/bidangKeahlian/show/' . $keahlian->id) . '" class="btn btn-sm btn-info mr-1"><i class="fas fa-eye"></i> Detail</a>';
                    $edit = '<button onclick="modalAction(\'' . route('admin.master.bidangKeahlian.editAjax', $keahlian->id) . '\')" class="btn btn-sm btn-warning mr-2">
                                <i class="fas fa-edit mr-1"></i> Edit
                            </button>';
                    $delete = '<button onclick="modalAction(\'' . route('admin.master.bidangKeahlian.confirmAjax', $keahlian->id) . '\')" class="btn btn-sm btn-danger mr-2">
                                <i class="fas fa-trash-alt mr-1"></i> Hapus
                            </button>';

                    // Gabungkan tombol aksi
                    return $view . $edit . $delete;
                })
                // Format kolom bobot atau nilai yang ingin ditampilkan dalam format tertentu (jika ada)
                ->editColumn('keahlian_nama', function ($keahlian) {
                    return $keahlian->keahlian_nama;
                })
                // Menambahkan rawColumns untuk kolom aksi agar bisa merender HTML seperti tombol
                ->rawColumns(['aksi'])
                // Kembalikan response berupa JSON DataTables
                ->make(true);
        }
    }

    public function createAjax()
    {
        return view('admin.bidangKeahlian.create_ajax');
    }

    public function storeAjax(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'keahlian_nama' => 'required|string|max:255',
            'keahlian_sertifikat' => 'nullable|string|max:255',
            // keahlian_visible tidak perlu divalidasi karena akan diset default true
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validasi gagal',
                'msgField' => $validator->errors()
            ]);
        }

        // Ambil input dan tambahkan nilai default untuk keahlian_visible
        $data = $request->only(['keahlian_nama', 'keahlian_sertifikat']);
        $data['keahlian_visible'] = true;

        Keahlian::create($data);

        return response()->json([
            'status' => true,
            'message' => 'Data berhasil disimpan'
        ]);
    }


    public function editAjax($id)
    {
        $keahlian = Keahlian::find($id);
        return view('admin.bidangKeahlian.edit_ajax', compact('keahlian'));
    }

    public function updateAjax(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'keahlian_nama' => 'required|string|max:255',
            'keahlian_sertifikat' => 'nullable|string|max:255',
            // Hapus validasi keahlian_visible
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validasi gagal',
                'msgField' => $validator->errors()
            ]);
        }

        $keahlian = Keahlian::find($id);

        if (!$keahlian) {
            return response()->json([
                'status' => false,
                'message' => 'Data tidak ditemukan'
            ]);
        }

        // Ambil data yang diizinkan diubah
        $data = $request->only(['keahlian_nama', 'keahlian_sertifikat']);

        $keahlian->update($data);

        return response()->json([
            'status' => true,
            'message' => 'Data berhasil diperbarui'
        ]);
    }

    public function confirmAjax($id)
    {
        $keahlian = Keahlian::findOrFail($id);
        return view('admin.bidangKeahlian.confirm_ajax', compact('keahlian'));
    }

    public function deleteAjax($id)
    {
        $keahlian = Keahlian::find($id);
        $keahlian->delete();

        return response()->json([
            'status' => true,
            'message' => 'Data berhasil dihapus'
        ]);
    }

    public function show($id)
    {
        $keahlian = Keahlian::find($id);
        return view('admin.bidangKeahlian.show', compact('keahlian'));
    }

    public function exportPdf()
    {
        $keahlians = Keahlian::orderBy('keahlian_nama')->get();

        $pdf = Pdf::loadView('keahlian.export_pdf', compact('keahlians'))
            ->setPaper('a4', 'portrait');

        return $pdf->download('Laporan_Bidang_Keahlian.pdf');
    }

    public function exportExcel()
    {
        $data = Keahlian::orderBy('nama', 'asc')->get();

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->setCellValue('A1', 'DAFTAR BIDANG KEAHLIAN');
        $sheet->mergeCells('A1:B1');
        $sheet->getStyle('A1')->getFont()->setBold(true)->setSize(16);
        $sheet->getStyle('A1')->getAlignment()->setHorizontal('center');

        $sheet->setCellValue('A2', 'No');
        $sheet->setCellValue('B2', 'Nama Bidang Keahlian');

        $row = 3;
        foreach ($data as $index => $item) {
            $sheet->setCellValue('A' . $row, $index + 1);
            $sheet->setCellValue('B' . $row, $item->nama);
            $row++;
        }

        foreach (range('A', 'B') as $column) {
            $sheet->getColumnDimension($column)->setAutoSize(true);
        }

        $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
        $filename = 'Data_Bidang_Keahlian_' . date('Ymd_His') . '.xlsx';

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header("Content-Disposition: attachment; filename=\"$filename\"");
        $writer->save('php://output');
        exit;
    }

    public function importExcel(Request $request)
    {
        $request->validate([
            'file_bidang' => 'required|mimes:xlsx|max:2048',
        ]);

        $file = $request->file('file_bidang');
        $reader = IOFactory::createReader('Xlsx');
        $spreadsheet = $reader->load($file->getRealPath());
        $sheet = $spreadsheet->getActiveSheet();
        $rows = $sheet->toArray();

        $errors = [];
        $insert = [];

        foreach ($rows as $index => $row) {
            if ($index === 0) continue;

            $nama = trim($row[0]);
            if (empty($nama)) {
                $errors[] = "Baris " . ($index + 1) . ": Nama tidak boleh kosong";
                continue;
            }

            if (Keahlian::where('nama', $nama)->exists()) {
                $errors[] = "Baris " . ($index + 1) . ": '$nama' sudah ada";
                continue;
            }

            $insert[] = ['nama' => $nama, 'created_at' => now(), 'updated_at' => now()];
        }

        if ($errors) {
            return response()->json([
                'status' => false,
                'message' => 'Import gagal',
                'errors' => $errors
            ]);
        }

        Keahlian::insert($insert);

        return response()->json([
            'status' => true,
            'message' => 'Import berhasil'
        ]);
    }

    public function generateTemplate()
    {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setCellValue('A1', 'Nama Bidang Keahlian');
        $sheet->setCellValue('A2', 'Contoh Keahlian');

        $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
        $path = public_path('excel/template_bidang_keahlian.xlsx');
        if (!file_exists(dirname($path))) {
            mkdir(dirname($path), 0755, true);
        }
        $writer->save($path);

        return response()->download($path);
    }
}