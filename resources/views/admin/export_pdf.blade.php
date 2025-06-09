<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <link rel="stylesheet" href="{{ public_path('css/exportPdf.css') }}">
    <style>
        .summary-stats {
            display: table;
            width: 100%;
            margin: 20px 0;
        }
        .stat-item {
            display: table-cell;
            width: 25%;
            text-align: center;
            border: 1px solid #ddd;
            padding: 10px;
            background-color: #f8f9fc;
        }
        .stat-number {
            font-size: 20pt;
            font-weight: bold;
            color: var(--primary-color);
            display: block;
        }
        .stat-label {
            font-size: 9pt;
            color: var(--light-text);
            text-transform: uppercase;
        }
        .chart-placeholder {
            border: 2px dashed #ddd;
            padding: 20px;
            text-align: center;
            margin: 10px 0;
            background-color: #f8f9fc;
        }
        .performance-grid {
            display: table;
            width: 100%;
            margin: 15px 0;
        }
        .performance-item {
            display: table-cell;
            width: 50%;
            padding: 8px;
            border: 1px solid #ddd;
        }
        .section-title {
            background-color: var(--primary-color);
            color: white;
            padding: 8px 12px;
            margin: 20px 0 10px 0;
            font-weight: bold;
            font-size: 12pt;
        }
        .page-break {
            page-break-before: always;
        }
    </style>
</head>

