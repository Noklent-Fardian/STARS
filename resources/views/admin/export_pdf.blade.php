<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <link rel="stylesheet" href="{{ public_path('css/exportPdf.css') }}">
    <style>
        .statistics-grid {
            display: table;
            width: 100%;
            margin: 20px 0;
        }

        .stat-row {
            display: table-row;
        }

        .stat-cell {
            display: table-cell;
            width: 25%;
            padding: 15px;
            text-align: center;
            border: 1px solid #ddd;
            background-color: #f8f9fc;
        }

        .stat-number {
            font-size: 24pt;
            font-weight: bold;
            color: var(--primary-color);
            margin-bottom: 5px;
        }

        .stat-label {
            font-size: 10pt;
            color: var(--text-color);
            text-transform: uppercase;
        }

        .analysis-section {
            margin: 25px 0;
            padding: 20px;
            border: 1px solid #ddd;
            background-color: #f8f9fc;
        }

        .section-title {
            font-size: 14pt;
            font-weight: bold;
            color: var(--primary-color);
            margin-bottom: 15px;
            border-bottom: 2px solid var(--primary-color);
            padding-bottom: 5px;
        }

        .growth-indicator {
            display: inline-block;
            padding: 3px 8px;
            border-radius: 12px;
            font-size: 9pt;
            font-weight: bold;
        }

        .growth-positive {
            background-color: #d4edda;
            color: #155724;
        }

        .growth-negative {
            background-color: #f8d7da;
            color: #721c24;
        }

        .growth-neutral {
            background-color: #fff3cd;
            color: #856404;
        }

        .metric-bar {
            width: 100%;
            height: 20px;
            background-color: #e9ecef;
            border-radius: 10px;
            overflow: hidden;
            margin: 5px 0;
        }

        .metric-fill {
            height: 100%;
            background: linear-gradient(90deg, var(--primary-color), var(--accent-color));
        }

        .chart-placeholder {
            width: 100%;
            height: 200px;
            border: 2px dashed #ddd;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #666;
            font-style: italic;
            margin: 15px 0;
        }

        .top-performer {
            padding: 8px;
            margin: 5px 0;
            border: 1px solid #ddd;
            border-radius: 5px;
            background-color: white;
        }

        .page-break {
            page-break-before: always;
        }
    </style>
</head>

