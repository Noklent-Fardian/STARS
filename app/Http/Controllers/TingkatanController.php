<?php

namespace App\Http\Controllers;

use App\Models\Tingkatan;
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

class TingkatanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $page = (object) [
            'title' => 'Data Tingkatan Lomba',
        ];

        return view('admin.tingkatanLomba.index', compact('page'));
    }

    /**
     * Process datatables ajax request.
     */
    public function getTingkatanList(Request $request)
    {
        $tingkatans = Tingkatan::select('id', 'tingkatan_nama', 'tingkatan_point', 'tingkatan_visible')
            ->where('tingkatan_visible', true);

        return DataTables::of($tingkatans)
            ->addColumn('aksi', function ($tingkatan) {
                $view = '<a href="' . url('/admin/master/tingkatanLomba/show/' . $tingkatan->id) . '" class="btn btn-sm btn-info mr-1"><i class="fas fa-eye"></i> Detail</a>';
                $edit = '<button onclick="modalAction(\'' . route('admin.master.tingkatanLomba.editAjax', $tingkatan->id) . '\')" class="btn btn-sm btn-warning mr-2">
                            <i class="fas fa-edit mr-1"></i> Edit
                        </button>';
                $delete = '<button onclick="modalAction(\'' . route('admin.master.tingkatanLomba.confirmAjax', $tingkatan->id) . '\')" class="btn btn-sm btn-danger mr-2">
                            <i class="fas fa-trash-alt mr-1"></i> Hapus
                        </button>';

                return $view . $edit . $delete;
            })

            ->rawColumns(['aksi'])
            ->make(true);
    }

    /**
     * Show the form for creating a new resource with AJAX.
     */
    public function createAjax()
    {
        return view('admin.tingkatanLomba.create_ajax');
    }

    /**
     * Store a newly created resource in storage with AJAX.
     */
    public function storeAjax(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'tingkatan_nama'  => 'required|string|max:255|unique:m_tingkatans',
            'tingkatan_point' => 'required|integer|min:0',
            '',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status'   => false,
                'message'  => 'Validasi gagal. Periksa kembali data Anda.',
                'msgField' => $validator->errors(),
            ]);
        }

        Tingkatan::create([
            'tingkatan_nama'    => $request->tingkatan_nama,
            'tingkatan_point'   => $request->tingkatan_point,
            'tingkatan_visible' => 1,
        ]);

        return response()->json([
            'status'  => true,
            'message' => 'Tingkatan Lomba berhasil ditambahkan',
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $tingkatan = Tingkatan::find($id);
        $page      = (object) [
            'title' => 'Detail Tingkatan Lomba',
        ];

        return view('admin.tingkatanLomba.show', compact('tingkatan', 'page'));
    }

    /**
     * Show the form for editing the specified resource with AJAX.
     */
    public function editAjax($id)
    {
        $tingkatan = Tingkatan::find($id);

        return view('admin.tingkatanLomba.edit_ajax', compact('tingkatan'));
    }

    /**
     * Update the specified resource in storage with AJAX.
     */ public function updateAjax(Request $request, $id)
    {
        $tingkatan = Tingkatan::find($id);

        $validator = Validator::make($request->all(), [
            'tingkatan_nama'  => [
                'required',
                'string',
                'max:255',
                Rule::unique('m_tingkatans')->ignore($id),
            ],
            'tingkatan_point' => 'required|integer|min:0',

        ]);

        if ($validator->fails()) {
            return response()->json([
                'status'   => false,
                'message'  => 'Validasi gagal. Periksa kembali data Anda.',
                'msgField' => $validator->errors(),
            ]);
        }

        $tingkatan->update([
            'tingkatan_nama'  => $request->tingkatan_nama,
            'tingkatan_point' => $request->tingkatan_point,
        ]);

        return response()->json([
            'status'  => true,
            'message' => 'Tingkatan Lomba berhasil diperbarui',
            'self'    => true,
        ]);
    }

    /**
     * Show confirmation dialog for deleting with AJAX.
     */
    public function confirmAjax($id)
    {
        $tingkatan = Tingkatan::find($id);

        return view('admin.tingkatanLomba.confirm_ajax', compact('tingkatan'));
    }

    /**
     * Remove the specified resource from storage with AJAX.
     */

    public function destroyAjax($id)
    {
        $tingkatan = Tingkatan::find($id);

        if (! $tingkatan) {
            return response()->json([
                'status'  => false,
                'message' => 'Tingkatan Lomba tidak ditemukan',
            ]);
        }

        // Update visibility instead of deleting
        $tingkatan->update([
            'tingkatan_nama'    => $tingkatan->tingkatan_nama . ' (Dihapus on date ' . date('H:i d/m/Y') . ')',
            'tingkatan_visible' => false,
        ]);

        return response()->json([
            'status'  => true,
            'message' => 'Tingkatan Lomba berhasil dihapus',
        ]);
    }

    /**
     * Export data to PDF.
     */
    public function exportPDF()
    {
         $pdfSetting = \App\Models\PdfSetting::first();
        $tingkatans = Tingkatan::where('tingkatan_visible', true)->orderBy('id', 'asc')->get();
        $pdf        = PDF::loadView('admin.tingkatanLomba.export_pdf', compact('tingkatans', 'pdfSetting'));

        return $pdf->download('data-tingkatan-lomba.pdf');
    }
    public function exportExcel()
    {
        // Get only visible tingkatan records
        $tingkatans = Tingkatan::where('tingkatan_visible', true)
            ->orderBy('id', 'asc')
            ->get();

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Set document properties
        $spreadsheet->getProperties()
            ->setCreator('STAR System')
            ->setLastModifiedBy('STAR System')
            ->setTitle('Data Tingkatan Lomba')
            ->setSubject('Tingkatan Lomba Export')
            ->setDescription('Daftar tingkatan lomba yang aktif dalam sistem');

        // Header styling
        $sheet->setCellValue('A1', 'DAFTAR TINGKATAN LOMBA');
        $sheet->mergeCells('A1:D1');
        $sheet->getStyle('A1')->getFont()->setBold(true)->setSize(16);
        $sheet->getStyle('A1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

        // Column headers
        $sheet->setCellValue('A2', 'No');
        $sheet->setCellValue('B2', 'ID');
        $sheet->setCellValue('C2', 'Nama Tingkatan');
        $sheet->setCellValue('D2', 'Poin');

        // Header styling
        $headerStyle = [
            'font' => [
                'bold' => true,
                'color' => ['rgb' => 'FFFFFF']
            ],
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => ['rgb' => '102044'] // Primary color
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
        $sheet->getStyle('A2:D2')->applyFromArray($headerStyle);
        $sheet->getRowDimension(2)->setRowHeight(25);
        $sheet->freezePane('A3');

        // Fill data rows
        $no = 1;
        $row = 3;
        foreach ($tingkatans as $tingkatan) {
            $sheet->setCellValue('A' . $row, $no);
            $sheet->setCellValue('B' . $row, $tingkatan->id);
            $sheet->setCellValue('C' . $row, $tingkatan->tingkatan_nama);
            $sheet->setCellValue('D' . $row, $tingkatan->tingkatan_point);

            // Style for data rows
            $sheet->getStyle('A' . $row . ':D' . $row)->applyFromArray([
                'borders' => [
                    'allBorders' => [
                        'borderStyle' => Border::BORDER_THIN,
                        'color' => ['rgb' => '000000']
                    ]
                ]
            ]);

            // Center align the ID and number columns
            $sheet->getStyle('A' . $row)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle('B' . $row)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

            // Right align the point column
            $sheet->getStyle('D' . $row)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_RIGHT);

            $row++;
            $no++;
        }

        // Auto-size columns
        foreach (range('A', 'D') as $column) {
            $sheet->getColumnDimension($column)->setAutoSize(true);
        }

        // Set active sheet title
        $sheet->setTitle('Tingkatan Lomba');

        // Create Excel file
        $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');

        // Prepare response with proper headers
        $filename = 'Data_Tingkatan_Lomba_' . date('Y-m-d_H-i-s') . '.xlsx';

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

    public function importForm()
    {
        return view('admin.tingkatanLomba.import');
    }

    /**
     * Import data from Excel file
     */
    public function importExcel(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'file_tingkatan' => 'required|mimes:xlsx|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validasi gagal',
                'msgField' => $validator->errors()
            ]);
        }

        $file = $request->file('file_tingkatan');
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

            // Skip header row
            if ($index == 1) {
                continue;
            }

            if (empty($rowData['A']) || empty($rowData['B'])) {
                $errors[] = "Baris $row: Nama Tingkatan dan Poin harus diisi";
                continue;
            }

            // Validate that poin is a number
            if (!is_numeric($rowData['B'])) {
                $errors[] = "Baris $row: Poin harus berupa angka";
                continue;
            }

            // Check for duplicate tingkatan_nama in the database
            $existingTingkatan = Tingkatan::where('tingkatan_nama', $rowData['A'])
                ->where('tingkatan_visible', true)
                ->first();

            if ($existingTingkatan) {
                $duplicateErrors[] = "Baris $row: Nama Tingkatan '{$rowData['A']}' sudah terdaftar";
                continue;
            }

            $insertData[] = [
                'tingkatan_nama' => $rowData['A'],
                'tingkatan_point' => $rowData['B'],
                'tingkatan_visible' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        if (!empty($duplicateErrors)) {
            return response()->json([
                'status' => false,
                'message' => 'Terdapat nama tingkatan yang sudah ada di database. Import dibatalkan.',
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
            Tingkatan::insert($insertData);

            return response()->json([
                'status' => true,
                'message' => 'Data Tingkatan Lomba berhasil diimport'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Gagal mengimport data: ' . $e->getMessage()
            ]);
        }
    }
    
public function generateTemplate()
{
    $spreadsheet = new Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();
    
    // Set headers
    $sheet->setCellValue('A1', 'Nama Tingkatan');
    $sheet->setCellValue('B1', 'Poin');
    
    // Add example data
    $sheet->setCellValue('A2', 'Contoh Tingkatan');
    $sheet->setCellValue('B2', '10');
    
    // Style headers
    $sheet->getStyle('A1:B1')->getFont()->setBold(true);
    $sheet->getStyle('A1:B1')->getFill()
        ->setFillType(Fill::FILL_SOLID)
        ->getStartColor()->setRGB('102044');
    $sheet->getStyle('A1:B1')->getFont()->getColor()->setRGB('FFFFFF');
    
    // Auto size columns
    $sheet->getColumnDimension('A')->setAutoSize(true);
    $sheet->getColumnDimension('B')->setAutoSize(true);
    
    $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
    $path = public_path('excel/template_tingkatan.xlsx');
    
    // Create directory if it doesn't exist
    if (!file_exists(dirname($path))) {
        mkdir(dirname($path), 0755, true);
    }
    
    $writer->save($path);
    
    return response()->download($path, 'template_tingkatan.xlsx');
}
}
