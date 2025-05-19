<?php

namespace App\Http\Controllers;

use App\Models\Dosen;
use App\Models\Prodi;
use App\Models\User;
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

class DosenManagementController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $page = (object) [
            'title' => 'Data Dosen',
        ];

        $prodis = Prodi::where('prodi_visible', true)->get();

        return view('admin.dosenManagement.index', compact('page', 'prodis'));
    }

    /**
     * Process datatables ajax request.
     */
    public function getDosenList(Request $request)
    {
        $dosens = Dosen::select(
            'm_dosens.id',
            'm_dosens.dosen_nama',
            'm_dosens.dosen_nip',
            'm_dosens.dosen_status',
            'm_dosens.dosen_gender',
            'm_dosens.dosen_nomor_telepon',
            'm_dosens.dosen_photo',
            'm_dosens.dosen_visible',
            'm_dosens.prodi_id',
            'users.username',
            'm_prodis.prodi_nama'
        )
            ->join('m_users as users', 'users.id', '=', 'm_dosens.user_id')
            ->leftJoin('m_prodis', 'm_prodis.id', '=', 'm_dosens.prodi_id')
            ->where('m_dosens.dosen_visible', true);

        return DataTables::of($dosens)
            ->filter(function ($query) use ($request) {
                if ($request->has('search') && !empty($request->search['value'])) {
                    $search = strtolower($request->search['value']);
                    $query->where(function ($q) use ($search) {
                        $q->whereRaw('LOWER(m_dosens.id) LIKE ?', ["%{$search}%"])
                            ->orWhereRaw('LOWER(m_dosens.dosen_nama) LIKE ?', ["%{$search}%"])
                            ->orWhereRaw('LOWER(m_dosens.dosen_nip) LIKE ?', ["%{$search}%"])
                            ->orWhereRaw('LOWER(m_dosens.dosen_status) LIKE ?', ["%{$search}%"])
                            ->orWhereRaw('LOWER(users.username) LIKE ?', ["%{$search}%"])
                            ->orWhereRaw('LOWER(m_prodis.prodi_nama) LIKE ?', ["%{$search}%"])
                            ->orWhereRaw('LOWER(m_dosens.dosen_gender) LIKE ?', ["%{$search}%"]);
                    });
                }
            })->addColumn('aksi', function ($dosen) {
                $view = '<a href="' . url('/admin/dosenManagement/show/' . $dosen->id) . '" class="btn btn-sm btn-info mr-1"><i class="fas fa-eye"></i> Detail</a>';
                $edit = '<button onclick="modalAction(\'' . route('admin.dosenManagement.editAjax', $dosen->id) . '\')" class="btn btn-sm btn-warning mr-2">
                            <i class="fas fa-edit mr-1"></i> Edit
                        </button>';
                $delete = '<button onclick="modalAction(\'' . route('admin.dosenManagement.confirmAjax', $dosen->id) . '\')" class="btn btn-sm btn-danger mr-2">
                            <i class="fas fa-trash-alt mr-1"></i> Hapus
                        </button>';

                return $view . $edit . $delete;
            })
            ->editColumn('dosen_gender', function ($dosen) {
                return $dosen->dosen_gender == 'Laki-laki' ? 'Laki-laki' : 'Perempuan';
            })
            ->editColumn('dosen_photo', function ($dosen) {
                if ($dosen->dosen_photo) {
                    return '<img src="' . asset('storage/dosen_photos/' . $dosen->dosen_photo) . '" 
                            alt="' . $dosen->dosen_nama . '" class="img-thumbnail" style="max-width: 50px;">';
                }
                return '<span class="badge badge-secondary">No Photo</span>';
            })
            ->editColumn('dosen_status', function ($dosen) {
                $statuses = [
                    'Aktif' => 'success',
                    'Cuti' => 'warning',
                    'Resign' => 'danger',
                    'Pensiun' => 'secondary'
                ];
                $color = $statuses[$dosen->dosen_status] ?? 'info';
                return '<span class="badge badge-' . $color . '">' . $dosen->dosen_status . '</span>';
            })
            ->rawColumns(['aksi', 'dosen_photo', 'dosen_status'])
            ->make(true);
    }

    /**
     * Show the form for creating a new resource with AJAX.
     */
    public function createAjax()
    {
        $prodis = Prodi::where('prodi_visible', true)->get();
        return view('admin.dosenManagement.create_ajax', compact('prodis'));
    }

    /**
     * Store a newly created resource in storage with AJAX.
     */
    public function storeAjax(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'dosen_nama' => 'required|string|max:255',
            'dosen_nip' => 'required|string|max:255|unique:m_dosens',
            'dosen_status' => 'required|in:Aktif,Cuti,Resign,Pensiun',
            'dosen_gender' => 'required|in:Laki-laki,Perempuan',
            'dosen_nomor_telepon' => 'required|string|max:15',
            'dosen_agama' => 'nullable|string|max:255',
            'dosen_provinsi' => 'nullable|string|max:255',
            'dosen_kota' => 'nullable|string|max:255',
            'dosen_kecamatan' => 'nullable|string|max:255',
            'dosen_desa' => 'nullable|string|max:255',
            'prodi_id' => 'nullable|exists:m_prodis,id',
            'username' => 'required|string|max:255|unique:m_users',
            'password' => 'required|string|min:8',
            'dosen_photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
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
            // Create user account
            $user = User::create([
                'username' => $request->username,
                'user_password' => Hash::make($request->password),
                'user_role' => 'Dosen',
                'user_visible' => true,
            ]);

            // Handle photo upload
            $photoName = null;
            if ($request->hasFile('dosen_photo')) {
                $photo = $request->file('dosen_photo');
                $photoName = time() . '_' . $photo->getClientOriginalName();
                $photo->storeAs('public/dosen_photos', $photoName);
            }

            // Create dosen profile
            Dosen::create([
                'user_id' => $user->id,
                'prodi_id' => $request->prodi_id,
                'dosen_nama' => $request->dosen_nama,
                'dosen_nip' => $request->dosen_nip,
                'dosen_status' => $request->dosen_status,
                'dosen_gender' => $request->dosen_gender,
                'dosen_nomor_telepon' => $request->dosen_nomor_telepon,
                'dosen_agama' => $request->dosen_agama,
                'dosen_provinsi' => $request->dosen_provinsi,
                'dosen_kota' => $request->dosen_kota,
                'dosen_kecamatan' => $request->dosen_kecamatan,
                'dosen_desa' => $request->dosen_desa,
                'dosen_photo' => $photoName,
                'dosen_visible' => true,
            ]);

            DB::commit();
            return response()->json([
                'status'  => true,
                'message' => 'Dosen berhasil ditambahkan',
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
        $dosen = Dosen::with(['user', 'prodi'])->find($id);
        $page  = (object) [
            'title' => 'Detail Dosen',
        ];

        return view('admin.dosenManagement.show', compact('dosen', 'page'));
    }

    /**
     * Show the form for editing the specified resource with AJAX.
     */
    public function editAjax($id)
    {
        $dosen = Dosen::with(['user', 'prodi'])->find($id);
        $prodis = Prodi::where('prodi_visible', true)->get();

        return view('admin.dosenManagement.edit_ajax', compact('dosen', 'prodis'));
    }

    /**
     * Update the specified resource in storage with AJAX.
     */
    public function updateAjax(Request $request, $id)
    {
        $dosen = Dosen::with('user')->find($id);

        $validator = Validator::make($request->all(), [
            'dosen_nama' => 'required|string|max:255',
            'dosen_nip' => [
                'required',
                'string',
                'max:255',
                Rule::unique('m_dosens')->ignore($dosen->id),
            ],
            'dosen_status' => 'required|in:Aktif,Cuti,Resign,Pensiun',
            'dosen_gender' => 'required|in:Laki-laki,Perempuan',
            'dosen_nomor_telepon' => 'required|string|max:15',
            'dosen_agama' => 'nullable|string|max:255',
            'dosen_provinsi' => 'nullable|string|max:255',
            'dosen_kota' => 'nullable|string|max:255',
            'dosen_kecamatan' => 'nullable|string|max:255',
            'dosen_desa' => 'nullable|string|max:255',
            'prodi_id' => 'nullable|exists:m_prodis,id',
            'username' => [
                'required',
                'string',
                'max:255',
                Rule::unique('m_users')->ignore($dosen->user_id),
            ],
            'password' => 'nullable|string|min:8',
            'dosen_photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
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
            // Update user account
            $userData = [
                'username' => $request->username,
            ];

            // Only update password if provided
            if (!empty($request->password)) {
                $userData['user_password'] = Hash::make($request->password);
            }

            $dosen->user->update($userData);

            // Handle photo upload
            $photoName = $dosen->dosen_photo;
            if ($request->hasFile('dosen_photo')) {
                // Delete old photo if exists
                if ($photoName && file_exists(storage_path('app/public/dosen_photos/' . $photoName))) {
                    unlink(storage_path('app/public/dosen_photos/' . $photoName));
                }
                
                $photo = $request->file('dosen_photo');
                $photoName = time() . '_' . $photo->getClientOriginalName();
                $photo->storeAs('public/dosen_photos', $photoName);
            }

            // Update dosen profile
            $dosen->update([
                'prodi_id' => $request->prodi_id,
                'dosen_nama' => $request->dosen_nama,
                'dosen_nip' => $request->dosen_nip,
                'dosen_status' => $request->dosen_status,
                'dosen_gender' => $request->dosen_gender,
                'dosen_nomor_telepon' => $request->dosen_nomor_telepon,
                'dosen_agama' => $request->dosen_agama,
                'dosen_provinsi' => $request->dosen_provinsi,
                'dosen_kota' => $request->dosen_kota,
                'dosen_kecamatan' => $request->dosen_kecamatan,
                'dosen_desa' => $request->dosen_desa,
                'dosen_photo' => $photoName,
            ]);

            DB::commit();
            return response()->json([
                'status'  => true,
                'message' => 'Dosen berhasil diperbarui',
                'self'    => true,
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
     * Show confirmation dialog for deleting with AJAX.
     */
    public function confirmAjax($id)
    {
        $dosen = Dosen::with('user')->find($id);

        return view('admin.dosenManagement.confirm_ajax', compact('dosen'));
    }

    /**
     * Remove the specified resource from storage with AJAX.
     */
    public function destroyAjax($id)
    {
        $dosen = Dosen::with('user')->find($id);

        if (!$dosen) {
            return response()->json([
                'status'  => false,
                'message' => 'Dosen tidak ditemukan',
            ]);
        }

        DB::beginTransaction();
        try {
            // Delete photo if exists
            if ($dosen->dosen_photo && file_exists(storage_path('app/public/dosen_photos/' . $dosen->dosen_photo))) {
                unlink(storage_path('app/public/dosen_photos/' . $dosen->dosen_photo));
            }

            // Mark dosen as invisible
            $dosen->update([
                'dosen_nama' => $dosen->dosen_nama . ' (Dihapus pada ' . date('H:i d/m/Y') . ')',
                'dosen_visible' => false,
                'dosen_photo' => null,
            ]);

            if ($dosen->user) {
                $dosen->user->update([
                    'username' => $dosen->user->username . 'Dihapus pada ' . time(),
                    'user_visible' => false,
                ]);
            }

            DB::commit();
            return response()->json([
                'status'  => true,
                'message' => 'Dosen berhasil dihapus',
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
        $dosens = Dosen::with(['user', 'prodi'])
            ->where('dosen_visible', true)
            ->orderBy('dosen_nama', 'asc')
            ->get();

        $pdf = PDF::loadView('admin.dosenManagement.export_pdf', compact('dosens'));

        return $pdf->download('data-dosen.pdf');
    }

    /**
     * Export data to Excel.
     */
    public function exportExcel()
    {
        $dosens = Dosen::with(['user', 'prodi'])
            ->where('dosen_visible', true)
            ->orderBy('dosen_nama', 'asc')
            ->get();

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $spreadsheet->getProperties()
            ->setCreator('STAR System')
            ->setLastModifiedBy('STAR System')
            ->setTitle('Data Dosen')
            ->setSubject('Dosen Export')
            ->setDescription('Daftar dosen yang aktif dalam sistem');

        $sheet->setCellValue('A1', 'DAFTAR DOSEN');
        $sheet->mergeCells('A1:K1');
        $sheet->getStyle('A1')->getFont()->setBold(true)->setSize(16);
        $sheet->getStyle('A1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

        $sheet->setCellValue('A2', 'No');
        $sheet->setCellValue('B2', 'ID');
        $sheet->setCellValue('C2', 'Nama Dosen');
        $sheet->setCellValue('D2', 'NIP');
        $sheet->setCellValue('E2', 'Status');
        $sheet->setCellValue('F2', 'Username');
        $sheet->setCellValue('G2', 'Jenis Kelamin');
        $sheet->setCellValue('H2', 'Nomor Telepon');
        $sheet->setCellValue('I2', 'Agama');
        $sheet->setCellValue('J2', 'Alamat');
        $sheet->setCellValue('K2', 'Program Studi');

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
        $sheet->getStyle('A2:K2')->applyFromArray($headerStyle);
        $sheet->getRowDimension(2)->setRowHeight(25);
        $sheet->freezePane('A3');

        $no = 1;
        $row = 3;
        foreach ($dosens as $dosen) {
            $alamat = implode(', ', array_filter([
                $dosen->dosen_desa,
                $dosen->dosen_kecamatan,
                $dosen->dosen_kota,
                $dosen->dosen_provinsi
            ]));

            $sheet->setCellValue('A' . $row, $no);
            $sheet->setCellValue('B' . $row, $dosen->id);
            $sheet->setCellValue('C' . $row, $dosen->dosen_nama);
            $sheet->setCellValue('D' . $row, $dosen->dosen_nip);
            $sheet->setCellValue('E' . $row, $dosen->dosen_status);
            $sheet->setCellValue('F' . $row, $dosen->user->username);
            $sheet->setCellValue('G' . $row, $dosen->dosen_gender == 'Laki-laki' ? 'Laki-laki' : 'Perempuan');
            $sheet->setCellValue('H' . $row, $dosen->dosen_nomor_telepon);
            $sheet->setCellValue('I' . $row, $dosen->dosen_agama ?? '-');
            $sheet->setCellValue('J' . $row, $alamat ?: '-');
            $sheet->setCellValue('K' . $row, $dosen->prodi ? $dosen->prodi->prodi_nama : '-');

            $sheet->getStyle('A' . $row . ':K' . $row)->applyFromArray([
                'borders' => [
                    'allBorders' => [
                        'borderStyle' => Border::BORDER_THIN,
                        'color' => ['rgb' => '000000']
                    ]
                ]
            ]);

            $sheet->getStyle('A' . $row)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle('B' . $row)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle('E' . $row)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle('G' . $row)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

            $row++;
            $no++;
        }

        foreach (range('A', 'K') as $column) {
            $sheet->getColumnDimension($column)->setAutoSize(true);
        }

        $sheet->setTitle('Data Dosen');

        $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');

        $filename = 'Data_Dosen_' . date('Y-m-d_H-i-s') . '.xlsx';

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
        return view('admin.dosenManagement.import');
    }

    /**
     * Import data from Excel
     */
    public function importExcel(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'file_dosen' => 'required|mimes:xlsx|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validasi gagal',
                'msgField' => $validator->errors()
            ]);
        }

        $file = $request->file('file_dosen');
        $reader = IOFactory::createReader('Xlsx');
        $reader->setReadDataOnly(true);
        $spreadsheet = $reader->load($file->getRealPath());
        $sheet = $spreadsheet->getActiveSheet();
        $data = $sheet->toArray(null, true, true, true);

        $errors = [];
        $duplicateErrors = [];
        $insertData = [];
        $row = 1;

        DB::beginTransaction();

        try {
            foreach ($data as $index => $rowData) {
                $row++;

                if ($index == 1) {
                    continue; // Skip header row
                }

                // Validate required fields
                if (empty($rowData['A']) || empty($rowData['B']) || empty($rowData['C']) || empty($rowData['D'])) {
                    $errors[] = "Baris $row: Semua kolom harus diisi";
                    continue;
                }

                // Validate username format
                if (strlen($rowData['B']) < 3 || strlen($rowData['B']) > 255) {
                    $errors[] = "Baris $row: Username '{$rowData['B']}' harus antara 3-255 karakter";
                    continue;
                }

                // Validate gender
                if (!in_array(strtoupper($rowData['C']), ['L', 'P'])) {
                    $errors[] = "Baris $row: Jenis kelamin harus 'L' atau 'P'";
                    continue;
                }

                // Validate status
                if (!empty($rowData['E']) && !in_array($rowData['E'], ['Aktif', 'Cuti', 'Resign', 'Pensiun'])) {
                    $errors[] = "Baris $row: Status harus salah satu dari: Aktif, Cuti, Resign, Pensiun";
                    continue;
                }

                // Check for duplicate username in database
                $existingUsername = User::where('username', $rowData['B'])->first();
                if ($existingUsername) {
                    $duplicateErrors[] = "Baris $row: Username '{$rowData['B']}' sudah terdaftar";
                    continue;
                }

                // Check for duplicate NIP in database
                $existingNIP = Dosen::where('dosen_nip', $rowData['D'])->first();
                if ($existingNIP) {
                    $duplicateErrors[] = "Baris $row: NIP '{$rowData['D']}' sudah terdaftar";
                    continue;
                }

                // Create user
                $user = User::create([
                    'username' => $rowData['B'],
                    'user_password' => Hash::make('password'), // Default password
                    'user_role' => 'Dosen',
                    'user_visible' => true,
                ]);

                // Create dosen profile
                Dosen::create([
                    'user_id' => $user->id,
                    'dosen_nama' => $rowData['A'],
                    'dosen_nip' => $rowData['D'],
                    'dosen_status' => $rowData['E'] ?? 'Aktif',
                    'dosen_gender' => strtoupper($rowData['C']) == 'L' ? 'Laki-laki' : 'Perempuan',
                    'dosen_nomor_telepon' => $rowData['F'] ?? null,
                    'dosen_agama' => $rowData['G'] ?? null,
                    'dosen_provinsi' => $rowData['H'] ?? null,
                    'dosen_kota' => $rowData['I'] ?? null,
                    'dosen_kecamatan' => $rowData['J'] ?? null,
                    'dosen_desa' => $rowData['K'] ?? null,
                    'dosen_visible' => true,
                ]);
            }

            if (!empty($duplicateErrors) || !empty($errors)) {
                DB::rollBack();
                $allErrors = array_merge($errors, $duplicateErrors);
                return response()->json([
                    'status' => false,
                    'message' => 'Terdapat kesalahan pada data yang diimport',
                    'errors' => $allErrors
                ]);
            }

            DB::commit();
            return response()->json([
                'status' => true,
                'message' => 'Data Dosen berhasil diimport'
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
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

        $sheet->setCellValue('A1', 'Nama Dosen');
        $sheet->setCellValue('B1', 'Username');
        $sheet->setCellValue('C1', 'Jenis Kelamin (L/P)');
        $sheet->setCellValue('D1', 'NIP');
        $sheet->setCellValue('E1', 'Status (Aktif/Cuti/Resign/Pensiun)');
        $sheet->setCellValue('F1', 'Nomor Telepon');
        $sheet->setCellValue('G1', 'Agama');
        $sheet->setCellValue('H1', 'Provinsi');
        $sheet->setCellValue('I1', 'Kota/Kabupaten');
        $sheet->setCellValue('J1', 'Kecamatan');
        $sheet->setCellValue('K1', 'Desa/Kelurahan');

        $sheet->setCellValue('A2', 'Dosen Contoh');
        $sheet->setCellValue('B2', 'dosen_username');
        $sheet->setCellValue('C2', 'L');
        $sheet->setCellValue('D2', '123456789012345678');
        $sheet->setCellValue('E2', 'Aktif');
        $sheet->setCellValue('F2', '081234567890');
        $sheet->setCellValue('G2', 'Islam');
        $sheet->setCellValue('H2', 'Jawa Barat');
        $sheet->setCellValue('I2', 'Bandung');
        $sheet->setCellValue('J2', 'Coblong');
        $sheet->setCellValue('K2', 'Dago');

        $sheet->getStyle('A1:K1')->getFont()->setBold(true);
        $sheet->getStyle('A1:K1')->getFill()
            ->setFillType(Fill::FILL_SOLID)
            ->getStartColor()->setRGB('102044');
        $sheet->getStyle('A1:K1')->getFont()->getColor()->setRGB('FFFFFF');

        foreach (range('A', 'K') as $column) {
            $sheet->getColumnDimension($column)->setAutoSize(true);
        }

        $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
        $path = public_path('excel/template_dosen.xlsx');

        if (!file_exists(dirname($path))) {
            mkdir(dirname($path), 0755, true);
        }

        $writer->save($path);

        return response()->download($path, 'template_dosen.xlsx');
    }
}