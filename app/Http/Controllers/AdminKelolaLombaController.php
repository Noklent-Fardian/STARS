<?php

namespace App\Http\Controllers;

use App\Models\Lomba;
use App\Models\Keahlian;
use App\Models\Tingkatan;
use App\Models\Semester;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;

class AdminKelolaLombaController extends Controller
{
    public function index()
    {
        $page = (object) [
            'title' => 'Data Lomba',
        ];

        return view('admin.adminKelolaLomba.index', compact('page'));
    }

    public function getLombaList(Request $request)
    {
        $lombas = Lomba::with(['keahlians', 'tingkatan', 'semester'])
            ->where('lomba_visible', true)
            ->where('lomba_terverifikasi', true);

        return DataTables::of($lombas)
            ->addColumn('keahlian_nama', function ($lomba) {
                return $lomba->keahlians->count() > 0 ? $lomba->keahlian_names : '-';
            })
            ->addColumn('tingkatan_nama', function ($lomba) {
                return $lomba->tingkatan ? $lomba->tingkatan->tingkatan_nama : '-';
            })
            ->addColumn('semester_nama', function ($lomba) {
                return $lomba->semester ? $lomba->semester->semester_nama : '-';
            })
            ->addColumn('aksi', function ($lomba) {
                $view = '<a href="' . url('/admin/adminKelolaLomba/show/' . $lomba->id) . '" class="btn btn-sm btn-info mr-1"><i class="fas fa-eye"></i> Detail</a>';
                $edit = '<button onclick="modalAction(\'' . route('admin.adminKelolaLomba.editAjax', $lomba->id) . '\')" class="btn btn-sm btn-warning mr-2">
                            <i class="fas fa-edit mr-1"></i> Edit
                        </button>';
                $delete = '<button onclick="modalAction(\'' . route('admin.adminKelolaLomba.confirmAjax', $lomba->id) . '\')" class="btn btn-sm btn-danger mr-2">
                            <i class="fas fa-trash-alt mr-1"></i> Hapus
                        </button>';

                return $view . $edit . $delete;
            })
            ->rawColumns(['aksi'])
            ->make(true);
    }

    public function ajaxKeahlianSearch(Request $request)
    {
        $q = trim($request->q);
        $query = Keahlian::query()
            ->where('keahlian_visible', true);
        if ($q) {
            $query->where('keahlian_nama', 'like', '%' . $q . '%');
        }
        $list = $query->orderBy('keahlian_nama')->limit(10)->get(['id', 'keahlian_nama']);
        return response()->json([
            'data' => $list
        ]);
    }

    public function createAjax()
    {
        $keahlians = Keahlian::all();
        $tingkatans = Tingkatan::all();
        $semesters = Semester::all();

        return view('admin.adminKelolaLomba.create_ajax', compact('keahlians', 'tingkatans', 'semesters'));
    }

