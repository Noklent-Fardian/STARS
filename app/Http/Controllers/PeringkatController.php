<?php
namespace App\Http\Controllers;

use App\Models\Peringkat;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Yajra\DataTables\Facades\DataTables;

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
        $peringkats = Peringkat::orderBy('peringkat_bobot', 'desc')->get();
        $pdf        = PDF::loadView('admin.peringkatLomba.export_pdf', compact('peringkats'));

        return $pdf->download('data-peringkat-lomba.pdf');
    }
}
