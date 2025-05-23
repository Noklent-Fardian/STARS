<?php

namespace App\Http\Controllers;

use App\Models\Peringkat;
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

class PeringkatController extends Controller
{
    public function index()
    {
        $page = (object) [
            'title' => 'Data Peringkat Lomba',
        ];
        return view('admin.peringkatLomba.index', compact('page'));
    }

    public function getPeringkatList(Request $request)
    {
        $peringkats = Peringkat::select('id', 'peringkat_nama', 'peringkat_bobot', 'peringkat_visible')
            ->where('peringkat_visible', true);

        return DataTables::of($peringkats)
            ->addColumn('aksi', function ($peringkat) {
                $view = '<a href="' . url('/admin/master/peringkatLomba/show/' . $peringkat->id) . '" class="btn btn-sm btn-info mr-1"><i class="fas fa-eye"></i> Detail</a>';
                $edit = '<button onclick="modalAction(\'' . route('admin.master.peringkatLomba.editAjax', $peringkat->id) . '\')" class="btn btn-sm btn-warning mr-2">
                            <i class="fas fa-edit mr-1"></i> Edit
                        </button>';
                $delete = '<button onclick="modalAction(\'' . route('admin.master.peringkatLomba.confirmAjax', $peringkat->id) . '\')" class="btn btn-sm btn-danger mr-2">
                            <i class="fas fa-trash-alt mr-1"></i> Hapus
                        </button>';

                return $view . $edit . $delete;
            })
            ->editColumn('peringkat_bobot', function ($peringkat) {
                return number_format((float) $peringkat->peringkat_bobot, 2, '.', '');
            })
            ->rawColumns(['aksi'])
            ->make(true);
    }

    public function createAjax()
    {
        return view('admin.peringkatLomba.create_ajax');
    }

