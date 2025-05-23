<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PdfSetting extends Model
{
    use HasFactory;
    
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'm_pdf_settings';
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'pdf_instansi1',
        'pdf_instansi2',
        'pdf_logo_kiri', //max 100kb
        'pdf_logo_kanan', //max 100kb
        'pdf_alamat',
        'pdf_telepon',
        'pdf_fax',
        'pdf_pes',
        'pdf_website',
    ];
}