    public function storeAjax(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'lomba_keahlian_ids' => 'sometimes|array',
            'lomba_keahlian_ids.*' => 'exists:m_keahlians,id',
            'new_keahlian_names' => 'sometimes|array',
            'new_keahlian_names.*' => 'string|max:255',
            'tingkatan_id' => 'required|exists:m_tingkatans,id',
            'semester_id' => 'required|exists:m_semesters,id',
            'lomba_nama' => 'required|string|max:255',
            'lomba_penyelenggara' => 'required|string|max:255',
            'lomba_kategori' => 'required|string|max:255',
            'lomba_tanggal_mulai' => 'required|date',
            'lomba_tanggal_selesai' => 'required|date|after:lomba_tanggal_mulai',
            'lomba_link_pendaftaran' => 'required|url',
            'lomba_link_poster' => 'required|url',
        ], [
            'lomba_tanggal_selesai.after' => 'Tanggal selesai harus setelah tanggal mulai',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validasi gagal. Periksa kembali data Anda!',
                'msgField' => $validator->errors(),
            ]);
        }

        $keahlianIds = $request->lomba_keahlian_ids ?? [];

        // Handle new keahlian names
        if ($request->has('new_keahlian_names')) {
            foreach ($request->new_keahlian_names as $newKeahlianName) {
                if (!empty(trim($newKeahlianName))) {
                    // Check if keahlian already exists (case insensitive)
                    $existingKeahlian = Keahlian::whereRaw('LOWER(keahlian_nama) = ?', [strtolower(trim($newKeahlianName))])->first();

                    if (!$existingKeahlian) {
                        // Create new keahlian
                        $newKeahlian = Keahlian::create([
                            'keahlian_nama' => trim($newKeahlianName),
                            'keahlian_visible' => true
                        ]);
                        $keahlianIds[] = $newKeahlian->id;
                    } else {
                        // Use existing keahlian
                        $keahlianIds[] = $existingKeahlian->id;
                    }
                }
            }
        }

        if (empty($keahlianIds)) {
            return response()->json([
                'status' => false,
                'message' => 'Pilih minimal satu bidang keahlian',
                'msgField' => ['keahlian' => ['Pilih minimal satu bidang keahlian']],
            ]);
        }

        $keahlianIds = array_values(array_unique(array_map('intval', $keahlianIds)));

        DB::beginTransaction();
        try {
            $lomba = Lomba::create([
                'tingkatan_id' => $request->tingkatan_id,
                'semester_id' => $request->semester_id,
                'lomba_nama' => $request->lomba_nama,
                'lomba_penyelenggara' => $request->lomba_penyelenggara,
                'lomba_kategori' => $request->lomba_kategori,
                'lomba_tanggal_mulai' => $request->lomba_tanggal_mulai,
                'lomba_tanggal_selesai' => $request->lomba_tanggal_selesai,
                'lomba_link_pendaftaran' => $request->lomba_link_pendaftaran,
                'lomba_link_poster' => $request->lomba_link_poster,
                'lomba_visible' => true,
                'lomba_terverifikasi' => true,
            ]);

            // Attach keahlians
            $lomba->keahlians()->attach($keahlianIds);

            DB::commit();

            return response()->json([
                'status' => true,
                'message' => 'Lomba berhasil ditambahkan',
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'status' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage(),
            ]);
        }
    }

    public function show($id)
    {
        $lomba = Lomba::with(['keahlians', 'tingkatan', 'semester'])->find($id);

        if (!$lomba) {
            abort(404);
        }

        $page = (object) [
            'title' => 'Detail Lomba',
        ];

        return view('admin.adminKelolaLomba.show', compact('lomba', 'page'));
    }

    public function editAjax($id)
    {
        $lomba = Lomba::with('keahlians')->find($id);
        $keahlians = Keahlian::all();
        $tingkatans = Tingkatan::all();
        $semesters = Semester::all();

        if (!$lomba) {
            return response()->json([
                'status' => false,
                'message' => 'Lomba tidak ditemukan',
            ]);
        }

        return view('admin.adminKelolaLomba.edit_ajax', compact('lomba', 'keahlians', 'tingkatans', 'semesters'));
    }

    public function updateAjax(Request $request, $id)
    {
        $lomba = Lomba::find($id);

        if (!$lomba) {
            return response()->json([
                'status' => false,
                'message' => 'Lomba tidak ditemukan',
            ]);
        }

        $validator = Validator::make($request->all(), [
            'lomba_keahlian_ids' => 'sometimes|array',
            'lomba_keahlian_ids.*' => 'exists:m_keahlians,id',
            'new_keahlian_names' => 'sometimes|array',
            'new_keahlian_names.*' => 'string|max:255',
            'tingkatan_id' => 'required|exists:m_tingkatans,id',
            'semester_id' => 'required|exists:m_semesters,id',
            'lomba_nama' => 'required|string|max:255',
            'lomba_penyelenggara' => 'required|string|max:255',
            'lomba_kategori' => 'required|string|max:255',
            'lomba_tanggal_mulai' => 'required|date',
            'lomba_tanggal_selesai' => 'required|date|after:lomba_tanggal_mulai',
            'lomba_link_pendaftaran' => 'required|url',
            'lomba_link_poster' => 'required|url',
        ], [
            'lomba_tanggal_selesai.after' => 'Tanggal selesai harus setelah tanggal mulai',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validasi gagal. Periksa kembali data Anda!',
                'msgField' => $validator->errors(),
            ]);
        }

        $keahlianIds = $request->lomba_keahlian_ids ?? [];

        // Handle new keahlian names
        if ($request->has('new_keahlian_names')) {
            foreach ($request->new_keahlian_names as $newKeahlianName) {
                if (!empty(trim($newKeahlianName))) {
                    // Check if keahlian already exists (case insensitive)
                    $existingKeahlian = Keahlian::whereRaw('LOWER(keahlian_nama) = ?', [strtolower(trim($newKeahlianName))])->first();

                    if (!$existingKeahlian) {
                        // Create new keahlian
                        $newKeahlian = Keahlian::create([
                            'keahlian_nama' => trim($newKeahlianName),
                            'keahlian_visible' => true
                        ]);
                        $keahlianIds[] = $newKeahlian->id;
                    } else {
                        // Use existing keahlian
                        $keahlianIds[] = $existingKeahlian->id;
                    }
                }
            }
        }

        if (empty($keahlianIds)) {
            return response()->json([
                'status' => false,
                'message' => 'Pilih minimal satu bidang keahlian',
                'msgField' => ['keahlian' => ['Pilih minimal satu bidang keahlian']],
            ]);
        }

        $keahlianIds = array_values(array_unique(array_map('intval', $keahlianIds)));

        DB::beginTransaction();
        try {
            $lomba->update([
                'tingkatan_id' => $request->tingkatan_id,
                'semester_id' => $request->semester_id,
                'lomba_nama' => $request->lomba_nama,
                'lomba_penyelenggara' => $request->lomba_penyelenggara,
                'lomba_kategori' => $request->lomba_kategori,
                'lomba_tanggal_mulai' => $request->lomba_tanggal_mulai,
                'lomba_tanggal_selesai' => $request->lomba_tanggal_selesai,
                'lomba_link_pendaftaran' => $request->lomba_link_pendaftaran,
                'lomba_link_poster' => $request->lomba_link_poster,
            ]);

            $lomba->keahlians()->sync($keahlianIds);

            DB::commit();

            return response()->json([
                'status' => true,
                'message' => 'Lomba berhasil diperbarui',
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'status' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage(),
            ]);
        }
    }

    public function confirmAjax($id)
    {
        $lomba = Lomba::find($id);

        if (!$lomba) {
            return response()->json([
                'status' => false,
                'message' => 'Lomba tidak ditemukan',
            ]);
        }

        return view('admin.adminKelolaLomba.confirm_ajax', compact('lomba'));
    }

    public function destroyAjax($id)
    {
        $lomba = Lomba::find($id);

        if (!$lomba) {
            return response()->json([
                'status' => false,
                'message' => 'Lomba tidak ditemukan',
            ]);
        }

        DB::beginTransaction();
        try {
            $lomba->keahlians()->detach();

            $lomba->update([
                'lomba_nama' => $lomba->lomba_nama . ' (Dihapus pada ' . date('H:i d/m/Y') . ')',
                'lomba_visible' => false,
            ]);

            DB::commit();
            return response()->json([
                'status' => true,
                'message' => 'Lomba berhasil dihapus',
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'status' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage(),
            ]);
        }
    }

    public function exportPDF()
    {
        $pdfSetting = \App\Models\PdfSetting::first();
        $lombas = Lomba::with(['keahlians', 'tingkatan', 'semester'])
            ->where('lomba_visible', true)
            ->orderBy('id', 'asc')
            ->get();

        $pdf = PDF::loadView('admin.adminKelolaLomba.export_pdf', compact('lombas', 'pdfSetting'))
            ->setPaper('a3', 'landscape');

        return $pdf->download('data-lomba.pdf');
    }

    public function exportExcel()
    {
        $lombas = Lomba::with(['keahlians', 'tingkatan', 'semester'])
            ->where('lomba_visible', true)
            ->orderBy('id', 'asc')
            ->get();

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $spreadsheet->getProperties()
            ->setCreator('STAR System')
            ->setLastModifiedBy('STAR System')
            ->setTitle('Data Lomba')
            ->setSubject('Data Lomba Export')
            ->setDescription('Daftar lomba yang aktif dalam sistem');

        $sheet->setCellValue('A1', 'DAFTAR LOMBA');
        $sheet->mergeCells('A1:L1');
        $sheet->getStyle('A1')->getFont()->setBold(true)->setSize(16);
        $sheet->getStyle('A1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

        $sheet->setCellValue('A2', 'No');
        $sheet->setCellValue('B2', 'ID');
        $sheet->setCellValue('C2', 'Keahlian');
        $sheet->setCellValue('D2', 'Tingkatan');
        $sheet->setCellValue('E2', 'Semester');
        $sheet->setCellValue('F2', 'Nama Lomba');
        $sheet->setCellValue('G2', 'Penyelenggara');
        $sheet->setCellValue('H2', 'Kategori');
        $sheet->setCellValue('I2', 'Tanggal Mulai');
        $sheet->setCellValue('J2', 'Tanggal Selesai');
        $sheet->setCellValue('K2', 'Link Pendaftaran');
        $sheet->setCellValue('L2', 'Link Poster');

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
        $sheet->getStyle('A2:L2')->applyFromArray($headerStyle);
        $sheet->getRowDimension(2)->setRowHeight(25);
        $sheet->freezePane('A3');

        $no = 1;
        $row = 3;
        foreach ($lombas as $lomba) {
            $sheet->setCellValue('A' . $row, $no);
            $sheet->setCellValue('B' . $row, $lomba->id);
            $sheet->setCellValue('C' . $row, $lomba->keahlians->count() > 0 ? $lomba->keahlian_names : '-');
            $sheet->setCellValue('D' . $row, $lomba->tingkatan ? $lomba->tingkatan->tingkatan_nama : '-');
            $sheet->setCellValue('E' . $row, $lomba->semester ? $lomba->semester->semester_nama : '-');
            $sheet->setCellValue('F' . $row, $lomba->lomba_nama);
            $sheet->setCellValue('G' . $row, $lomba->lomba_penyelenggara);
            $sheet->setCellValue('H' . $row, $lomba->lomba_kategori);
            $sheet->setCellValue('I' . $row, $lomba->lomba_tanggal_mulai);
            $sheet->setCellValue('J' . $row, $lomba->lomba_tanggal_selesai);

            if (!empty($lomba->lomba_link_pendaftaran)) {
                $linkPendaftaran = $lomba->lomba_link_pendaftaran;
                if (!preg_match("~^(?:f|ht)tps?://~i", $linkPendaftaran)) {
                    $linkPendaftaran = "https://" . $linkPendaftaran;
                }
                $sheet->setCellValue('K' . $row, $linkPendaftaran);
                $sheet->getCell('K' . $row)->getHyperlink()->setUrl($linkPendaftaran);
                $sheet->getStyle('K' . $row)->applyFromArray([
                    'font' => [
                        'color' => ['rgb' => '0000FF'],
                        'underline' => \PhpOffice\PhpSpreadsheet\Style\Font::UNDERLINE_SINGLE
                    ]
                ]);
            } else {
                $sheet->setCellValue('K' . $row, '-');
            }

            if (!empty($lomba->lomba_link_poster)) {
                $linkPoster = $lomba->lomba_link_poster;
                if (!preg_match("~^(?:f|ht)tps?://~i", $linkPoster)) {
                    $linkPoster = "https://" . $linkPoster;
                }
                $sheet->setCellValue('L' . $row, $linkPoster);
                $sheet->getCell('L' . $row)->getHyperlink()->setUrl($linkPoster);
                $sheet->getStyle('L' . $row)->applyFromArray([
                    'font' => [
                        'color' => ['rgb' => '0000FF'],
                        'underline' => \PhpOffice\PhpSpreadsheet\Style\Font::UNDERLINE_SINGLE
                    ]
                ]);
            } else {
                $sheet->setCellValue('L' . $row, '-');
            }

            $sheet->getStyle('A' . $row . ':L' . $row)->applyFromArray([
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

        foreach (range('A', 'L') as $column) {
            $sheet->getColumnDimension($column)->setAutoSize(true);
        }

        $sheet->setTitle('Data Lomba');

        $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');

        $filename = 'Data_Lomba_' . date('Y-m-d_H-i-s') . '.xlsx';

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
        return view('admin.adminKelolaLomba.import');
    }

    public function importExcel(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'file_lomba' => 'required|mimes:xlsx,xls|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validasi gagal',
                'msgField' => $validator->errors()
            ]);
        }

        try {
            $file = $request->file('file_lomba');
            $spreadsheet = IOFactory::load($file->getRealPath());
            $sheet = $spreadsheet->getActiveSheet();

            $data = $sheet->toArray();
            $headers = array_shift($data);

            $errors = [];
            $duplicateErrors = [];
            $insertData = [];

            $expectedHeaders = [
                'Bidang Keahlian',
                'Tingkatan ID',
                'Semester ID',
                'Nama Lomba',
                'Penyelenggara',
                'Kategori',
                'Tanggal Mulai',
                'Tanggal Selesai',
                'Link Pendaftaran',
                'Link Poster'
            ];

            if ($headers !== $expectedHeaders) {
                return response()->json([
                    'status' => false,
                    'message' => 'Format header tidak sesuai. Silakan download template terlebih dahulu.'
                ]);
            }

            foreach ($data as $rowIndex => $row) {
                $rowNumber = $rowIndex + 2;

                if (empty(array_filter($row))) {
                    continue;
                }

                if (empty($row[0]) || empty($row[3])) {
                    $errors[] = "Baris $rowNumber: Keahlian IDs dan Nama Lomba wajib diisi";
                    continue;
                }

                $existingLomba = Lomba::where('lomba_nama', $row[3])
                    ->where('lomba_visible', true)
                    ->exists();

                if ($existingLomba) {
                    $duplicateErrors[] = "Baris $rowNumber: Lomba '{$row[3]}' sudah terdaftar";
                    continue;
                }

                try {
                    $lomba_tanggal_mulai = date_format(date_create($row[6]), 'Y-m-d');
                    $lomba_tanggal_selesai = date_format(date_create($row[7]), 'Y-m-d');
                } catch (\Exception $e) {
                    $errors[] = "Baris $rowNumber: Format tanggal tidak valid (harus YYYY-MM-DD)";
                    continue;
                }

                if ($lomba_tanggal_selesai < $lomba_tanggal_mulai) {
                    $errors[] = "Baris $rowNumber: Tanggal selesai harus setelah tanggal mulai";
                    continue;
                }

                $keahlianRaw = array_map('trim', explode(',', $row[0]));
                $keahlianIds = [];
                foreach ($keahlianRaw as $item) {
                    if ($item === '')
                        continue;
                    $keahlian = Keahlian::whereRaw('LOWER(keahlian_nama) = ?', [strtolower($item)])->first();
                    if ($keahlian) {
                        $keahlianIds[] = $keahlian->id;
                    } else {
                        $newKeahlian = Keahlian::create([
                            'keahlian_nama' => $item,
                            'keahlian_visible' => true
                        ]);
                        $keahlianIds[] = $newKeahlian->id;
                    }
                }
                $keahlianIds = array_unique($keahlianIds);
                if (empty($keahlianIds)) {
                    $errors[] = "Baris $rowNumber: Bidang Keahlian wajib diisi (boleh lebih dari satu, pisahkan dengan koma)";
                    continue;
                }

                $insertData[] = [
                    'keahlian_ids' => $keahlianIds,
                    'tingkatan_id' => $row[1],
                    'semester_id' => $row[2],
                    'lomba_nama' => $row[3],
                    'lomba_penyelenggara' => $row[4],
                    'lomba_kategori' => $row[5],
                    'lomba_tanggal_mulai' => $lomba_tanggal_mulai,
                    'lomba_tanggal_selesai' => $lomba_tanggal_selesai,
                    'lomba_link_pendaftaran' => $row[8] ?? null,
                    'lomba_link_poster' => $row[9] ?? null,
                    'lomba_visible' => true,
                    'lomba_terverifikasi' => true,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }

            if (!empty($duplicateErrors)) {
                return response()->json([
                    'status' => false,
                    'message' => 'Terdapat lomba yang sudah ada di database',
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
                foreach ($insertData as $data) {
                    $keahlianIdsToAttach = $data['keahlian_ids'];
                    unset($data['keahlian_ids']);

                    $lomba = Lomba::create($data);
                    $lomba->keahlians()->attach($keahlianIdsToAttach);
                }

                DB::commit();

                return response()->json([
                    'status' => true,
                    'message' => 'Berhasil mengimport ' . count($insertData) . ' data lomba',
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

        $sheet->setCellValue('A1', 'Bidang Keahlian');
        $sheet->setCellValue('B1', 'Tingkatan ID');
        $sheet->setCellValue('C1', 'Semester ID');
        $sheet->setCellValue('D1', 'Nama Lomba');
        $sheet->setCellValue('E1', 'Penyelenggara');
        $sheet->setCellValue('F1', 'Kategori');
        $sheet->setCellValue('G1', 'Tanggal Mulai');
        $sheet->setCellValue('H1', 'Tanggal Selesai');
        $sheet->setCellValue('I1', 'Link Pendaftaran');
        $sheet->setCellValue('J1', 'Link Poster');

        $sheet->setCellValue('A2', 'Frontend Developer, Backend Developer');
        $sheet->setCellValue('B2', '1');
        $sheet->setCellValue('C2', '1');
        $sheet->setCellValue('D2', 'Lomba Hackathon');
        $sheet->setCellValue('E2', 'Politeknik Negeri Malang');
        $sheet->setCellValue('F2', 'Akademik');
        $sheet->setCellValue('G2', '2025-05-01');
        $sheet->setCellValue('H2', '2025-06-01');
        $sheet->setCellValue('I2', 'link');
        $sheet->setCellValue('J2', 'link');

        $sheet->getStyle('A1:J1')->getFont()->setBold(true);
        $sheet->getStyle('A1:J1')->getFill()
            ->setFillType(Fill::FILL_SOLID)
            ->getStartColor()->setRGB('102044');
        $sheet->getStyle('A1:J1')->getFont()->getColor()->setRGB('FFFFFF');

        $sheet->getColumnDimension('A')->setAutoSize(true);
        $sheet->getColumnDimension('J')->setAutoSize(true);

        $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
        $path = public_path('excel/template_lomba.xlsx');

        if (!file_exists(dirname($path))) {
            mkdir(dirname($path), 0755, true);
        }

        $writer->save($path);

        return response()->download($path, 'template_lomba.xlsx');
    }
}