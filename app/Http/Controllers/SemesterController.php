<?php

namespace App\Http\Controllers;

use App\Models\Semester;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Yajra\DataTables\Facades\DataTables;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;

class SemesterController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $page = (object) [
            'title' => 'Data Semester',
        ];

        return view('admin.semester.index', compact('page'));
    }

    /**
     * Process datatables ajax request.
     */
    public function getSemesterList(Request $request)
    {
        $semesters = Semester::select('id', 'semester_nama', 'semester_tahun', 'semester_jenis', 'semester_aktif', 'semester_visible')
            ->where('semester_visible', true);

        return DataTables::of($semesters)
            ->addColumn('aksi', function ($semester) {
                $view = '<a href="' . url('/admin/master/semester/show/' . $semester->id) . '" class="btn btn-sm btn-info mr-1"><i class="fas fa-eye"></i> Detail</a>';
                $edit = '<button onclick="modalAction(\'' . route('admin.master.semester.editAjax', $semester->id) . '\')" class="btn btn-sm btn-warning mr-2">
                            <i class="fas fa-edit mr-1"></i> Edit
                        </button>';
                $delete = '<button onclick="modalAction(\'' . route('admin.master.semester.confirmAjax', $semester->id) . '\')" class="btn btn-sm btn-danger mr-2">
                            <i class="fas fa-trash-alt mr-1"></i> Hapus
                        </button>';

                return $view . $edit . $delete;
            })
            ->addColumn('status_aktif', function ($semester) {
                return $semester->semester_aktif
                    ? '<span class="badge badge-success">Aktif</span>'
                    : '<span class="badge badge-secondary">Non-Aktif</span>';
            })
            ->rawColumns(['aksi', 'status_aktif'])
            ->make(true);
    }

    /**
     * Show the form for creating a new resource with AJAX.
     */
    public function createAjax()
    {
        return view('admin.semester.create_ajax');
    }

    /**
     * Store a newly created resource in storage with AJAX.
     */
    public function storeAjax(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'semester_nama' => 'required|string|max:255|unique:m_semesters',
            'semester_tahun' => 'required|integer|min:2000|max:' . (date('Y') + 5),
            'semester_jenis' => 'required|in:Ganjil,Genap',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status'   => false,
                'message'  => 'Validasi gagal. Periksa kembali data Anda.',
                'msgField' => $validator->errors(),
            ]);
        }


        Semester::create([
            'semester_nama'    => $request->semester_nama,
            'semester_tahun'  => $request->semester_tahun,
            'semester_jenis'   => $request->semester_jenis,
            'semester_aktif'   => false,
            'semester_visible' => true,
        ]);

        return response()->json([
            'status'  => true,
            'message' => 'Semester berhasil ditambahkan',
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $semester = Semester::find($id);
        $page  = (object) [
            'title' => 'Detail Semester',
        ];

        return view('admin.semester.show', compact('semester', 'page'));
    }

    /**
     * Show the form for editing the specified resource with AJAX.
     */
    public function editAjax($id)
    {
        $semester = Semester::find($id);

        return view('admin.semester.edit_ajax', compact('semester'));
    }

    /**
     * Update the specified resource in storage with AJAX.
     */
    public function updateAjax(Request $request, $id)
    {
        $semester = Semester::find($id);

        $validator = Validator::make($request->all(), [
            'semester_nama' => [
                'required',
                'string',
                'max:255',
                Rule::unique('m_semesters')->ignore($id),
            ],
            'semester_tahun' => 'required|integer|min:2000|max:' . (date('Y') + 5),
            'semester_jenis' => 'required|in:Ganjil,Genap',
            'semester_aktif' => 'sometimes|boolean',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status'   => false,
                'message'  => 'Validasi gagal. Periksa kembali data Anda.',
                'msgField' => $validator->errors(),
            ]);
        }

        // Jika semester diubah menjadi aktif, nonaktifkan semua semester aktif lainnya
        if ($request->semester_aktif) {
            Semester::where('semester_aktif', true)
                ->where('id', '!=', $id)
                ->update(['semester_aktif' => false]);
        }

        $semester->update([
            'semester_nama' => $request->semester_nama,
            'semester_tahun' => $request->semester_tahun,
            'semester_jenis' => $request->semester_jenis,
            'semester_aktif' => $request->semester_aktif ?? $semester->semester_aktif,
        ]);

        return response()->json([
            'status'  => true,
            'message' => 'Semester berhasil diperbarui',
            'self'    => true,
        ]);
    }

    /**
     * Show confirmation dialog for deleting with AJAX.
     */
    public function confirmAjax($id)
    {
        $semester = Semester::find($id);

        return view('admin.semester.confirm_ajax', compact('semester'));
    }

    /**
     * Remove the specified resource from storage with AJAX.
     */
    public function destroyAjax($id)
    {
        $semester = Semester::find($id);

        if (!$semester) {
            return response()->json([
                'status'  => false,
                'message' => 'Semester tidak ditemukan',
            ]);
        }

        $semester->update([
            'semester_nama'    => $semester->semester_nama . ' (Dihapus on date ' . date('H:i d/m/Y') . ')',
            'semester_visible' => false,
        ]);

        return response()->json([
            'status'  => true,
            'message' => 'Semester berhasil dihapus',
        ]);
    }

    /**
     * Export data to PDF.
     */
    public function exportPDF()
    {
        $pdfSetting = \App\Models\PdfSetting::first();
        $semesters = Semester::where('semester_visible', true)
            ->orderBy('semester_tahun', 'desc')
            ->orderBy('semester_jenis', 'desc')
            ->get();

        $pdf = PDF::loadView('admin.semester.export_pdf', compact('semesters', 'pdfSetting'))
            ->setPaper('A4', 'landscape');

        return $pdf->download('data-semester.pdf');
    }

    /**
     * Export data to Excel.
     */
    public function exportExcel()
    {
        $semesters = Semester::where('semester_visible', true)
            ->orderBy('semester_tahun', 'desc')
            ->orderBy('semester_jenis', 'desc')
            ->get();

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $spreadsheet->getProperties()
            ->setCreator('STAR System')
            ->setLastModifiedBy('STAR System')
            ->setTitle('Data Semester')
            ->setSubject('Semester Export')
            ->setDescription('Daftar semester yang aktif dalam sistem');

        $sheet->setCellValue('A1', 'DAFTAR SEMESTER');
        $sheet->mergeCells('A1:E1');
        $sheet->getStyle('A1')->getFont()->setBold(true)->setSize(16);
        $sheet->getStyle('A1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

        $sheet->setCellValue('A2', 'No');
        $sheet->setCellValue('B2', 'ID');
        $sheet->setCellValue('C2', 'Nama Semester');
        $sheet->setCellValue('D2', 'Tahun');
        $sheet->setCellValue('E2', 'Jenis');

        $headerStyle = [
            'font' => [
                'bold' => true,
                'color' => ['rgb' => 'FFFFFF']
            ],
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => ['rgb' => '102044']
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical' => Alignment::VERTICAL_CENTER
            ],
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => ['rgb' => '000000']
                ]
            ]
        ];
        $sheet->getStyle('A2:E2')->applyFromArray($headerStyle);
        $sheet->getRowDimension(2)->setRowHeight(25);
        $sheet->freezePane('A3');

        $no = 1;
        $row = 3;
        foreach ($semesters as $semester) {
            $sheet->setCellValue('A' . $row, $no);
            $sheet->setCellValue('B' . $row, $semester->id);
            $sheet->setCellValue('C' . $row, $semester->semester_nama);
            $sheet->setCellValue('D' . $row, $semester->semester_tahun);
            $sheet->setCellValue('E' . $row, $semester->semester_jenis);

            $sheet->getStyle('A' . $row . ':E' . $row)->applyFromArray([
                'borders' => [
                    'allBorders' => [
                        'borderStyle' => Border::BORDER_THIN,
                        'color' => ['rgb' => '000000']
                    ]
                ]
            ]);

            $sheet->getStyle('A' . $row)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle('B' . $row)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle('D' . $row)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle('E' . $row)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

            $row++;
            $no++;
        }

        foreach (range('A', 'E') as $column) {
            $sheet->getColumnDimension($column)->setAutoSize(true);
        }

        $sheet->setTitle('Semester');

        $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');

        $filename = 'Data_Semester_' . date('Y-m-d_H-i-s') . '.xlsx';

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $filename . '"');
        header('Cache-Control: max-age=0');
        header('Cache-Control: max-age=1');
        header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
        header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT');
        header('Cache-Control: cache, must-revalidate');
        header('Pragma: public');

        $writer->save('php://output');
        exit;
    }

    /**
     * Show import form
     */
    public function importForm()
    {
        return view('admin.semester.import');
    }

    /**
     * Import data from Excel
     */
    public function importExcel(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'file_semester' => 'required|mimes:xlsx|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validasi gagal',
                'msgField' => $validator->errors()
            ]);
        }

        $file = $request->file('file_semester');
        $reader = IOFactory::createReader('Xlsx');
        $reader->setReadDataOnly(true);
        $spreadsheet = $reader->load($file->getRealPath());
        $sheet = $spreadsheet->getActiveSheet();
        $data = $sheet->toArray(null, true, true, true);

        $errors = [];
        $duplicateErrors = [];
        $insertData = [];
        $row = 1;

        foreach ($data as $index => $rowData) {
            $row++;

            if ($index == 1) {
                continue;
            }

            if (empty($rowData['A']) || empty($rowData['B']) || empty($rowData['C'])) {
                $errors[] = "Baris $row: Nama Semester, Tahun, dan Jenis harus diisi";
                continue;
            }

            // Validasi jenis semester
            if (!in_array($rowData['C'], ['Ganjil', 'Genap'])) {
                $errors[] = "Baris $row: Jenis Semester harus 'Ganjil' atau 'Genap'";
                continue;
            }

            // Validasi tahun
            if (!is_numeric($rowData['B']) || $rowData['B'] < 2000 || $rowData['B'] > (date('Y') + 5)) {
                $errors[] = "Baris $row: Tahun harus antara 2000 dan " . (date('Y') + 5);
                continue;
            }

            // Check for duplicate semester_nama in the database
            $existingSemesterByName = Semester::where('semester_nama', $rowData['A'])
                ->where('semester_visible', true)
                ->first();

            if ($existingSemesterByName) {
                $duplicateErrors[] = "Baris $row: Nama Semester '{$rowData['A']}' sudah terdaftar";
                continue;
            }

            // Convert active status to proper boolean (1/0)
            $isActive = false;
            if (isset($rowData['D'])) {
                $isActive = filter_var($rowData['D'], FILTER_VALIDATE_BOOLEAN);
            }

            $insertData[] = [
                'semester_nama' => $rowData['A'],
                'semester_tahun' => (int)$rowData['B'],
                'semester_jenis' => $rowData['C'],
                'semester_visible' => true,
                'semester_aktif' => false,
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        if (!empty($duplicateErrors)) {
            return response()->json([
                'status' => false,
                'message' => 'Terdapat nama semester yang sudah ada di database. Import dibatalkan.',
                'errors' => $duplicateErrors
            ]);
        }

        if (!empty($errors)) {
            return response()->json([
                'status' => false,
                'message' => 'Terdapat kesalahan pada data yang diimport',
                'errors' => $errors
            ]);
        }

        if (empty($insertData)) {
            return response()->json([
                'status' => false,
                'message' => 'Tidak ada data valid yang dapat diimport'
            ]);
        }

        try {
            // If any semester is being imported as active, deactivate others first
            $hasActive = collect($insertData)->contains('semester_aktif', 1);
            if ($hasActive) {
                Semester::where('semester_aktif', true)->update(['semester_aktif' => false]);
            }

            Semester::insert($insertData);

            return response()->json([
                'status' => true,
                'message' => 'Data Semester berhasil diimport'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Gagal mengimport data: ' . $e->getMessage()
            ]);
        }
    }

    /**
     * Generate Excel template for import
     */
    public function generateTemplate()
    {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->setCellValue('A1', 'Nama Semester');
        $sheet->setCellValue('B1', 'Tahun');
        $sheet->setCellValue('C1', 'Jenis (Ganjil/Genap)');

        $sheet->setCellValue('A2', 'Semester Ganjil 2023');
        $sheet->setCellValue('B2', '2023');
        $sheet->setCellValue('C2', 'Ganjil');

        $sheet->getStyle('A1:D1')->getFont()->setBold(true);
        $sheet->getStyle('A1:D1')->getFill()
            ->setFillType(Fill::FILL_SOLID)
            ->getStartColor()->setRGB('102044');
        $sheet->getStyle('A1:D1')->getFont()->getColor()->setRGB('FFFFFF');

        $sheet->getColumnDimension('A')->setAutoSize(true);
        $sheet->getColumnDimension('B')->setAutoSize(true);
        $sheet->getColumnDimension('C')->setAutoSize(true);
        $sheet->getColumnDimension('D')->setAutoSize(true);

        $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
        $path = public_path('excel/template_semester.xlsx');

        if (!file_exists(dirname($path))) {
            mkdir(dirname($path), 0755, true);
        }

        $writer->save($path);

        return response()->download($path, 'template_semester.xlsx');
    }
}
