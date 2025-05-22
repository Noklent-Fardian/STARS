<?php
namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use Yajra\DataTables\Facades\DataTables;

class AdminManagementController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $page = (object) [
            'title' => 'Data Admin',
        ];

        return view('admin.adminManagement.index', compact('page'));
    }

    /**
     * Process datatables ajax request.
     */
    public function getAdminList(Request $request)
    {
        $admins = Admin::select(
            'm_admins.id',
            'm_admins.admin_name',
            'm_admins.admin_gender',
            'm_admins.admin_nomor_telepon',
            'm_admins.admin_photo',
            'm_admins.admin_visible',
            'users.username'
        )
            ->join('m_users as users', 'users.id', '=', 'm_admins.user_id')
            ->where('m_admins.admin_visible', true);

        return DataTables::of($admins)
            ->filterColumn('username', function ($query, $keyword) {
                $query->whereRaw("LOWER(users.username) LIKE ?", ["%" . strtolower($keyword) . "%"]);
            })
            ->addColumn('aksi', function ($admin) {
                $view = '<a href="' . url('/admin/adminManagement/show/' . $admin->id) . '" class="btn btn-sm btn-info mr-1"><i class="fas fa-eye"></i> Detail</a>';
                $edit = '<button onclick="modalAction(\'' . route('admin.adminManagement.editAjax', $admin->id) . '\')" class="btn btn-sm btn-warning mr-2">
                        <i class="fas fa-edit mr-1"></i> Edit
                    </button>';
                $delete = '<button onclick="modalAction(\'' . route('admin.adminManagement.confirmAjax', $admin->id) . '\')" class="btn btn-sm btn-danger mr-2">
                        <i class="fas fa-trash-alt mr-1"></i> Hapus
                    </button>';

                return $view . $edit . $delete;
            })
            ->editColumn('admin_gender', function ($admin) {
                return $admin->admin_gender == 'Laki-laki' ? 'Laki-laki' : 'Perempuan';
            })
            ->editColumn('admin_photo', function ($admin) {
                if ($admin->admin_photo) {
                    return '<img src="' . asset('storage/admin_photos/' . $admin->admin_photo) . '"
                        alt="' . $admin->admin_name . '" class="img-thumbnail" style="max-width: 50px;">';
                }
                return '<span class="badge badge-secondary">No Photo</span>';
            })
            ->rawColumns(['aksi', 'admin_photo'])
            ->make(true);
    }

    /**
     * Show the form for creating a new resource with AJAX.
     */
    public function createAjax()
    {
        return view('admin.adminManagement.create_ajax');
    }

    /**
     * Store a newly created resource in storage with AJAX.
     */
    public function storeAjax(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'admin_name'          => 'required|string|max:255',
            'admin_gender'        => 'required|in:Laki-laki,Perempuan',
            'admin_nomor_telepon' => 'required|string|max:15',
            'username'            => 'required|string|max:255|unique:m_users',
            'password'            => 'required|string|min:8',
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
                'username'      => $request->username,
                'user_password' => Hash::make($request->password),
                'user_role'     => 'Admin',
                'user_visible'  => true,
            ]);

            // Create admin profile
            Admin::create([
                'user_id'             => $user->id,
                'admin_name'          => $request->admin_name,
                'admin_gender'        => $request->admin_gender,
                'admin_nomor_telepon' => $request->admin_nomor_telepon,
                'admin_visible'       => true,
            ]);

            DB::commit();
            return response()->json([
                'status'  => true,
                'message' => 'Admin berhasil ditambahkan',
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
        $admin = Admin::with('user')->find($id);
        $page  = (object) [
            'title' => 'Detail Admin',
        ];

        return view('admin.adminManagement.show', compact('admin', 'page'));
    }

    /**
     * Show the form for editing the specified resource with AJAX.
     */
    public function editAjax($id)
    {
        $admin = Admin::with('user')->find($id);

        return view('admin.adminManagement.edit_ajax', compact('admin'));
    }

    /**
     * Update the specified resource in storage with AJAX.
     */
    public function updateAjax(Request $request, $id)
    {
        $admin = Admin::with('user')->find($id);

        $validator = Validator::make($request->all(), [
            'admin_name'          => 'required|string|max:255',
            'admin_gender'        => 'required|in:Laki-laki,Perempuan',
            'admin_nomor_telepon' => 'required|string|max:15',
            'username'            => [
                'required',
                'string',
                'max:255',
                Rule::unique('m_users')->ignore($admin->user_id),
            ],
            'password'            => 'nullable|string|min:8',
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
            if (! empty($request->password)) {
                $userData['user_password'] = Hash::make($request->password);
            }

            $admin->user->update($userData);

            // Update admin profile
            $admin->update([
                'admin_name'          => $request->admin_name,
                'admin_gender'        => $request->admin_gender,
                'admin_nomor_telepon' => $request->admin_nomor_telepon,
            ]);

            DB::commit();
            return response()->json([
                'status'  => true,
                'message' => 'Admin berhasil diperbarui',
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
        $admin = Admin::with('user')->find($id);

        return view('admin.adminManagement.confirm_ajax', compact('admin'));
    }

    /**
     * Remove the specified resource from storage with AJAX.
     */
    public function destroyAjax($id)
    {
        $admin = Admin::with('user')->find($id);

        if (! $admin) {
            return response()->json([
                'status'  => false,
                'message' => 'Admin tidak ditemukan',
            ]);
        }

        DB::beginTransaction();
        try {
            // Mark admin as invisible
            $admin->update([
                'admin_name'    => $admin->admin_name . ' (Dihapus pada ' . date('H:i d/m/Y') . ')',
                'admin_visible' => false,
            ]);

            if ($admin->user) {
                $admin->user->update([
                    'username'     => $admin->user->username . 'Dihapus pada ' . time(),
                    'user_visible' => false,
                ]);
            }

            DB::commit();
            return response()->json([
                'status'  => true,
                'message' => 'Admin berhasil dihapus',
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
        $admins = Admin::with('user')
            ->where('admin_visible', true)
            ->orderBy('admin_name', 'asc')
            ->get();

        $pdf = PDF::loadView('admin.adminManagement.export_pdf', compact('admins'));

        return $pdf->download('data-admin.pdf');
    }

    /**
     * Export data to Excel.
     */
    public function exportExcel()
    {
        $admins = Admin::with('user')
            ->where('admin_visible', true)
            ->orderBy('admin_name', 'asc')
            ->get();

        $spreadsheet = new Spreadsheet();
        $sheet       = $spreadsheet->getActiveSheet();

        $spreadsheet->getProperties()
            ->setCreator('STAR System')
            ->setLastModifiedBy('STAR System')
            ->setTitle('Data Admin')
            ->setSubject('Admin Export')
            ->setDescription('Daftar admin yang aktif dalam sistem');

        $sheet->setCellValue('A1', 'DAFTAR ADMIN');
        $sheet->mergeCells('A1:F1');
        $sheet->getStyle('A1')->getFont()->setBold(true)->setSize(16);
        $sheet->getStyle('A1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

        $sheet->setCellValue('A2', 'No');
        $sheet->setCellValue('B2', 'ID');
        $sheet->setCellValue('C2', 'Nama Admin');
        $sheet->setCellValue('D2', 'Username');
        $sheet->setCellValue('E2', 'Jenis Kelamin');
        $sheet->setCellValue('F2', 'Nomor Telepon');

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
        $sheet->getStyle('A2:F2')->applyFromArray($headerStyle);
        $sheet->getRowDimension(2)->setRowHeight(25);
        $sheet->freezePane('A3');

        $no  = 1;
        $row = 3;
        foreach ($admins as $admin) {
            $sheet->setCellValue('A' . $row, $no);
            $sheet->setCellValue('B' . $row, $admin->id);
            $sheet->setCellValue('C' . $row, $admin->admin_name);
            $sheet->setCellValue('D' . $row, $admin->user->username);
            $sheet->setCellValue('E' . $row, $admin->admin_gender == 'Laki-laki' ? 'Laki-laki' : 'Perempuan');
            $sheet->setCellValue('F' . $row, $admin->admin_nomor_telepon);

            $sheet->getStyle('A' . $row . ':F' . $row)->applyFromArray([
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

            $row++;
            $no++;
        }

        foreach (range('A', 'F') as $column) {
            $sheet->getColumnDimension($column)->setAutoSize(true);
        }

        $sheet->setTitle('Data Admin');

        $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');

        $filename = 'Data_Admin_' . date('Y-m-d_H-i-s') . '.xlsx';

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
        return view('admin.adminManagement.import');
    }

    /**
     * Import data from Excel
     */
    public function importExcel(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'file_admin' => 'required|mimes:xlsx|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status'   => false,
                'message'  => 'Validasi gagal',
                'msgField' => $validator->errors(),
            ]);
        }

        $file   = $request->file('file_admin');
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
                if (! in_array(strtoupper($rowData['C']), ['L', 'P'])) {
                    $errors[] = "Baris $row: Jenis kelamin harus 'L' atau 'P'";
                    continue;
                }

                // Check for duplicate username in database
                $existingUsername = User::where('username', $rowData['B'])->first();
                if ($existingUsername) {
                    $duplicateErrors[] = "Baris $row: Username '{$rowData['B']}' sudah terdaftar";
                    continue;
                }

                // Create user
                $user = User::create([
                    'username'      => $rowData['B'],
                    'user_password' => Hash::make('password'), // Default password
                    'user_role'     => 'Admin',
                    'user_visible'  => true,
                ]);

                // Create admin profile
                Admin::create([
                    'user_id'             => $user->id,
                    'admin_name'          => $rowData['A'],
                    'admin_gender'        => strtoupper($rowData['C']) == 'L' ? 'Laki-laki' : 'Perempuan',
                    'admin_nomor_telepon' => $rowData['D'],
                    'admin_visible'       => true,
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
                'message' => 'Data Admin berhasil diimport',
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

        $sheet->setCellValue('A1', 'Nama Admin');
        $sheet->setCellValue('B1', 'Username');
        $sheet->setCellValue('C1', 'Jenis Kelamin (L/P)');
        $sheet->setCellValue('D1', 'Nomor Telepon');

        $sheet->setCellValue('A2', 'Admin Contoh');
        $sheet->setCellValue('B2', 'admin_username');
        $sheet->setCellValue('C2', 'L');
        $sheet->setCellValue('D2', '081234567890');

        $sheet->getStyle('A1:D1')->getFont()->setBold(true);
        $sheet->getStyle('A1:D1')->getFill()
            ->setFillType(Fill::FILL_SOLID)
            ->getStartColor()->setRGB('102044');
        $sheet->getStyle('A1:D1')->getFont()->getColor()->setRGB('FFFFFF');

        foreach (range('A', 'D') as $column) {
            $sheet->getColumnDimension($column)->setAutoSize(true);
        }

        $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
        $path   = public_path('excel/template_admin.xlsx');

        if (! file_exists(dirname($path))) {
            mkdir(dirname($path), 0755, true);
        }

        $writer->save($path);

        return response()->download($path, 'template_admin.xlsx');
    }
}
