<?php

namespace App\Http\Controllers;

use App\Models\Prodi;
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

class ProdiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $page = (object) [
            'title' => 'Data Program Studi',
        ];

        return view('admin.prodi.index', compact('page'));
    }

    /**
     * Process datatables ajax request.
     */
    public function getProdiList(Request $request)
    {
        $prodis = Prodi::select('id', 'prodi_nama', 'prodi_kode', 'prodi_visible')
            ->where('prodi_visible', true);

        return DataTables::of($prodis)
            ->addColumn('aksi', function ($prodi) {
                $view = '<a href="' . url('/admin/master/prodi/show/' . $prodi->id) . '" class="btn btn-sm btn-info mr-1"><i class="fas fa-eye"></i> Detail</a>';
                $edit = '<button onclick="modalAction(\'' . route('admin.master.prodi.editAjax', $prodi->id) . '\')" class="btn btn-sm btn-warning mr-2">
                            <i class="fas fa-edit mr-1"></i> Edit
                        </button>';
                $delete = '<button onclick="modalAction(\'' . route('admin.master.prodi.confirmAjax', $prodi->id) . '\')" class="btn btn-sm btn-danger mr-2">
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
        return view('admin.prodi.create_ajax');
    }

    /**
     * Store a newly created resource in storage with AJAX.
     */
    public function storeAjax(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'prodi_nama' => 'required|string|max:255|unique:m_prodis',
            'prodi_kode' => 'required|string|max:10|unique:m_prodis',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status'   => false,
                'message'  => 'Validasi gagal. Periksa kembali data Anda.',
                'msgField' => $validator->errors(),
            ]);
        }

        Prodi::create([
            'prodi_nama'    => $request->prodi_nama,
            'prodi_kode'    => $request->prodi_kode,
            'prodi_visible' => true,
        ]);

        return response()->json([
            'status'  => true,
            'message' => 'Program Studi berhasil ditambahkan',
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $prodi = Prodi::find($id);
        $page  = (object) [
            'title' => 'Detail Program Studi',
        ];

        return view('admin.prodi.show', compact('prodi', 'page'));
    }

    /**
     * Show the form for editing the specified resource with AJAX.
     */
    public function editAjax($id)
    {
        $prodi = Prodi::find($id);

        return view('admin.prodi.edit_ajax', compact('prodi'));
    }

    /**
     * Update the specified resource in storage with AJAX.
     */
    public function updateAjax(Request $request, $id)
    {
        $prodi = Prodi::find($id);

        $validator = Validator::make($request->all(), [
            'prodi_nama' => [
                'required',
                'string',
                'max:255',
                Rule::unique('m_prodis')->ignore($id),
            ],
            'prodi_kode' => [
                'required',
                'string',
                'max:10',
                Rule::unique('m_prodis')->ignore($id),
            ],
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status'   => false,
                'message'  => 'Validasi gagal. Periksa kembali data Anda.',
                'msgField' => $validator->errors(),
            ]);
        }

        $prodi->update([
            'prodi_nama' => $request->prodi_nama,
            'prodi_kode' => $request->prodi_kode,
        ]);

        return response()->json([
            'status'  => true,
            'message' => 'Program Studi berhasil diperbarui',
            'self'    => true,
        ]);
    }

    /**
     * Show confirmation dialog for deleting with AJAX.
     */
    public function confirmAjax($id)
    {
        $prodi = Prodi::find($id);

        return view('admin.prodi.confirm_ajax', compact('prodi'));
    }

    /**
     * Remove the specified resource from storage with AJAX.
     */
    public function destroyAjax($id)
    {
        $prodi = Prodi::find($id);

        if (! $prodi) {
            return response()->json([
                'status'  => false,
                'message' => 'Program Studi tidak ditemukan',
            ]);
        }

        $prodi->update([
            'prodi_nama'    => $prodi->prodi_nama . ' (Dihapus on date ' . date('H:i d/m/Y') . ')',
            'prodi_visible' => false,
            'prodi_kode'    => $prodi->prodi_kode . ' (Dihapus on date ' . date('H:i d/m/Y') . ')',
        ]);

        return response()->json([
            'status'  => true,
            'message' => 'Program Studi berhasil dihapus',
        ]);
    }

    /**
     * Export data to PDF.
     */
    public function exportPDF()
    {
         $pdfSetting = \App\Models\PdfSetting::first();
        $prodis = Prodi::where('prodi_visible', true)->orderBy('prodi_nama', 'asc')->get();
        $pdf    = PDF::loadView('admin.prodi.export_pdf', compact('prodis', 'pdfSetting'));

        return $pdf->download('data-prodi.pdf');
    }
    
    /**
     * Export data to Excel.
     */
    public function exportExcel()
    {
        $prodis = Prodi::where('prodi_visible', true)
            ->orderBy('prodi_nama', 'asc')
            ->get();

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $spreadsheet->getProperties()
            ->setCreator('STAR System')
            ->setLastModifiedBy('STAR System')
            ->setTitle('Data Program Studi')
            ->setSubject('Program Studi Export')
            ->setDescription('Daftar program studi yang aktif dalam sistem');

        $sheet->setCellValue('A1', 'DAFTAR PROGRAM STUDI');
        $sheet->mergeCells('A1:D1');
        $sheet->getStyle('A1')->getFont()->setBold(true)->setSize(16);
        $sheet->getStyle('A1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

        $sheet->setCellValue('A2', 'No');
        $sheet->setCellValue('B2', 'ID');
        $sheet->setCellValue('C2', 'Kode Prodi');
        $sheet->setCellValue('D2', 'Nama Prodi');

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
        $sheet->getStyle('A2:D2')->applyFromArray($headerStyle);
        $sheet->getRowDimension(2)->setRowHeight(25);
        $sheet->freezePane('A3');

        $no = 1;
        $row = 3;
        foreach ($prodis as $prodi) {
            $sheet->setCellValue('A' . $row, $no);
            $sheet->setCellValue('B' . $row, $prodi->id);
            $sheet->setCellValue('C' . $row, $prodi->prodi_kode);
            $sheet->setCellValue('D' . $row, $prodi->prodi_nama);

            $sheet->getStyle('A' . $row . ':D' . $row)->applyFromArray([
                'borders' => [
                    'allBorders' => [
                        'borderStyle' => Border::BORDER_THIN,
                        'color' => ['rgb' => '000000']
                    ]
                ]
            ]);

            $sheet->getStyle('A' . $row)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle('B' . $row)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle('C' . $row)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

            $row++;
            $no++;
        }

        foreach (range('A', 'D') as $column) {
            $sheet->getColumnDimension($column)->setAutoSize(true);
        }

        $sheet->setTitle('Program Studi');

        $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');

        $filename = 'Data_Program_Studi_' . date('Y-m-d_H-i-s') . '.xlsx';

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
        return view('admin.prodi.import');
    }

    /**
     * Import data from Excel
     */
    public function importExcel(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'file_prodi' => 'required|mimes:xlsx|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validasi gagal',
                'msgField' => $validator->errors()
            ]);
        }

        $file = $request->file('file_prodi');
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

            if (empty($rowData['A']) || empty($rowData['B'])) {
                $errors[] = "Baris $row: Nama Prodi dan Kode Prodi harus diisi";
                continue;
            }

            // Check for duplicate prodi_nama in the database
            $existingProdiByName = Prodi::where('prodi_nama', $rowData['A'])
                ->where('prodi_visible', true)
                ->first();

            // Check for duplicate prodi_kode in the database
            $existingProdiByKode = Prodi::where('prodi_kode', $rowData['B'])
                ->where('prodi_visible', true)
                ->first();

            if ($existingProdiByName) {
                $duplicateErrors[] = "Baris $row: Nama Prodi '{$rowData['A']}' sudah terdaftar";
                continue;
            }

            if ($existingProdiByKode) {
                $duplicateErrors[] = "Baris $row: Kode Prodi '{$rowData['B']}' sudah terdaftar";
                continue;
            }

            $insertData[] = [
                'prodi_nama' => $rowData['A'],
                'prodi_kode' => $rowData['B'],
                'prodi_visible' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        if (!empty($duplicateErrors)) {
            return response()->json([
                'status' => false,
                'message' => 'Terdapat nama atau kode prodi yang sudah ada di database. Import dibatalkan.',
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
            Prodi::insert($insertData);

            return response()->json([
                'status' => true,
                'message' => 'Data Program Studi berhasil diimport'
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
        
        $sheet->setCellValue('A1', 'Nama Prodi');
        $sheet->setCellValue('B1', 'Kode Prodi');
        
        $sheet->setCellValue('A2', 'Contoh Program Studi');
        $sheet->setCellValue('B2', 'PS-001');
        
        $sheet->getStyle('A1:B1')->getFont()->setBold(true);
        $sheet->getStyle('A1:B1')->getFill()
            ->setFillType(Fill::FILL_SOLID)
            ->getStartColor()->setRGB('102044');
        $sheet->getStyle('A1:B1')->getFont()->getColor()->setRGB('FFFFFF');
        
        $sheet->getColumnDimension('A')->setAutoSize(true);
        $sheet->getColumnDimension('B')->setAutoSize(true);
        
        $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
        $path = public_path('excel/template_prodi.xlsx');
        
        if (!file_exists(dirname($path))) {
            mkdir(dirname($path), 0755, true);
        }
        
        $writer->save($path);
        
        return response()->download($path, 'template_prodi.xlsx');
    }
}