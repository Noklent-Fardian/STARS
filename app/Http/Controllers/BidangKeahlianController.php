<?php

namespace App\Http\Controllers;

use App\Models\Keahlian;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use App\Models\Mahasiswa;
use App\Models\KeahlianMahasiswa;
use Illuminate\Support\Facades\DB;

class BidangKeahlianController extends Controller
{
    public function index()
    {
        $keahlians = Keahlian::all();
        return view('admin.bidangKeahlian.index', compact('keahlians'));
    }

    public function getBidangKeahlianList(Request $request)
    {
        $bidangKeahlian = Keahlian::select('id', 'keahlian_nama', 'keahlian_visible')
            ->where('keahlian_visible', true);

        if ($request->ajax()) {
            return DataTables::of($bidangKeahlian)
                ->addColumn('aksi', function ($keahlian) {
                    $view = '<a href="' . url('/admin/master/bidangKeahlian/show/' . $keahlian->id) . '" class="btn btn-sm btn-info mr-1"><i class="fas fa-eye"></i> Detail</a>';
                    $edit = '<button onclick="modalAction(\'' . route('admin.master.bidangKeahlian.editAjax', $keahlian->id) . '\')" class="btn btn-sm btn-warning mr-2">
                                <i class="fas fa-edit mr-1"></i> Edit
                            </button>';
                    $delete = '<button onclick="modalAction(\'' . route('admin.master.bidangKeahlian.confirmAjax', $keahlian->id) . '\')" class="btn btn-sm btn-danger mr-2">
                                <i class="fas fa-trash-alt mr-1"></i> Hapus
                            </button>';

                    return $view . $edit . $delete;
                })
                ->editColumn('keahlian_nama', function ($keahlian) {
                    return $keahlian->keahlian_nama;
                })
                ->rawColumns(['aksi'])
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
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validasi gagal',
                'msgField' => $validator->errors()
            ]);
        }

        $data = $request->only(['keahlian_nama']);
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

        $data = $request->only(['keahlian_nama']);

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

        if (!$keahlian) {
            return response()->json([
                'status' => false,
                'message' => 'Data tidak ditemukan'
            ]);
        }

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

        $pdf = Pdf::loadView('admin.bidangKeahlian.export_pdf', compact('keahlians'))
            ->setPaper('a4', 'portrait');

        return $pdf->download('Laporan_Bidang_Keahlian.pdf');
    }

    public function exportExcel()
    {
        $keahlians = Keahlian::where('keahlian_visible', true)
            ->orderBy('keahlian_nama', 'asc')
            ->get();

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $spreadsheet->getProperties()
            ->setCreator('STAR System')
            ->setLastModifiedBy('STAR System')
            ->setTitle('Data Bidang Keahlian')
            ->setSubject('Bidang Keahlian Export')
            ->setDescription('Daftar bidang keahlian yang aktif dalam sistem');

        $sheet->setCellValue('A1', 'DAFTAR BIDANG KEAHLIAN');
        $sheet->mergeCells('A1:C1');
        $sheet->getStyle('A1')->getFont()->setBold(true)->setSize(16);
        $sheet->getStyle('A1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

        $sheet->setCellValue('A2', 'No');
        $sheet->setCellValue('B2', 'ID');
        $sheet->setCellValue('C2', 'Nama Bidang Keahlian');

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
        $sheet->getStyle('A2:C2')->applyFromArray($headerStyle);
        $sheet->getRowDimension(2)->setRowHeight(25);
        $sheet->freezePane('A3');

        $no = 1;
        $row = 3;
        foreach ($keahlians as $keahlian) {
            $sheet->setCellValue('A' . $row, $no);
            $sheet->setCellValue('B' . $row, $keahlian->id);
            $sheet->setCellValue('C' . $row, $keahlian->keahlian_nama);

            $sheet->getStyle('A' . $row . ':C' . $row)->applyFromArray([
                'borders' => [
                    'allBorders' => [
                        'borderStyle' => Border::BORDER_THIN,
                        'color' => ['rgb' => '000000']
                    ]
                ]
            ]);

            $sheet->getStyle('A' . $row)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle('B' . $row)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

            $row++;
            $no++;
        }

        foreach (range('A', 'C') as $column) {
            $sheet->getColumnDimension($column)->setAutoSize(true);
        }

        $sheet->setTitle('Bidang Keahlian');

        $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');

        $filename = 'Data_Bidang_Keahlian_' . date('Y-m-d_H-i-s') . '.xlsx';

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
        return view('admin.bidangKeahlian.import');
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

            if (Keahlian::where('keahlian_nama', $nama)->exists()) {
                $errors[] = "Baris " . ($index + 1) . ": '$nama' sudah ada";
                continue;
            }

            $insert[] = [
                'keahlian_nama' => $nama,
                'keahlian_visible' => true,
                'created_at' => now(),
                'updated_at' => now()
            ];
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

        $sheet->getStyle('A1')->getFont()->setBold(true);
        $sheet->getStyle('A1')->getFill()
            ->setFillType(Fill::FILL_SOLID)
            ->getStartColor()->setRGB('102044');
        $sheet->getStyle('A1')->getFont()->getColor()->setRGB('FFFFFF');

        $sheet->getColumnDimension('A')->setAutoSize(true);

        $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
        $path = public_path('excel/template_bidang_keahlian.xlsx');

        if (!file_exists(dirname($path))) {
            mkdir(dirname($path), 0755, true);
        }

        $writer->save($path);

        return response()->download($path, 'template_bidang_keahlian.xlsx');
    }
    public function lihatMahasiswa($id)
    {
        $keahlian = Keahlian::find($id);

        if (!$keahlian) {
            return view('admin.bidangKeahlian.mahasiswa_modal', [
                'errorMessage' => 'Bidang keahlian tidak ditemukan'
            ]);
        }

        $primaryMahasiswas = Mahasiswa::where('keahlian_id', $id)
            ->with(['prodi'])
            ->get()
            ->map(function ($mahasiswa) {
                $mahasiswa->prodi_nama = $mahasiswa->prodi->prodi_nama ?? 'N/A';
                return $mahasiswa;
            });

        // Get mahasiswa with this keahlian as additional skill (t_keahlian_mahasiswas)
        $additionalMahasiswas = KeahlianMahasiswa::where('keahlian_id', $id)
            ->with([
                'mahasiswa' => function ($query) {
                    $query->with(['prodi']);
                }
            ])
            ->get()
            ->map(function ($item) {
                $mahasiswa = $item->mahasiswa;
                $mahasiswa->prodi_nama = $mahasiswa->prodi->prodi_nama ?? 'N/A';
                $mahasiswa->keahlian_sertifikat = $item->keahlian_sertifikat;
                return $mahasiswa;
            });

        $allMahasiswas = $primaryMahasiswas->concat($additionalMahasiswas)->unique('id');
        
        $mahasiswas = $primaryMahasiswas;


        return view('admin.bidangKeahlian.mahasiswa_modal', compact('keahlian', 'mahasiswas', 'allMahasiswas'));
    }
}