    public function storeAjax(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'peringkat_nama'  => 'required|string|max:255|unique:m_peringkats',
            'peringkat_bobot' => 'required|numeric|min:0',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status'   => false,
                'message'  => 'Validasi gagal. Periksa kembali data Anda!',
                'msgField' => $validator->errors(),
            ]);
        }

        $peringkat_bobot = number_format($request->peringkat_bobot, 2, '.', '');

        Peringkat::create([
            'peringkat_nama'    => $request->peringkat_nama,
            'peringkat_bobot'   => $request->peringkat_bobot,
            'peringkat_visible' => 1,
        ]);

        return response()->json([
            'status'  => true,
            'message' => 'Peringkat Lomba berhasil ditambahkan',
        ]);
    }

    public function show($id)
    {
        $peringkat = Peringkat::find($id);
        $page      = (object) [
            'title' => 'Detail Peringkat Lomba',
        ];

        $peringkat->peringkat_bobot = number_format($peringkat->peringkat_bobot, 2, '.', '');

        return view('admin.peringkatLomba.show', compact('peringkat', 'page'));
    }

    public function editAjax($id)
    {
        $peringkat = Peringkat::find($id);

        return view('admin.peringkatLomba.edit_ajax', compact('peringkat'));
    }

    public function updateAjax(Request $request, $id)
    {
        $peringkat = Peringkat::find($id);

        $validator = Validator::make($request->all(), [
            'peringkat_nama'  => [
                'required',
                'string',
                'max:255',
                Rule::unique('m_peringkats')->ignore($id),
            ],
            'peringkat_bobot' => 'required|numeric|min:0',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status'   => false,
                'message'  => 'Validasi gagal. Periksa kembali data Anda!',
                'msgField' => $validator->errors(),
            ]);
        }

        $peringkat_bobot = number_format($request->peringkat_bobot, 2, '.', '');

        $peringkat->update([
            'peringkat_nama'  => $request->peringkat_nama,
            'peringkat_bobot' => $request->peringkat_bobot,
        ]);

        return response()->json([
            'status'  => true,
            'message' => 'Peringkat Lomba berhasil diperbarui',
            'self'    => true,
        ]);
    }

    public function confirmAjax($id)
    {
        $peringkat = Peringkat::find($id);

        return view('admin.peringkatLomba.confirm_ajax', compact('peringkat'));
    }

    public function destroyAjax($id)
    {
        $peringkat = Peringkat::find($id);

        if (! $peringkat) {
            return response()->json([
                'status'  => false,
                'message' => 'Peringkat Lomba tidak ditemukan',
            ]);
        }

        // Update visibility
        $peringkat->update([
            'peringkat_nama'    => $peringkat->peringkat_nama . ' (Dihapus on date ' . date('H:i d/m/Y') . ')',
            'peringkat_visible' => false,
        ]);

        return response()->json([
            'status'  => true,
            'message' => 'Peringkat Lomba berhasil dihapus',
        ]);
    }

    public function exportPDF()
    {
        $pdfSetting = \App\Models\PdfSetting::first();

        $peringkats = Peringkat::where('peringkat_visible', true)->orderBy('peringkat_bobot', 'desc')->get();
        $pdf        = PDF::loadView('admin.peringkatLomba.export_pdf', compact('peringkats', 'pdfSetting'));

        return $pdf->download('data-peringkat-lomba.pdf');
    }

    public function exportExcel()
    {
        $peringkats = Peringkat::where('peringkat_visible', true)
            ->orderBy('peringkat_bobot', 'desc')
            ->get();

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $spreadsheet->getProperties()
            ->setCreator('STAR System')
            ->setLastModifiedBy('STAR System')
            ->setTitle('Data Peringkat Lomba')
            ->setSubject('Peringkat Lomba Export')
            ->setDescription('Daftar peringkat lomba yang aktif dalam sistem');

        $sheet->setCellValue('A1', 'DAFTAR PERINGKAT LOMBA');
        $sheet->mergeCells('A1:D1');
        $sheet->getStyle('A1')->getFont()->setBold(true)->setSize(16);
        $sheet->getStyle('A1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

        $sheet->setCellValue('A2', 'No');
        $sheet->setCellValue('B2', 'ID');
        $sheet->setCellValue('C2', 'Nama Peringkat');
        $sheet->setCellValue('D2', 'Bobot');

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
        foreach ($peringkats as $peringkat) {
            $sheet->setCellValue('A' . $row, $no);
            $sheet->setCellValue('B' . $row, $peringkat->id);
            $sheet->setCellValue('C' . $row, $peringkat->peringkat_nama);
            $sheet->setCellValue('D' . $row, number_format($peringkat->peringkat_bobot, 2, '.', ''));

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
            $sheet->getStyle('D' . $row)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_RIGHT);

            $row++;
            $no++;
        }

        foreach (range('A', 'D') as $column) {
            $sheet->getColumnDimension($column)->setAutoSize(true);
        }

        $sheet->setTitle('Peringkat Lomba');

        $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');

        $filename = 'Data_Peringkat_Lomba_' . date('Y-m-d_H-i-s') . '.xlsx';

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
        return view('admin.peringkatLomba.import');
    }

    public function importExcel(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'file_peringkat' => 'required|mimes:xlsx|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validasi gagal',
                'msgField' => $validator->errors()
            ]);
        }

        $file = $request->file('file_peringkat');
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
                $errors[] = "Baris $row: Nama Peringkat dan Bobot harus diisi";
                continue;
            }

            if (!is_numeric($rowData['B'])) {
                $errors[] = "Baris $row: Bobot harus berupa angka";
                continue;
            }

            $existingPeringkat = Peringkat::where('peringkat_nama', $rowData['A'])
                ->where('peringkat_visible', true)
                ->first();

            if ($existingPeringkat) {
                $duplicateErrors[] = "Baris $row: Nama Peringkat '{$rowData['A']}' sudah terdaftar";
                continue;
            }

            $insertData[] = [
                'peringkat_nama' => $rowData['A'],
                'peringkat_bobot' => $rowData['B'],
                'peringkat_visible' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        if (!empty($duplicateErrors)) {
            return response()->json([
                'status' => false,
                'message' => 'Terdapat nama peringkat yang sudah ada di database. Import dibatalkan.',
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
            Peringkat::insert($insertData);

            return response()->json([
                'status' => true,
                'message' => 'Data Peringkat Lomba berhasil diimport'
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

        $sheet->setCellValue('A1', 'Nama Peringkat');
        $sheet->setCellValue('B1', 'Bobot');

        $sheet->setCellValue('A2', 'Contoh Peringkat');
        $sheet->setCellValue('B2', '1.00');

        $sheet->getStyle('A1:B1')->getFont()->setBold(true);
        $sheet->getStyle('A1:B1')->getFill()
            ->setFillType(Fill::FILL_SOLID)
            ->getStartColor()->setRGB('102044');
        $sheet->getStyle('A1:B1')->getFont()->getColor()->setRGB('FFFFFF');

        $sheet->getColumnDimension('A')->setAutoSize(true);
        $sheet->getColumnDimension('B')->setAutoSize(true);

        $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
        $path = public_path('excel/template_peringkat.xlsx');

        if (!file_exists(dirname($path))) {
            mkdir(dirname($path), 0755, true);
        }

        $writer->save($path);

        return response()->download($path, 'template_peringkat.xlsx');
    }
}
