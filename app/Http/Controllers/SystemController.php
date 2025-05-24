<?php

namespace App\Http\Controllers;

use App\Models\Banner;
use App\Models\PdfSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;

class SystemController extends Controller
{
    public function system()
    {
        $pdfSetting = PdfSetting::first() ?? new PdfSetting();
        $banners = Banner::all();

        return view('admin.system.index', compact('pdfSetting', 'banners'));
    }

    /**
     * Update PDF settings with AJAX support
     */
    public function updatePdfSettings(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'pdf_instansi1' => 'nullable|string|max:255',
            'pdf_instansi2' => 'nullable|string|max:255',
            'pdf_logo_kiri' => 'nullable|image|mimes:jpeg,png,jpg|max:100',
            'pdf_logo_kanan' => 'nullable|image|mimes:jpeg,png,jpg|max:100',
            'pdf_alamat' => 'nullable|string|max:500',
            'pdf_telepon' => 'nullable|string|max:50',
            'pdf_fax' => 'nullable|string|max:50',
            'pdf_pes' => 'nullable|string|max:50',
            'pdf_website' => 'nullable|string|max:255',
        ], [
            'pdf_instansi1.max' => 'Nama instansi baris 1 maksimal 255 karakter',
            'pdf_instansi2.max' => 'Nama instansi baris 2 maksimal 255 karakter',
            'pdf_logo_kiri.image' => 'Logo kiri harus berupa gambar',
            'pdf_logo_kiri.mimes' => 'Logo kiri harus berformat JPG, JPEG, atau PNG',
            'pdf_logo_kiri.max' => 'Logo kiri maksimal 100KB',
            'pdf_logo_kanan.image' => 'Logo kanan harus berupa gambar',
            'pdf_logo_kanan.mimes' => 'Logo kanan harus berformat JPG, JPEG, atau PNG',
            'pdf_logo_kanan.max' => 'Logo kanan maksimal 100KB',
            'pdf_alamat.max' => 'Alamat maksimal 500 karakter',
            'pdf_telepon.max' => 'Nomor telepon maksimal 50 karakter',
            'pdf_fax.max' => 'Nomor fax maksimal 50 karakter',
            'pdf_pes.max' => 'Nomor pesawat maksimal 50 karakter',
            'pdf_website.max' => 'Website maksimal 255 karakter',
        ]);

        if ($validator->fails()) {
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Terdapat kesalahan dalam pengisian form',
                    'errors' => $validator->errors()
                ], 422);
            }

            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            $pdfSetting = PdfSetting::first();
            if (!$pdfSetting) {
                $pdfSetting = new PdfSetting();
            }

            // Save text fields
            $pdfSetting->pdf_instansi1 = $request->pdf_instansi1;
            $pdfSetting->pdf_instansi2 = $request->pdf_instansi2;
            $pdfSetting->pdf_alamat = $request->pdf_alamat;
            $pdfSetting->pdf_telepon = $request->pdf_telepon;
            $pdfSetting->pdf_fax = $request->pdf_fax;
            $pdfSetting->pdf_pes = $request->pdf_pes;
            $pdfSetting->pdf_website = $request->pdf_website;

            // Handle logo kiri upload
            if ($request->hasFile('pdf_logo_kiri')) {
                // Delete old file if exists
                if ($pdfSetting->pdf_logo_kiri && Storage::disk('public')->exists($pdfSetting->pdf_logo_kiri)) {
                    Storage::disk('public')->delete($pdfSetting->pdf_logo_kiri);
                }

                $file = $request->file('pdf_logo_kiri');
                $filename = 'logo_kiri_' . time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
                $path = $file->storeAs('pdf_logos', $filename, 'public');
                $pdfSetting->pdf_logo_kiri = $path;
            }

            // Handle logo kanan upload
            if ($request->hasFile('pdf_logo_kanan')) {
                // Delete old file if exists
                if ($pdfSetting->pdf_logo_kanan && Storage::disk('public')->exists($pdfSetting->pdf_logo_kanan)) {
                    Storage::disk('public')->delete($pdfSetting->pdf_logo_kanan);
                }

                $file = $request->file('pdf_logo_kanan');
                $filename = 'logo_kanan_' . time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
                $path = $file->storeAs('pdf_logos', $filename, 'public');
                $pdfSetting->pdf_logo_kanan = $path;
            }

            $pdfSetting->save();

            if ($request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Pengaturan kop surat PDF berhasil disimpan!',
                    'data' => [
                        'pdf_setting' => $pdfSetting,
                        'pdf_logo_kiri_url' => $pdfSetting->pdf_logo_kiri ? asset('storage/' . $pdfSetting->pdf_logo_kiri) : null,
                        'pdf_logo_kanan_url' => $pdfSetting->pdf_logo_kanan ? asset('storage/' . $pdfSetting->pdf_logo_kanan) : null,
                    ]
                ]);
            }

            return redirect()->route('admin.system.index')
                ->with('success', 'Pengaturan kop surat berhasil diperbarui')
                ->with('tab', 'pdf');
        } catch (\Exception $e) {
            Log::error('Error updating PDF settings: ' . $e->getMessage()); // Now this will work

            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Terjadi kesalahan sistem. Silakan coba lagi.',
                    'error' => config('app.debug') ? $e->getMessage() : 'Internal server error'
                ], 500);
            }

            return redirect()->back()
                ->with('error', 'Terjadi kesalahan sistem: ' . $e->getMessage())
                ->with('tab', 'pdf');
        }
    }


    /**
     * Update a banner with AJAX support
     */
    public function updateBanner(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'banner_nama' => 'required|string|max:255',
            'banner_link' => 'required|string|max:255',
            'banner_gambar' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        if ($validator->fails()) {
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'errors' => $validator->errors()
                ], 422);
            }

            return redirect()->back()
                ->withErrors($validator)
                ->withInput()
                ->with('tab', 'banner');
        }

        try {
            $banner = Banner::find($id);
            if (!$banner) {
                if ($request->ajax()) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Banner tidak ditemukan'
                    ], 404);
                }

                return redirect()->back()
                    ->with('error', 'Banner tidak ditemukan')
                    ->with('tab', 'banner');
            }

            $banner->banner_nama = $request->banner_nama;
            $banner->banner_link = $request->banner_link;

            if ($request->hasFile('banner_gambar')) {
                $file = $request->file('banner_gambar');
                $filename = 'banner_' . time() . '.' . $file->getClientOriginalExtension();
                $path = $file->storeAs('banners', $filename, 'public');
                $banner->banner_gambar = $path;
            }

            $banner->save();

            if ($request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Banner berhasil diperbarui',
                    'data' => $banner
                ]);
            }

            return redirect()->route('admin.system.index')
                ->with('success', 'Banner berhasil diperbarui')
                ->with('tab', 'banner');
        } catch (\Exception $e) {
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Terjadi kesalahan sistem: ' . $e->getMessage()
                ], 500);
            }

            return redirect()->back()
                ->with('error', 'Terjadi kesalahan sistem: ' . $e->getMessage())
                ->with('tab', 'banner');
        }
    }


    public function editBannerModal($id)
    {
        $banner = Banner::find($id);
        if (!$banner) {
            return response()->view('errors.404', [], 404);
        }

        return view('admin.system.banner_edit_modal', compact('banner'));
    }
}