<body>
    <!-- Header -->
    <table class="letterhead">
        <tr>
            <td width="15%" class="text-center">
                @if (isset($pdfSetting) && $pdfSetting->pdf_logo_kiri)
                    <img src="{{ public_path('storage/' . $pdfSetting->pdf_logo_kiri) }}" alt="Logo Kiri" class="logo">
                @else
                    <img src="{{ public_path('img/poltek100.png') }}" alt="Logo Polinema" class="logo">
                @endif
            </td>
            <td width="70%" class="text-center">
                <div class="ministry">
                    {{ isset($pdfSetting) && $pdfSetting->pdf_instansi1 ? $pdfSetting->pdf_instansi1 : 'STARS - Student Achievement Record System' }}
                </div>
                <div class="institution">
                    {{ isset($pdfSetting) && $pdfSetting->pdf_instansi2 ? $pdfSetting->pdf_instansi2 : 'POLITEKNIK NEGERI MALANG' }}
                </div>
                <div class="address">
                    {{ isset($pdfSetting) && $pdfSetting->pdf_alamat ? $pdfSetting->pdf_alamat : 'Jl. Soekarno-Hatta No. 9 Malang 65141' }}
                </div>
            </td>
            <td width="15%" class="text-center">
                @if (isset($pdfSetting) && $pdfSetting->pdf_logo_kanan)
                    <img src="{{ public_path('storage/' . $pdfSetting->pdf_logo_kanan) }}" alt="Logo Kanan"
                        class="logo">
                @else
                    <img src="{{ public_path('img/logo100.png') }}" alt="Logo Stars" class="logo">
                @endif
            </td>
        </tr>
    </table>

    <div class="document-title">Laporan Statistik & Analisis Sistem STARS</div>

    <div style="text-align: center; margin: 20px 0; font-size: 11pt; color: #666;">
        Periode: {{ date('F Y') }} | Dicetak: {{ now()->format('d F Y H:i') }}
    </div>

    <!-- Executive Summary -->
    <div class="analysis-section">
        <div class="section-title">Ringkasan Eksekutif</div>
        <p style="text-align: justify; line-height: 1.6;">
            Sistem STARS (Student Achievement Record System) saat ini mengelola data dari
            <strong>{{ number_format($stats['total_mahasiswa']) }} mahasiswa</strong> dan
            <strong>{{ number_format($stats['total_dosen']) }} dosen</strong> dengan total
            <strong>{{ number_format($stats['total_prestasi']) }} prestasi</strong> yang tercatat.
            Tingkat verifikasi prestasi mencapai <strong>{{ $systemMetrics['verification_efficiency'] }}%</strong>
            dengan partisipasi aktif mahasiswa sebesar <strong>{{ $systemMetrics['active_participation'] }}%</strong>.
        </p>
    </div>

    <!-- Key Statistics -->
    <div class="statistics-grid">
        <div class="stat-row">
            <div class="stat-cell">
                <div class="stat-number">{{ number_format($stats['total_mahasiswa']) }}</div>
                <div class="stat-label">Total Mahasiswa</div>
            </div>
            <div class="stat-cell">
                <div class="stat-number">{{ number_format($stats['total_dosen']) }}</div>
                <div class="stat-label">Total Dosen</div>
            </div>
            <div class="stat-cell">
                <div class="stat-number">{{ number_format($stats['total_prestasi']) }}</div>
                <div class="stat-label">Total Prestasi</div>
            </div>
            <div class="stat-cell">
                <div class="stat-number">{{ number_format($stats['verified_prestasi']) }}</div>
                <div class="stat-label">Prestasi Terverifikasi</div>
            </div>
        </div>
    </div>

    <!-- System Performance Metrics -->
    <div class="analysis-section">
        <div class="section-title">Metrik Kinerja Sistem</div>

        <div style="margin: 15px 0;">
            <strong>Efisiensi Verifikasi:</strong> {{ $systemMetrics['verification_efficiency'] }}%
            <div class="metric-bar">
                <div class="metric-fill" style="width: {{ $systemMetrics['verification_efficiency'] }}%;"></div>
            </div>
        </div>

        <div style="margin: 15px 0;">
            <strong>Partisipasi Aktif Mahasiswa:</strong> {{ $systemMetrics['active_participation'] }}%
            <div class="metric-bar">
                <div class="metric-fill" style="width: {{ $systemMetrics['active_participation'] }}%;"></div>
            </div>
        </div>

        <div style="margin: 15px 0;">
            <strong>Keterlibatan Dosen:</strong> {{ $systemMetrics['dosen_involvement'] }}%
            <div class="metric-bar">
                <div class="metric-fill" style="width: {{ $systemMetrics['dosen_involvement'] }}%;"></div>
            </div>
        </div>
    </div>

    <!-- Growth Analysis -->
    @php
        $lombaGrowth =
            $growthAnalysis['lomba_growth']['previous'] > 0
                ? (($growthAnalysis['lomba_growth']['current'] - $growthAnalysis['lomba_growth']['previous']) /
                        $growthAnalysis['lomba_growth']['previous']) *
                    100
                : 0;
        $prestasiGrowth =
            $growthAnalysis['prestasi_growth']['previous'] > 0
                ? (($growthAnalysis['prestasi_growth']['current'] - $growthAnalysis['prestasi_growth']['previous']) /
                        $growthAnalysis['prestasi_growth']['previous']) *
                    100
                : 0;
    @endphp

    <div style="margin: 10px 0;">
        <strong>Lomba Terverifikasi:</strong>
        {{ $growthAnalysis['lomba_growth']['current'] }} lomba
        @if ($lombaGrowth > 0)
            <span class="growth-indicator growth-positive">↑ {{ number_format($lombaGrowth, 1) }}%</span>
        @elseif($lombaGrowth < 0)
            <span class="growth-indicator growth-negative">↓ {{ number_format(abs($lombaGrowth), 1) }}%</span>
        @else
            <span class="growth-indicator growth-neutral">→ 0%</span>
        @endif
    </div>

    <div style="margin: 10px 0;">
        <strong>Prestasi Baru:</strong>
        {{ $growthAnalysis['prestasi_growth']['current'] }} prestasi
        @if ($prestasiGrowth > 0)
            <span class="growth-indicator growth-positive">↑ {{ number_format($prestasiGrowth, 1) }}%</span>
        @elseif($prestasiGrowth < 0)
            <span class="growth-indicator growth-negative">↓ {{ number_format(abs($prestasiGrowth), 1) }}%</span>
        @else
            <span class="growth-indicator growth-neutral">→ 0%</span>
        @endif
    </div>
    </div>

    <!-- Page Break -->
    <div class="page-break"></div>

    <!-- Prestasi by Tingkatan -->
    <div class="analysis-section">
        <div class="section-title">Distribusi Prestasi Berdasarkan Tingkatan</div>
        <table class="data-table">
            <thead>
                <tr>
                    <th width="60%">Tingkatan</th>
                    <th width="20%">Jumlah</th>
                    <th width="20%">Persentase</th>
                </tr>
            </thead>
            <tbody>
                @php $totalPrestasi = $prestasiByTingkatan->sum('total'); @endphp
                @foreach ($prestasiByTingkatan as $item)
                    <tr>
                        <td>{{ $item->tingkatan_nama }}</td>
                        <td class="text-center">{{ $item->total }}</td>
                        <td class="text-center">
                            {{ $totalPrestasi > 0 ? number_format(($item->total / $totalPrestasi) * 100, 1) : 0 }}%
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Prestasi by Prodi -->
    @if ($prestasiByProdi->count() > 0)
        <div class="analysis-section">
            <div class="section-title">Top 10 Program Studi Berdasarkan Prestasi</div>
            <table class="data-table">
                <thead>
                    <tr>
                        <th width="10%">Rank</th>
                        <th width="60%">Program Studi</th>
                        <th width="30%">Jumlah Prestasi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($prestasiByProdi->take(10) as $index => $item)
                        <tr>
                            <td class="text-center">{{ $index + 1 }}</td>
                            <td>{{ $item->prodi_nama }}</td>
                            <td class="text-center">{{ $item->total }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif

    <!-- Top Performers -->
    <div class="analysis-section">
        <div class="section-title">Top 10 Mahasiswa Berprestasi</div>
        @if ($topMahasiswa->count() > 0)
            <table class="data-table">
                <thead>
                    <tr>
                        <th width="10%">Rank</th>
                        <th width="25%">NIM</th>
                        <th width="45%">Nama</th>
                        <th width="20%">Total Score</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($topMahasiswa as $index => $mahasiswa)
                        <tr>
                            <td class="text-center">{{ $index + 1 }}</td>
                            <td>{{ $mahasiswa->mahasiswa_nim }}</td>
                            <td>{{ $mahasiswa->mahasiswa_nama }}</td>
                            <td class="text-center">{{ number_format($mahasiswa->mahasiswa_score, 2) }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <p style="text-align: center; color: #666; font-style: italic;">Belum ada data mahasiswa berprestasi</p>
        @endif
    </div>

    <div class="analysis-section">
        <div class="section-title">Top 10 Dosen Pembimbing</div>
        @if ($topDosen->count() > 0)
            <table class="data-table">
                <thead>
                    <tr>
                        <th width="10%">Rank</th>
                        <th width="25%">NIP</th>
                        <th width="45%">Nama</th>
                        <th width="20%">Total Score</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($topDosen as $index => $dosen)
                        <tr>
                            <td class="text-center">{{ $index + 1 }}</td>
                            <td>{{ $dosen->dosen_nip }}</td>
                            <td>{{ $dosen->dosen_nama }}</td>
                            <td class="text-center">{{ number_format($dosen->dosen_score, 2) }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <p style="text-align: center; color: #666; font-style: italic;">Belum ada data dosen pembimbing</p>
        @endif
    </div>

    <!-- Page Break -->
    <div class="page-break"></div>

    <!-- Recommendations -->
    <div class="analysis-section">
        <div class="section-title">Rekomendasi & Insight</div>
        <div style="line-height: 1.6;">
            <p><strong>1. Efisiensi Verifikasi:</strong></p>
            <ul style="margin-left: 20px;">
                @if ($systemMetrics['verification_efficiency'] >= 80)
                    <li>Tingkat verifikasi sangat baik ({{ $systemMetrics['verification_efficiency'] }}%). Pertahankan
                        proses yang efisien.</li>
                @elseif($systemMetrics['verification_efficiency'] >= 60)
                    <li>Tingkat verifikasi cukup baik ({{ $systemMetrics['verification_efficiency'] }}%). Diperlukan
                        sedikit peningkatan proses.</li>
                @else
                    <li>Tingkat verifikasi perlu ditingkatkan ({{ $systemMetrics['verification_efficiency'] }}%).
                        Evaluasi bottleneck dalam proses verifikasi.</li>
                @endif
            </ul>

            <p><strong>2. Partisipasi Mahasiswa:</strong></p>
            <ul style="margin-left: 20px;">
                @if ($systemMetrics['active_participation'] >= 50)
                    <li>Partisipasi mahasiswa aktif ({{ $systemMetrics['active_participation'] }}%). Lanjutkan program
                        motivasi.</li>
                @elseif($systemMetrics['active_participation'] >= 30)
                    <li>Partisipasi mahasiswa cukup ({{ $systemMetrics['active_participation'] }}%). Perluas
                        sosialisasi program prestasi.</li>
                @else
                    <li>Partisipasi mahasiswa rendah ({{ $systemMetrics['active_participation'] }}%). Diperlukan
                        strategi baru untuk meningkatkan engagement.</li>
                @endif
            </ul>

            <p><strong>3. Keterlibatan Dosen:</strong></p>
            <ul style="margin-left: 20px;">
                @if ($systemMetrics['dosen_involvement'] >= 70)
                    <li>Keterlibatan dosen sangat baik ({{ $systemMetrics['dosen_involvement'] }}%).</li>
                @elseif($systemMetrics['dosen_involvement'] >= 50)
                    <li>Keterlibatan dosen cukup baik ({{ $systemMetrics['dosen_involvement'] }}%). Tingkatkan
                        pelatihan dosen pembimbing.</li>
                @else
                    <li>Keterlibatan dosen perlu ditingkatkan ({{ $systemMetrics['dosen_involvement'] }}%). Berikan
                        insentif untuk dosen pembimbing.</li>
                @endif
            </ul>
        </div>
    </div>

    <!-- Footer -->
    <div class="footer">
        <div style="text-align: center;">
            <strong>STARS - Student Achievement Record System</strong><br>
            Laporan digenerate secara otomatis pada {{ now()->format('d F Y H:i:s') }}<br>
            Data yang ditampilkan adalah real-time sesuai kondisi sistem saat ini
        </div>
    </div>

    <div class="page-number">
        Halaman <span class="pageNumber"></span>
    </div>

    <div class="watermark">
        CONFIDENTIAL - STAR SYSTEM
    </div>
</body>

</html>
