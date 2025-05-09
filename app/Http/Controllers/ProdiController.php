<?php
namespace App\Http\Controllers;

use App\Models\Prodi;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Yajra\DataTables\Facades\DataTables;

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
        $prodis = Prodi::orderBy('prodi_nama')->get();
        $pdf    = PDF::loadView('admin.prodi.export_pdf', compact('prodis'));

        // dd($prodis);
        return $pdf->download('data-prodi.pdf');
    }
}
