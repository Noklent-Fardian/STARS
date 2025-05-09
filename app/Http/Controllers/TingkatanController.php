<?php

namespace App\Http\Controllers;

use App\Models\Tingkatan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Validation\Rule;
use Barryvdh\DomPDF\Facade\Pdf;

class TingkatanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $page = (object) [
            'title' => 'Data Tingkatan Lomba'
        ];


        return view('admin.tingkatanLomba.index', compact('page'));
    }

    /**
     * Process datatables ajax request.
     */
    public function getTingkatanList(Request $request)
    {
        $tingkatans = Tingkatan::select('id', 'tingkatan_nama', 'tingkatan_point', 'tingkatan_visible')
            ->where('tingkatan_visible', true)
            ->orderBy('created_at', 'desc');

        return DataTables::of($tingkatans)
            ->addColumn('aksi', function ($tingkatan) {
                $view = '<a href="' . url('/admin/master/tingkatanLomba/show/' . $tingkatan->id) . '" class="btn btn-sm btn-info mr-1"><i class="fas fa-eye"></i>Detail</a>';
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
            'tingkatan_nama' => 'required|string|max:255|unique:m_tingkatans',
            'tingkatan_point' => 'required|integer|min:0',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validasi gagal. Periksa kembali data Anda.',
                'msgField' => $validator->errors(),
            ]);
        }

        Tingkatan::create([
            'tingkatan_nama' => $request->tingkatan_nama,
            'tingkatan_point' => $request->tingkatan_point,
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Tingkatan Lomba berhasil ditambahkan'
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $tingkatan = Tingkatan::find($id);
        $page = (object) [
            'title' => 'Detail Tingkatan Lomba'
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
            'tingkatan_nama' => [
                'required',
                'string',
                'max:255',
                Rule::unique('m_tingkatans')->ignore($id),
            ],
            'tingkatan_point' => 'required|integer|min:0',

        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validasi gagal. Periksa kembali data Anda.',
                'msgField' => $validator->errors(),
            ]);
        }

        $tingkatan->update([
            'tingkatan_nama' => $request->tingkatan_nama,
            'tingkatan_point' => $request->tingkatan_point,
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Tingkatan Lomba berhasil diperbarui',
            'self' => true
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

        if (!$tingkatan) {
            return response()->json([
                'status' => false,
                'message' => 'Tingkatan Lomba tidak ditemukan'
            ]);
        }

        // Update visibility instead of deleting
        $tingkatan->update([
            'tingkatan_visible' => false
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Tingkatan Lomba berhasil dihapus'
        ]);
    }

    /**
     * Export data to PDF.
     */
    public function exportPDF()
    {
        $tingkatans = Tingkatan::orderBy('tingkatan_point', 'desc')->get();
        $pdf = PDF::loadView('admin.tingkatanLomba.export_pdf', compact('tingkatans'));

        return $pdf->download('data-tingkatan-lomba.pdf');
    }
}
