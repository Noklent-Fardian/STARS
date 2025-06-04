<?php

namespace App\Http\Controllers;

use App\Models\Dosen;
use App\Models\Keahlian;
use App\Models\KeahlianDosen;
use App\Models\Prodi;
use App\Models\CompetitionSubmission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;

class DosenController extends Controller
{
    public function index()
    {
        $dosen = Auth::user()->dosen;
        return view('dosbim.index', compact('dosen'));
    }
    public function profile()
    {
        $dosen = Auth::user()->dosen->load(['keahlianUtama', 'keahlianTambahan']);
        return view('dosbim.profile.index', compact('dosen'));
    }

    public function editProfile()
    {
        $dosen = Auth::user()->dosen;
        $prodis = Prodi::all();
        $keahlians = Keahlian::all();
        return view('dosbim.profile.edit', compact('dosen', 'prodis', 'keahlians'));
    }
    public function updateProfile(Request $request)
    {
        $dosen = Auth::user()->dosen;

        $validated = $request->validate([
            'dosen_nomor_telepon' => 'nullable|string|max:20',
            'keahlian_id' => 'required|exists:m_keahlians,id',
            'keahlian_tambahan' => 'array',
            'keahlian_tambahan.*' => 'exists:m_keahlians,id',
            'dosen_provinsi' => 'nullable|string|max:100',
            'dosen_kota' => 'nullable|string|max:100',
            'dosen_kecamatan' => 'nullable|string|max:100',
            'dosen_desa' => 'nullable|string|max:100',
            'dosen_photo' => 'nullable|image|mimes:jpeg,jpg,png,webp|max:2048',
            'keahlian_sertifikat' => 'nullable|url',
            'keahlian_sertifikat_tambahan' => 'array',
            'keahlian_sertifikat_tambahan.*' => 'nullable|url',
        ]);

        try {
            if ($request->hasFile('dosen_photo')) {
                $file = $request->file('dosen_photo');
                $path = $file->store('dosen_photo', 'public');
                $validated['dosen_photo'] = $path;
            }

            $dosen->update([
                'dosen_nomor_telepon' => $validated['dosen_nomor_telepon'] ?? null,
                'keahlian_id' => $validated['keahlian_id'],
                'keahlian_sertifikat' => $validated['keahlian_sertifikat'] ?? null,
                'dosen_provinsi' => $validated['dosen_provinsi'] ?? null,
                'dosen_kota' => $validated['dosen_kota'] ?? null,
                'dosen_kecamatan' => $validated['dosen_kecamatan'] ?? null,
                'dosen_desa' => $validated['dosen_desa'] ?? null,
                'dosen_photo' => $validated['dosen_photo'] ?? $dosen->dosen_photo,
            ]);

            $keahlianTambahan = $validated['keahlian_tambahan'] ?? [];
            $sertifikatTambahan = $validated['keahlian_sertifikat_tambahan'] ?? [];
            $pivotData = [];
            foreach ($keahlianTambahan as $kid) {
                $pivotData[$kid] = [
                    'keahlian_sertifikat' => $sertifikatTambahan[$kid] ?? null
                ];
            }
            $dosen->keahlianTambahan()->sync($pivotData);

            if ($request->ajax()) {
                return response()->json(['message' => 'Profil berhasil diperbarui.']);
            }
            return redirect()->route('dosen.profile')->with('success', 'Profil berhasil diperbarui.');
        } catch (\Exception $e) {
            if ($request->ajax()) {
                return response()->json(['message' => 'Profil gagal diperbarui.'], 500);
            }
            return redirect()->back()->withErrors(['error' => 'Profil gagal diperbarui.']);
        }
    }
    public function updatePassword(Request $request)
    {
        $request->validate([
            'password' => 'required|string|min:6|confirmed',
        ]);

        $user = Auth::user();
        $user->user_password = bcrypt($request->password);
        $user->save();

        if ($request->ajax()) {
            return response()->json(['message' => 'Password berhasil diubah.']);
        }

        return redirect()->route('dosen.profile')->with('success', 'Password berhasil diubah.');
    }