<body>
    {{-- Header --}}
    <table class="letterhead">
        <tr>
            <td width="15%" class="text-center">
                @if(isset($pdfSetting) && $pdfSetting->pdf_logo_kiri)
                    <img src="{{ public_path('storage/' . $pdfSetting->pdf_logo_kiri) }}" alt="Logo Kiri" class="logo">
                @else
                    <img src="{{ public_path('img/poltek100.png') }}" alt="Logo Polinema" class="logo">
                @endif
            </td>
            <td width="70%" class="text-center">
                <div class="ministry">{{ isset($pdfSetting) && $pdfSetting->pdf_instansi1 ? $pdfSetting->pdf_instansi1 : 'STARS - Student Achievement Record System' }}</div>
                <div class="institution">{{ isset($pdfSetting) && $pdfSetting->pdf_instansi2 ? $pdfSetting->pdf_instansi2 : 'POLITEKNIK NEGERI MALANG' }}</div>
                <div class="address">{{ isset($pdfSetting) && $pdfSetting->pdf_alamat ? $pdfSetting->pdf_alamat : 'Jl. Soekarno-Hatta No. 9 Malang 65141' }}</div>
                <div class="address">
                    Telepon {{ isset($pdfSetting) && $pdfSetting->pdf_telepon ? $pdfSetting->pdf_telepon : '(0341) 404424' }}
                    {{ isset($pdfSetting) && $pdfSetting->pdf_pes ? ' Pes. ' . $pdfSetting->pdf_pes : ' Pes. 101-105, 0341-404420' }}
                    {{ isset($pdfSetting) && $pdfSetting->pdf_fax ? ', Fax. ' . $pdfSetting->pdf_fax : ', Fax. (0341) 404420' }}
                </div>
                <div class="address">Laman: {{ isset($pdfSetting) && $pdfSetting->pdf_website ? $pdfSetting->pdf_website : 'www.polinema.ac.id' }}</div>
            </td>
            <td width="15%" class="text-center">
                @if(isset($pdfSetting) && $pdfSetting->pdf_logo_kanan)
                    <img src="{{ public_path('storage/' . $pdfSetting->pdf_logo_kanan) }}" alt="Logo Kanan" class="logo">
                @else
                    <img src="{{ public_path('img/logo100.png') }}" alt="Logo Stars" class="logo">
                @endif
            </td>
        </tr>
    </table>

    <div class="document-title">LAPORAN STATISTIK DAN ANALISIS SISTEM STAR</div>
    <div class="text-center" style="margin-bottom: 30px; font-size: 11pt;">
        Periode: {{ now()->format('d F Y') }}
    </div>

    {{-- Executive Summary --}}
    <div class="section-title">RINGKASAN EKSEKUTIF</div>
    <div class="summary-stats">
        <div class="stat-item">
            <span class="stat-number">{{ number_format($stats['total_mahasiswa']) }}</span>
            <span class="stat-label">Total Mahasiswa</span>
        </div>
        <div class="stat-item">
            <span class="stat-number">{{ number_format($stats['total_dosen']) }}</span>
            <span class="stat-label">Total Dosen</span>
        </div>
        <div class="stat-item">
            <span class="stat-number">{{ number_format($stats['total_prestasi']) }}</span>
            <span class="stat-label">Total Prestasi</span>
        </div>
        <div class="stat-item">
            <span class="stat-number">{{ number_format($stats['verified_prestasi']) }}</span>
            <span class="stat-label">Prestasi Terverifikasi</span>
        </div>
    </div>

    <div class="summary-stats">
        <div class="stat-item">
            <span class="stat-number">{{ number_format($stats['total_lomba']) }}</span>
            <span class="stat-label">Total Lomba</span>
        </div>
        <div class="stat-item">
            <span class="stat-number">{{ number_format($stats['pending_verifikasi_prestasi']) }}</span>
            <span class="stat-label">Prestasi Pending</span>
        </div>
        <div class="stat-item">
            <span class="stat-number">{{ $performanceMetrics['verification_rate'] }}%</span>
            <span class="stat-label">Tingkat Verifikasi</span>
        </div>
        <div class="stat-item">
            <span class="stat-number">{{ number_format($performanceMetrics['avg_score_per_student'], 1) }}</span>
            <span class="stat-label">Rata-rata Skor Mahasiswa</span>
        </div>
    </div>

    {{-- Performance Metrics --}}
    <div class="section-title">METRIK KINERJA SISTEM</div>
    <div class="performance-grid">
        <div class="performance-item">
            <strong>Tingkat Verifikasi Prestasi:</strong><br>
            {{ $performanceMetrics['verification_rate'] }}% ({{ number_format($stats['verified_prestasi']) }} dari {{ number_format($stats['total_prestasi']) }} prestasi)
        </div>
        <div class="performance-item">
            <strong>Tingkat Pending:</strong><br>
            {{ $performanceMetrics['pending_rate'] }}% ({{ number_format($stats['pending_verifikasi_prestasi']) }} prestasi menunggu)
        </div>
    </div>
    <div class="performance-grid">
        <div class="performance-item">
            <strong>Rata-rata Skor per Mahasiswa:</strong><br>
            {{ number_format($performanceMetrics['avg_score_per_student'], 2) }} poin
        </div>
        <div class="performance-item">
            <strong>Rata-rata Skor per Dosen:</strong><br>
            {{ number_format($performanceMetrics['avg_score_per_lecturer'], 2) }} poin
        </div>
    </div>

    {{-- Prestasi by Tingkatan --}}
    <div class="section-title">DISTRIBUSI PRESTASI BERDASARKAN TINGKATAN</div>
    <table class="data-table">
        <thead>
            <tr>
                <th width="10%">No</th>
                <th width="60%">Tingkatan Lomba</th>
                <th width="15%">Jumlah</th>
                <th width="15%">Persentase</th>
            </tr>
        </thead>
        <tbody>
            @php $totalPrestasi = $prestasiByTingkatan->sum('total'); @endphp
            @foreach($prestasiByTingkatan as $item)
            <tr>
                <td class="text-center">{{ $loop->iteration }}</td>
                <td>{{ $item->tingkatan_nama }}</td>
                <td class="text-center">{{ number_format($item->total) }}</td>
                <td class="text-center">{{ $totalPrestasi > 0 ? number_format(($item->total / $totalPrestasi) * 100, 1) : 0 }}%</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    {{-- Page Break --}}
    <div class="page-break"></div>

    {{-- Prestasi by Program Studi --}}
    <div class="section-title">DISTRIBUSI PRESTASI BERDASARKAN PROGRAM STUDI</div>
    <table class="data-table">
        <thead>
            <tr>
                <th width="10%">No</th>
                <th width="60%">Program Studi</th>
                <th width="15%">Jumlah</th>
                <th width="15%">Persentase</th>
            </tr>
        </thead>
        <tbody>
            @php $totalByProdi = $prestasiByProdi->sum('total'); @endphp
            @foreach($prestasiByProdi as $item)
            <tr>
                <td class="text-center">{{ $loop->iteration }}</td>
                <td>{{ $item->prodi_nama }}</td>
                <td class="text-center">{{ number_format($item->total) }}</td>
                <td class="text-center">{{ $totalByProdi > 0 ? number_format(($item->total / $totalByProdi) * 100, 1) : 0 }}%</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    {{-- Top Students --}}
    <div class="section-title">TOP 10 MAHASISWA BERPRESTASI</div>
    <table class="data-table">
        <thead>
            <tr>
                <th width="8%">Rank</th>
                <th width="15%">NIM</th>
                <th width="32%">Nama Mahasiswa</th>
                <th width="30%">Program Studi</th>
                <th width="15%">Total Skor</th>
            </tr>
        </thead>
        <tbody>
            @foreach($topStudents as $student)
            <tr>
                <td class="text-center">{{ $loop->iteration }}</td>
                <td class="text-center">{{ $student->mahasiswa_nim }}</td>
                <td>{{ $student->mahasiswa_nama }}</td>
                <td>{{ $student->prodi_nama }}</td>
                <td class="text-center">{{ number_format($student->mahasiswa_score, 1) }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    {{-- Top Lecturers --}}
    <div class="section-title">TOP 10 DOSEN PEMBIMBING</div>
    <table class="data-table">
        <thead>
            <tr>
                <th width="8%">Rank</th>
                <th width="15%">NIP</th>
                <th width="32%">Nama Dosen</th>
                <th width="30%">Program Studi</th>
                <th width="15%">Total Skor</th>
            </tr>
        </thead>
        <tbody>
            @foreach($topLecturers as $lecturer)
            <tr>
                <td class="text-center">{{ $loop->iteration }}</td>
                <td class="text-center">{{ $lecturer->dosen_nip }}</td>
                <td>{{ $lecturer->dosen_nama }}</td>
                <td>{{ $lecturer->prodi_nama ?? 'N/A' }}</td>
                <td class="text-center">{{ number_format($lecturer->dosen_score, 1) }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    {{-- Page Break --}}
    <div class="page-break"></div>

    {{-- Competition Categories --}}
    <div class="section-title">ANALISIS KATEGORI LOMBA</div>
    <table class="data-table">
        <thead>
            <tr>
                <th width="10%">No</th>
                <th width="60%">Kategori Lomba</th>
                <th width="15%">Jumlah</th>
                <th width="15%">Persentase</th>
            </tr>
        </thead>
        <tbody>
            @php $totalCategories = $competitionCategories->sum('total'); @endphp
            @foreach($competitionCategories as $category)
            <tr>
                <td class="text-center">{{ $loop->iteration }}</td>
                <td>{{ $category->lomba_kategori }}</td>
                <td class="text-center">{{ number_format($category->total) }}</td>
                <td class="text-center">{{ $totalCategories > 0 ? number_format(($category->total / $totalCategories) * 100, 1) : 0 }}%</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    {{-- Monthly Trends --}}
    <div class="section-title">TREN BULANAN (12 BULAN TERAKHIR)</div>
    <table class="data-table">
        <thead>
            <tr>
                <th width="40%">Bulan</th>
                <th width="30%">Lomba Terverifikasi</th>
                <th width="30%">Prestasi Baru</th>
            </tr>
        </thead>
        <tbody>
            @foreach($monthlyData['months'] as $index => $month)
            <tr>
                <td>{{ $month }}</td>
                <td class="text-center">{{ number_format($monthlyData['lomba'][$index]) }}</td>
                <td class="text-center">{{ number_format($monthlyData['prestasi'][$index]) }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    {{-- Recent Activities --}}
    <div class="section-title">AKTIVITAS PRESTASI TERBARU (20 TERAKHIR)</div>
    <table class="data-table">
        <thead>
            <tr>
                <th width="8%">No</th>
                <th width="25%">Mahasiswa</th>
                <th width="30%">Judul Prestasi</th>
                <th width="25%">Lomba</th>
                <th width="12%">Tanggal</th>
            </tr>
        </thead>
        <tbody>
            @foreach($recentActivities as $activity)
            <tr>
                <td class="text-center">{{ $loop->iteration }}</td>
                <td>{{ $activity->mahasiswa->mahasiswa_nama ?? 'N/A' }}</td>
                <td>{{ Str::limit($activity->penghargaan_judul, 40) }}</td>
                <td>{{ $activity->lomba->lomba_nama ?? 'N/A' }}</td>
                <td class="text-center">{{ $activity->created_at ? $activity->created_at->format('d/m/Y') : 'N/A' }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    {{-- Footer --}}
    <div class="footer">
        <strong>Kesimpulan:</strong><br>
        Sistem STAR telah mencatat {{ number_format($stats['total_prestasi']) }} prestasi dari {{ number_format($stats['total_mahasiswa']) }} mahasiswa dengan tingkat verifikasi {{ $performanceMetrics['verification_rate'] }}%. 
        Rata-rata skor per mahasiswa adalah {{ number_format($performanceMetrics['avg_score_per_student'], 2) }} poin, menunjukkan aktifitas prestasi yang {{ $performanceMetrics['avg_score_per_student'] > 50 ? 'sangat baik' : ($performanceMetrics['avg_score_per_student'] > 25 ? 'baik' : 'perlu ditingkatkan') }}.
        <br><br>
        Dokumen ini digenerate pada {{ now()->format('d F Y H:i') }} WIB oleh {{ $admin->admin_name ?? 'Admin' }}
    </div>

    <div class="page-number">
        STAR SYSTEM - {{ now()->format('Y') }}
    </div>

    <div class="watermark">
        CONFIDENTIAL
    </div>
</body>
</html>