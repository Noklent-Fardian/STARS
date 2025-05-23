<?php
namespace App\Http\Controllers;

use App\Models\Banner;
use App\Models\PdfSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class SystemController extends Controller
{
    
    public function system()
    {
        $pdfSetting = PdfSetting::first() ?? new PdfSetting();
        $banners = Banner::all();
        
        return view('admin.system.index', compact('pdfSetting', 'banners'));
    }
    
    /**
     * Update PDF settings
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
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $pdfSetting = PdfSetting::first();
        if (!$pdfSetting) {
            $pdfSetting = new PdfSetting();
        }

        $pdfSetting->pdf_instansi1 = $request->pdf_instansi1;
        $pdfSetting->pdf_instansi2 = $request->pdf_instansi2;
        $pdfSetting->pdf_alamat = $request->pdf_alamat;
        $pdfSetting->pdf_telepon = $request->pdf_telepon;
        $pdfSetting->pdf_fax = $request->pdf_fax;
        $pdfSetting->pdf_pes = $request->pdf_pes;
        $pdfSetting->pdf_website = $request->pdf_website;

        if ($request->hasFile('pdf_logo_kiri')) {
            if ($pdfSetting->pdf_logo_kiri) {
                Storage::disk('public')->delete($pdfSetting->pdf_logo_kiri);
            }
            
            $file = $request->file('pdf_logo_kiri');
            $filename = 'logo_kiri_' . time() . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('pdf_logos', $filename, 'public');
            $pdfSetting->pdf_logo_kiri = $path;
        }

        if ($request->hasFile('pdf_logo_kanan')) {
            if ($pdfSetting->pdf_logo_kanan) {
                Storage::disk('public')->delete($pdfSetting->pdf_logo_kanan);
            }
            
            $file = $request->file('pdf_logo_kanan');
            $filename = 'logo_kanan_' . time() . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('pdf_logos', $filename, 'public');
            $pdfSetting->pdf_logo_kanan = $path;
        }

        $pdfSetting->save();

        return redirect()->route('admin.system.index')
            ->with('success', 'Pengaturan kop surat berhasil diperbarui')
            ->with('tab', 'pdf');
    }
    
    
    /**
     * Update a banner
     */
    public function updateBanner(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'banner_nama' => 'required|string|max:255',
            'banner_link' => 'required|string|max:255',
            'banner_gambar' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput()
                ->with('tab', 'banner');
        }

        $banner = Banner::find($id);
        if (!$banner) {
            return redirect()->back()
                ->with('error', 'Banner tidak ditemukan')
                ->with('tab', 'banner');
        }

        $banner->banner_nama = $request->banner_nama;
        $banner->banner_link = $request->banner_link;

        if ($request->hasFile('banner_gambar')) {
            if ($banner->banner_gambar) {
                Storage::disk('public')->delete($banner->banner_gambar);
            }
            
            $file = $request->file('banner_gambar');
            $filename = 'banner_' . time() . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('banners', $filename, 'public');
            $banner->banner_gambar = $path;
        }

        $banner->save();

        return redirect()->route('admin.system.index')
            ->with('success', 'Banner berhasil diperbarui')
            ->with('tab', 'banner');
    }
    
    
    
    /**
     * Show banner edit form in modal
     */
    public function editBannerModal($id)
    {
        $banner = Banner::find($id);
        if (!$banner) {
            return response('Banner tidak ditemukan', 404);
        }
        
        return view('admin.system.banner_edit_modal', compact('banner'));
    }
    
}