   public function updatePhoto(Request $request)
    {
        $messages = [
            'dosen_photo.required' => 'Silakan pilih foto terlebih dahulu.',
            'dosen_photo.image'    => 'File harus berupa gambar.',
            'dosen_photo.mimes'    => 'Format foto harus jpeg, jpg, png, atau webp.',
            'dosen_photo.max'      => 'Ukuran foto tidak boleh lebih dari 2MB.',
        ];

        $validator = Validator::make($request->all(), [
            'dosen_photo' => 'required|image|mimes:jpeg,jpg,png,webp|max:2048',
        ], $messages);

        if ($validator->fails()) {
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => $validator->errors()->first(),
                ], 422);
            }
            return redirect()->back()->with('error', $validator->errors()->first());
        }

        $dosen = Auth::user()->dosen;

        // Delete old photo if exists
        if ($dosen->dosen_photo && Storage::disk('public')->exists($dosen->dosen_photo)) {
            Storage::disk('public')->delete($dosen->dosen_photo);
        }

        try {
            if ($request->hasFile('dosen_photo')) {
                $file = $request->file('dosen_photo');
                $path = $file->store('dosen_photos', 'public');
                $dosen->dosen_photo = $path;
                $dosen->save();
            }

            if ($request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Foto profil berhasil diubah.',
                    'photo_url' => asset('storage/' . $dosen->dosen_photo)
                ]);
            }

            return redirect()->back()->with('success', 'Foto profil berhasil diubah.');
        } catch (\Exception $e) {
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Terjadi kesalahan saat mengunggah foto. Silakan coba lagi.',
                ], 500);
            }
            return redirect()->back()->with('error', 'Terjadi kesalahan saat mengunggah foto.');
        }
    }


    public function riwayatPengajuanLombaIndex()
    {
        return view('dosbim.riwayatPengajuanLomba.index');
    }

    public function riwayatPengajuanLombaList(Request $request)
    {
        $dosen = Auth::user()->dosen;

        $submissions = CompetitionSubmission::with(['lomba.tingkatan', 'lomba.keahlians'])
            ->where('dosen_id', $dosen->id)
            ->select('*');

        if ($request->status && $request->status != '') {
            $submissions->where('pendaftaran_status', $request->status);
        }

        return DataTables::of($submissions)
            ->addIndexColumn()
            ->addColumn('aksi', function ($row) {
                return '<a href="' . route('dosen.riwayatPengajuanLomba.show', $row->id) . '" 
                           class="btn btn-info btn-sm" 
                           title="Lihat Detail">
                            <i class="fas fa-eye">Detail</i>
                        </a>';
            })
            ->editColumn('pendaftaran_status', function ($row) {
                if ($row->pendaftaran_status === 'Menunggu') {
                    return '<span class="badge badge-warning"><i class="fas fa-clock mr-1"></i> Menunggu</span>';
                } elseif ($row->pendaftaran_status === 'Diterima') {
                    return '<span class="badge badge-success"><i class="fas fa-check mr-1"></i> Diterima</span>';
                } else {
                    return '<span class="badge badge-danger"><i class="fas fa-times mr-1"></i> Ditolak</span>';
                }
            })
            ->with([
                'statistics' => [
                    'pending' => CompetitionSubmission::where('dosen_id', $dosen->id)->where('pendaftaran_status', 'Menunggu')->count(),
                    'approved' => CompetitionSubmission::where('dosen_id', $dosen->id)->where('pendaftaran_status', 'Diterima')->count(),
                    'rejected' => CompetitionSubmission::where('dosen_id', $dosen->id)->where('pendaftaran_status', 'Ditolak')->count(),
                    'total' => CompetitionSubmission::where('dosen_id', $dosen->id)->count(),
                ]
            ])
            ->rawColumns(['aksi', 'pendaftaran_status'])
            ->make(true);
    }

    public function riwayatPengajuanLombaShow($id)
    {
        $dosen = Auth::user()->dosen;
        $submission = CompetitionSubmission::with(['lomba.tingkatan', 'lomba.keahlians', 'lomba.semester'])
            ->where('dosen_id', $dosen->id)
            ->findOrFail($id);

        return view('dosbim.riwayatPengajuanLomba.show', compact('submission'));
    }
}
