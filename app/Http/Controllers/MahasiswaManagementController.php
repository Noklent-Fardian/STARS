<?php
namespace App\Http\Controllers;

use App\Models\Keahlian;
use App\Models\Mahasiswa;
use App\Models\Prodi;
use App\Models\Semester;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use Yajra\DataTables\Facades\DataTables;

class MahasiswaManagementController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $page = (object) [
            'title' => 'Data Mahasiswa',
        ];

        $prodis    = Prodi::where('prodi_visible', true)->get();
        $keahlians = Keahlian::where('keahlian_visible', true)->get();
        $semesters = Semester::where('semester_visible', true)->get();

        return view('admin.mahasiswaManagement.index', compact('page', 'prodis', 'keahlians', 'semesters'));
    }

    /**
     * Process datatables ajax request.
     */
    public function getMahasiswaList(Request $request)
    {
        $mahasiswas = Mahasiswa::select(
            'm_mahasiswas.id',
            'm_mahasiswas.mahasiswa_nama',
            'm_mahasiswas.mahasiswa_nim',
            'm_mahasiswas.mahasiswa_status',
            'm_mahasiswas.mahasiswa_gender',
            'm_mahasiswas.mahasiswa_angkatan',
            'm_mahasiswas.mahasiswa_nomor_telepon',
            'm_mahasiswas.mahasiswa_photo',
            'm_mahasiswas.mahasiswa_visible',
            'm_mahasiswas.prodi_id',
            'm_mahasiswas.keahlian_id',
            'm_mahasiswas.semester_id',
            'users.username',
            'm_prodis.prodi_nama',
            'm_keahlians.keahlian_nama',
            'm_semesters.semester_nama'
        )
            ->join('m_users as users', 'users.id', '=', 'm_mahasiswas.user_id')
            ->leftJoin('m_prodis', 'm_prodis.id', '=', 'm_mahasiswas.prodi_id')
            ->leftJoin('m_keahlians', 'm_keahlians.id', '=', 'm_mahasiswas.keahlian_id')
            ->leftJoin('m_semesters', 'm_semesters.id', '=', 'm_mahasiswas.semester_id')
            ->where('m_mahasiswas.mahasiswa_visible', true);

        return DataTables::of($mahasiswas)
            ->filter(function ($query) use ($request) {
                if ($request->has('search') && ! empty($request->search['value'])) {
                    $search = strtolower($request->search['value']);
                    $query->where(function ($q) use ($search) {
                        $q->whereRaw('LOWER(m_mahasiswas.id) LIKE ?', ["%{$search}%"])
                            ->orWhereRaw('LOWER(m_mahasiswas.mahasiswa_nama) LIKE ?', ["%{$search}%"])
                            ->orWhereRaw('LOWER(m_mahasiswas.mahasiswa_nim) LIKE ?', ["%{$search}%"])
                            ->orWhereRaw('LOWER(m_mahasiswas.mahasiswa_status) LIKE ?', ["%{$search}%"])
                            ->orWhereRaw('LOWER(users.username) LIKE ?', ["%{$search}%"])
                            ->orWhereRaw('LOWER(m_prodis.prodi_nama) LIKE ?', ["%{$search}%"])
                            ->orWhereRaw('LOWER(m_keahlians.keahlian_nama) LIKE ?', ["%{$search}%"])
                            ->orWhereRaw('LOWER(m_semesters.semester_nama) LIKE ?', ["%{$search}%"])
                            ->orWhereRaw('LOWER(m_mahasiswas.mahasiswa_gender) LIKE ?', ["%{$search}%"]);
                    });
                }
            })
            ->addColumn('aksi', function ($mahasiswa) {
                $view = '<a href="' . url('/admin/mahasiswaManagement/show/' . $mahasiswa->id) . '" class="btn btn-sm btn-info mr-1"><i class="fas fa-eye"></i> Detail</a>';
                $edit = '<button onclick="modalAction(\'' . route('admin.mahasiswaManagement.editAjax', $mahasiswa->id) . '\')" class="btn btn-sm btn-warning mr-2">
                            <i class="fas fa-edit mr-1"></i> Edit
                        </button>';
                $delete = '<button onclick="modalAction(\'' . route('admin.mahasiswaManagement.confirmAjax', $mahasiswa->id) . '\')" class="btn btn-sm btn-danger mr-2">
                            <i class="fas fa-trash-alt mr-1"></i> Hapus
                        </button>';

                return $view . $edit . $delete;
            })
            ->editColumn('mahasiswa_gender', function ($mahasiswa) {
                return $mahasiswa->mahasiswa_gender == 'Laki-laki' ? 'Laki-laki' : 'Perempuan';
            })
            ->editColumn('mahasiswa_photo', function ($mahasiswa) {
                if ($mahasiswa->mahasiswa_photo) {
                    return '<img src="' . asset('storage/mahasiswa_photos/' . $mahasiswa->mahasiswa_photo) . '"
                            alt="' . $mahasiswa->mahasiswa_nama . '" class="img-thumbnail" style="max-width: 50px;">';
                }
                return '<span class="badge badge-secondary">No Photo</span>';
            })
            ->editColumn('mahasiswa_status', function ($mahasiswa) {
                $statuses = [
                    'Aktif'    => 'success',
                    'Cuti'     => 'warning',
                    'Drop Out' => 'danger',
                    'Lulus'    => 'primary',
                ];
                $color = $statuses[$mahasiswa->mahasiswa_status] ?? 'info';
                return '<span class="badge badge-' . $color . '">' . $mahasiswa->mahasiswa_status . '</span>';
            })
            ->rawColumns(['aksi', 'mahasiswa_photo', 'mahasiswa_status'])
            ->make(true);
    }

    /**
     * Show the form for creating a new resource with AJAX.
     */
    public function createAjax()
    {
        $prodis    = Prodi::where('prodi_visible', true)->get();
        $keahlians = Keahlian::where('keahlian_visible', true)->get();
        $semesters = Semester::where('semester_visible', true)->get();

        return view('admin.mahasiswaManagement.create_ajax', compact('prodis', 'keahlians', 'semesters'));
    }

    /**
     * Store a newly created resource in storage with AJAX.
     */
    public function storeAjax(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'mahasiswa_nama'          => 'required|string|max:255',
            'mahasiswa_nim'           => 'required|string|max:255|unique:m_mahasiswas',
            'mahasiswa_gender'        => 'required|in:Laki-laki,Perempuan',
            'mahasiswa_angkatan'      => 'required|integer|min:2000|max:' . (date('Y') + 5),
            'mahasiswa_nomor_telepon' => 'required|string|max:15',
            'mahasiswa_agama'         => 'nullable|string|max:255',
            'mahasiswa_provinsi'      => 'nullable|string|max:255',
            'mahasiswa_kota'          => 'nullable|string|max:255',
            'mahasiswa_kecamatan'     => 'nullable|string|max:255',
            'mahasiswa_desa'          => 'nullable|string|max:255',
            'prodi_id'                => 'nullable|exists:m_prodis,id',
            'semester_id'             => 'nullable|exists:m_semesters,id',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status'   => false,
                'message'  => 'Validasi gagal. Periksa kembali data Anda.',
                'msgField' => $validator->errors(),
            ]);
        }

        DB::beginTransaction();
        try {
            $user = User::create([
                'username'      => $request->mahasiswa_nim,
                'user_password' => Hash::make($request->mahasiswa_nim),
                'user_role'     => 'Mahasiswa',
                'user_visible'  => true,
            ]);

            Mahasiswa::create([
                'user_id'                 => $user->id,
                'prodi_id'                => $request->prodi_id,
                'keahlian_id'             => null,
                'semester_id'             => $request->semester_id,
                'mahasiswa_nama'          => $request->mahasiswa_nama,
                'mahasiswa_nim'           => $request->mahasiswa_nim,
                'mahasiswa_status'        => 'Aktif',
                'mahasiswa_gender'        => $request->mahasiswa_gender,
                'mahasiswa_angkatan'      => $request->mahasiswa_angkatan,
                'mahasiswa_nomor_telepon' => $request->mahasiswa_nomor_telepon,
                'mahasiswa_agama'         => $request->mahasiswa_agama,
                'mahasiswa_provinsi'      => $request->mahasiswa_provinsi,
                'mahasiswa_kota'          => $request->mahasiswa_kota,
                'mahasiswa_kecamatan'     => $request->mahasiswa_kecamatan,
                'mahasiswa_desa'          => $request->mahasiswa_desa,
                'mahasiswa_score'         => 0,
                'mahasiswa_photo'         => null,
                'mahasiswa_visible'       => true,
            ]);

            DB::commit();
            return response()->json([
                'status'  => true,
                'message' => 'Mahasiswa berhasil ditambahkan',
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'status'  => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage(),
            ]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $mahasiswa = Mahasiswa::with(['user', 'prodi', 'keahlian', 'semester'])->find($id);
        $page      = (object) [
            'title' => 'Detail Mahasiswa',
        ];

        return view('admin.mahasiswaManagement.show', compact('mahasiswa', 'page'));
    }

    /**
     * Show the form for editing the specified resource with AJAX.
     */
    public function editAjax($id)
    {
        $mahasiswa = Mahasiswa::with(['user', 'prodi', 'keahlian', 'semester'])->find($id);
        $prodis    = Prodi::where('prodi_visible', true)->get();
        $keahlians = Keahlian::where('keahlian_visible', true)->get();
        $semesters = Semester::where('semester_visible', true)->get();

        return view('admin.mahasiswaManagement.edit_ajax', compact('mahasiswa', 'prodis', 'keahlians', 'semesters'));
    }

    /**
     * Update the specified resource in storage with AJAX.
     */
    public function updateAjax(Request $request, $id)
    {
        $mahasiswa = Mahasiswa::with('user')->find($id);

        if (! $mahasiswa) {
            return response()->json([
                'status'  => false,
                'message' => 'Data mahasiswa tidak ditemukan',
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'mahasiswa_nama'          => 'required|string|max:255',
            'mahasiswa_nim'           => [
                'required',
                'string',
                'max:255',
                Rule::unique('m_mahasiswas')->ignore($mahasiswa->id),
            ],
            'mahasiswa_status'        => 'required|in:Aktif,Cuti,Drop Out,Lulus',
            'mahasiswa_gender'        => 'required|in:Laki-laki,Perempuan',
            'mahasiswa_angkatan'      => 'required|integer|min:2000|max:' . (date('Y') + 5),
            'mahasiswa_nomor_telepon' => 'required|string|max:15',
            'mahasiswa_agama'         => 'nullable|string|max:255',
            'mahasiswa_provinsi'      => 'nullable|string|max:255',
            'mahasiswa_kota'          => 'nullable|string|max:255',
            'mahasiswa_kecamatan'     => 'nullable|string|max:255',
            'mahasiswa_desa'          => 'nullable|string|max:255',
            'prodi_id'                => 'nullable|exists:m_prodis,id',
            'semester_id'             => 'nullable|exists:m_semesters,id',
            'username'                => [
                'required',
                'string',
                'max:255',
                Rule::unique('m_users')->ignore($mahasiswa->user_id),
            ],
            'password'                => 'nullable|string|min:8',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status'  => false,
                'message' => 'Validasi gagal',
                'errors'  => $validator->errors(),
            ], 422);
        }

        DB::beginTransaction();
        try {
            // Update user account
            $userData = ['username' => $request->username];

            if (! empty($request->password)) {
                $userData['user_password'] = Hash::make($request->password);
            }

            $mahasiswa->user->update($userData);

            // Update mahasiswa profile
            $mahasiswa->update([
                'prodi_id'                => $request->prodi_id,
                'keahlian_id'             => $request->keahlian_id,
                'semester_id'             => $request->semester_id,
                'mahasiswa_nama'          => $request->mahasiswa_nama,
                'mahasiswa_nim'           => $request->mahasiswa_nim,
                'mahasiswa_status'        => $request->mahasiswa_status,
                'mahasiswa_gender'        => $request->mahasiswa_gender,
                'mahasiswa_angkatan'      => $request->mahasiswa_angkatan,
                'mahasiswa_nomor_telepon' => $request->mahasiswa_nomor_telepon,
                'mahasiswa_agama'         => $request->mahasiswa_agama,
                'mahasiswa_provinsi'      => $request->mahasiswa_provinsi,
                'mahasiswa_kota'          => $request->mahasiswa_kota,
                'mahasiswa_kecamatan'     => $request->mahasiswa_kecamatan,
                'mahasiswa_desa'          => $request->mahasiswa_desa,
            ]);

            DB::commit();

            return response()->json([
                'status'  => true,
                'message' => 'Data mahasiswa berhasil diperbarui',
                'self'    => true,
            ], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'status'  => false,
                'message' => 'Gagal memperbarui data: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Show confirmation dialog for deleting with AJAX.
     */
    public function confirmAjax($id)
    {
        $mahasiswa = Mahasiswa::with('user')->find($id);

        return view('admin.mahasiswaManagement.confirm_ajax', compact('mahasiswa'));
    }

    /**
     * Remove the specified resource from storage with AJAX.
     */
    public function destroyAjax($id)
    {
        $mahasiswa = Mahasiswa::with('user')->find($id);

        if (! $mahasiswa) {
            return response()->json([
                'status'  => false,
                'message' => 'Mahasiswa tidak ditemukan',
            ]);
        }

        DB::beginTransaction();
        try {
            // Delete photo if exists
            if ($mahasiswa->mahasiswa_photo && file_exists(storage_path('app/public/mahasiswa_photos/' . $mahasiswa->mahasiswa_photo))) {
                unlink(storage_path('app/public/mahasiswa_photos/' . $mahasiswa->mahasiswa_photo));
            }

            // Mark mahasiswa as invisible
            $mahasiswa->update([
                'mahasiswa_nama'    => $mahasiswa->mahasiswa_nama . ' (Dihapus pada ' . date('H:i d/m/Y') . ')',
                'mahasiswa_nim'     => $mahasiswa->mahasiswa_nim . ' (Dihapus pada ' . date('H:i d/m/Y') . ')',
                'mahasiswa_visible' => false,
                'mahasiswa_photo'   => null,
            ]);

            if ($mahasiswa->user) {
                $mahasiswa->user->update([
                    'username'     => $mahasiswa->user->username . ' (Dihapus pada ' . date('H:i d/m/Y') . ')',
                    'user_visible' => false,
                ]);
            }

            DB::commit();
            return response()->json([
                'status'  => true,
                'message' => 'Mahasiswa berhasil dihapus',
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'status'  => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage(),
            ]);
        }
    }

    /**
     * Export data to PDF.
     */
    public function exportPDF()
    {
        $pdfSetting = \App\Models\PdfSetting::first();
        $mahasiswas = Mahasiswa::with(['user', 'prodi', 'keahlian', 'semester'])
            ->where('mahasiswa_visible', true)
            ->orderBy('mahasiswa_nama', 'asc')
            ->get();

        $pdf = PDF::loadView('admin.mahasiswaManagement.export_pdf', compact('mahasiswas', 'pdfSetting'))
            ->setPaper('A4', 'landscape');

        return $pdf->download('data-mahasiswa.pdf');
    }

    /**
     * Export data to Excel.
     */
    public function exportExcel()
    {
        $mahasiswas = Mahasiswa::with(['user', 'prodi', 'keahlian', 'semester'])
            ->where('mahasiswa_visible', true)
            ->orderBy('mahasiswa_nama', 'asc')
            ->get();

        $spreadsheet = new Spreadsheet();
        $sheet       = $spreadsheet->getActiveSheet();

        $spreadsheet->getProperties()
            ->setCreator('STAR System')
            ->setLastModifiedBy('STAR System')
            ->setTitle('Data Mahasiswa')
            ->setSubject('Mahasiswa Export')
            ->setDescription('Daftar mahasiswa yang aktif dalam sistem');

        $sheet->setCellValue('A1', 'DAFTAR MAHASISWA');
        $sheet->mergeCells('A1:M1');
        $sheet->getStyle('A1')->getFont()->setBold(true)->setSize(16);
        $sheet->getStyle('A1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

        $sheet->setCellValue('A2', 'No');
        $sheet->setCellValue('B2', 'ID');
        $sheet->setCellValue('C2', 'Nama Mahasiswa');
        $sheet->setCellValue('D2', 'NIM');
        $sheet->setCellValue('E2', 'Status');
        $sheet->setCellValue('F2', 'Username');
        $sheet->setCellValue('G2', 'Jenis Kelamin');
        $sheet->setCellValue('H2', 'Angkatan');
        $sheet->setCellValue('I2', 'Nomor Telepon');
        $sheet->setCellValue('J2', 'Agama');
        $sheet->setCellValue('K2', 'Alamat');
        $sheet->setCellValue('L2', 'Program Studi');
        $sheet->setCellValue('M2', 'Keahlian');

        $headerStyle = [
            'font'      => [
                'bold'  => true,
                'color' => ['rgb' => 'FFFFFF'],
            ],
            'fill'      => [
                'fillType'   => Fill::FILL_SOLID,
                'startColor' => ['rgb' => '102044'],
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical'   => Alignment::VERTICAL_CENTER,
            ],
            'borders'   => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color'       => ['rgb' => '000000'],
                ],
            ],
        ];
        $sheet->getStyle('A2:M2')->applyFromArray($headerStyle);
        $sheet->getRowDimension(2)->setRowHeight(25);
        $sheet->freezePane('A3');

        $no  = 1;
        $row = 3;
        foreach ($mahasiswas as $mahasiswa) {
            $alamat = implode(', ', array_filter([
                $mahasiswa->mahasiswa_desa,
                $mahasiswa->mahasiswa_kecamatan,
                $mahasiswa->mahasiswa_kota,
                $mahasiswa->mahasiswa_provinsi,
            ]));

            $sheet->setCellValue('A' . $row, $no);
            $sheet->setCellValue('B' . $row, $mahasiswa->id);
            $sheet->setCellValue('C' . $row, $mahasiswa->mahasiswa_nama);
            $sheet->setCellValue('D' . $row, $mahasiswa->mahasiswa_nim);
            $sheet->setCellValue('E' . $row, $mahasiswa->mahasiswa_status);
            $sheet->setCellValue('F' . $row, $mahasiswa->user->username);
            $sheet->setCellValue('G' . $row, $mahasiswa->mahasiswa_gender == 'Laki-laki' ? 'Laki-laki' : 'Perempuan');
            $sheet->setCellValue('H' . $row, $mahasiswa->mahasiswa_angkatan);
            $sheet->setCellValue('I' . $row, $mahasiswa->mahasiswa_nomor_telepon);
            $sheet->setCellValue('J' . $row, $mahasiswa->mahasiswa_agama ?? '-');
            $sheet->setCellValue('K' . $row, $alamat ?: '-');
            $sheet->setCellValue('L' . $row, $mahasiswa->prodi ? $mahasiswa->prodi->prodi_nama : '-');
            $sheet->setCellValue('M' . $row, $mahasiswa->keahlian ? $mahasiswa->keahlian->keahlian_nama : '-');

            $sheet->getStyle('A' . $row . ':M' . $row)->applyFromArray([
                'borders' => [
                    'allBorders' => [
                        'borderStyle' => Border::BORDER_THIN,
                        'color'       => ['rgb' => '000000'],
                    ],
                ],
            ]);

            $sheet->getStyle('A' . $row)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle('B' . $row)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle('E' . $row)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle('G' . $row)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle('H' . $row)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

            $row++;
            $no++;
        }

        foreach (range('A', 'M') as $column) {
            $sheet->getColumnDimension($column)->setAutoSize(true);
        }

        $sheet->setTitle('Data Mahasiswa');

        $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');

        $filename = 'Data_Mahasiswa_' . date('Y-m-d_H-i-s') . '.xlsx';

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
        return view('admin.mahasiswaManagement.import');
    }

    /**
     * Import data from Excel
     */
    public function importExcel(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'file_mahasiswa' => 'required|mimes:xlsx|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status'   => false,
                'message'  => 'Validasi gagal',
                'msgField' => $validator->errors(),
            ]);
        }

        $file   = $request->file('file_mahasiswa');
        $reader = IOFactory::createReader('Xlsx');
        $reader->setReadDataOnly(true);
        $spreadsheet = $reader->load($file->getRealPath());
        $sheet       = $spreadsheet->getActiveSheet();
        $data        = $sheet->toArray(null, true, true, true);

        $errors          = [];
        $duplicateErrors = [];
        $insertData      = [];
        $row             = 1;

        DB::beginTransaction();

        try {
            foreach ($data as $index => $rowData) {
                $row++;

                if ($index == 1) {
                    continue; // Skip header row
                }

                                                             // Validate required fields
                $requiredFields = ['A', 'B', 'C', 'D', 'H']; // Kolom A-D dan H (angkatan)
                foreach ($requiredFields as $col) {
                    if (empty($rowData[$col])) {
                        $errors[] = "Baris $row: Kolom " . $this->getColumnName($col) . " harus diisi";
                        continue 2;
                    }
                }

                // Validate username format
                if (strlen($rowData['B']) < 3 || strlen($rowData['B']) > 255) {
                    $errors[] = "Baris $row: Username '{$rowData['B']}' harus antara 3-255 karakter";
                    continue;
                }

                // Validate gender
                if (! in_array(strtoupper($rowData['C']), ['L', 'P'])) {
                    $errors[] = "Baris $row: Jenis kelamin harus 'L' atau 'P'";
                    continue;
                }

                // Validate status
                if (! empty($rowData['E']) && ! in_array($rowData['E'], ['Aktif', 'Cuti', 'Drop Out', 'Lulus'])) {
                    $errors[] = "Baris $row: Status harus salah satu dari: Aktif, Cuti, Drop Out, Lulus";
                    continue;
                }

                // Validate angkatan
                if (! is_numeric($rowData['H']) || $rowData['H'] < 2000 || $rowData['H'] > (date('Y') + 5)) {
                    $errors[] = "Baris $row: Angkatan harus antara 2000-" . (date('Y') + 5);
                    continue;
                }

                // Check for duplicate username in database
                $existingUsername = User::where('username', $rowData['B'])->first();
                if ($existingUsername) {
                    $duplicateErrors[] = "Baris $row: Username '{$rowData['B']}' sudah terdaftar";
                    continue;
                }

                // Check for duplicate NIM in database
                $existingNIM = Mahasiswa::where('mahasiswa_nim', $rowData['D'])->first();
                if ($existingNIM) {
                    $duplicateErrors[] = "Baris $row: NIM '{$rowData['D']}' sudah terdaftar";
                    continue;
                }

                // Create user
                $user = User::create([
                    'username'      => $rowData['B'],
                    'user_password' => Hash::make('password'), // Default password
                    'user_role'     => 'Mahasiswa',
                    'user_visible'  => true,
                ]);

                // Create mahasiswa profile
                Mahasiswa::create([
                    'user_id'                 => $user->id,
                    'mahasiswa_nama'          => $rowData['A'],
                    'mahasiswa_nim'           => $rowData['D'],
                    'mahasiswa_status'        => $rowData['E'] ?? 'Aktif',
                    'mahasiswa_gender'        => strtoupper($rowData['C']) == 'L' ? 'Laki-laki' : 'Perempuan',
                    'mahasiswa_angkatan'      => $rowData['H'],
                    'mahasiswa_nomor_telepon' => $rowData['F'] ?? null,
                    'mahasiswa_agama'         => $rowData['G'] ?? null,
                    'mahasiswa_provinsi'      => $rowData['I'] ?? null,
                    'mahasiswa_kota'          => $rowData['J'] ?? null,
                    'mahasiswa_kecamatan'     => $rowData['K'] ?? null,
                    'mahasiswa_desa'          => $rowData['L'] ?? null,
                    'prodi_id'                => $rowData['M'] ?? null,
                    'keahlian_id'             => $rowData['N'] ?? null,
                    'semester_id'             => $rowData['O'] ?? null,
                    'mahasiswa_score'         => 0,
                    'mahasiswa_visible'       => true,
                ]);
            }

            if (! empty($duplicateErrors) || ! empty($errors)) {
                DB::rollBack();
                $allErrors = array_merge($errors, $duplicateErrors);
                return response()->json([
                    'status'  => false,
                    'message' => 'Terdapat kesalahan pada data yang diimport',
                    'errors'  => $allErrors,
                ]);
            }

            DB::commit();
            return response()->json([
                'status'  => true,
                'message' => 'Data Mahasiswa berhasil diimport',
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'status'  => false,
                'message' => 'Gagal mengimport data: ' . $e->getMessage(),
            ]);
        }
    }

    /**
     * Generate Excel template for import
     */
    public function generateTemplate()
    {
        $spreadsheet = new Spreadsheet();
        $sheet       = $spreadsheet->getActiveSheet();

        // Header
        $headers = [
            'A' => 'Nama Mahasiswa',
            'B' => 'Username',
            'C' => 'Jenis Kelamin (L/P)',
            'D' => 'NIM',
            'E' => 'Status (Aktif/Cuti/Drop Out/Lulus)',
            'F' => 'Nomor Telepon',
            'G' => 'Agama',
            'H' => 'Angkatan',
            'I' => 'Provinsi',
            'J' => 'Kota/Kabupaten',
            'K' => 'Kecamatan',
            'L' => 'Desa/Kelurahan',
            'M' => 'ID Program Studi',
            'N' => 'ID Keahlian',
            'O' => 'ID Semester',
        ];

        foreach ($headers as $col => $header) {
            $sheet->setCellValue($col . '1', $header);
        }

        // Contoh data
        $exampleData = [
            'A' => 'Mahasiswa Contoh',
            'B' => 'mahasiswa_username',
            'C' => 'L',
            'D' => '1234567890',
            'E' => 'Aktif',
            'F' => '081234567890',
            'G' => 'Islam',
            'H' => '2023',
            'I' => 'Jawa Barat',
            'J' => 'Bandung',
            'K' => 'Coblong',
            'L' => 'Dago',
            'M' => '1',
            'N' => '1',
            'O' => '1',
        ];

        foreach ($exampleData as $col => $value) {
            $sheet->setCellValue($col . '2', $value);
        }

        // Styling
        $sheet->getStyle('A1:O1')->getFont()->setBold(true);
        $sheet->getStyle('A1:O1')->getFill()
            ->setFillType(Fill::FILL_SOLID)
            ->getStartColor()->setRGB('102044');
        $sheet->getStyle('A1:O1')->getFont()->getColor()->setRGB('FFFFFF');

        foreach (range('A', 'O') as $column) {
            $sheet->getColumnDimension($column)->setAutoSize(true);
        }

        $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
        $path   = public_path('excel/template_mahasiswa.xlsx');

        if (! file_exists(dirname($path))) {
            mkdir(dirname($path), 0755, true);
        }

        $writer->save($path);

        return response()->download($path, 'template_mahasiswa.xlsx');
    }

    // Helper function untuk mendapatkan nama kolom
    private function getColumnName($column)
    {
        $headers = [
            'A' => 'Nama Mahasiswa',
            'B' => 'Username',
            'C' => 'Jenis Kelamin',
            'D' => 'NIM',
            'E' => 'Status',
            'F' => 'Nomor Telepon',
            'G' => 'Agama',
            'H' => 'Angkatan',
            'I' => 'Provinsi',
            'J' => 'Kota/Kabupaten',
            'K' => 'Kecamatan',
            'L' => 'Desa/Kelurahan',
            'M' => 'ID Program Studi',
            'N' => 'ID Keahlian',
            'O' => 'ID Semester',
        ];

        return $headers[$column] ?? $column;
    }
}
