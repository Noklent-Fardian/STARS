<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <link rel="stylesheet" href="{{ public_path('css/exportPdf.css') }}">
</head>

<body>
    <table class="letterhead">
        <tr>
            <td width="15%" class="text-center">
                @if(isset($pdfSetting) && $pdfSetting->pdf_logo_kiri)
                    <img src="{{ public_path('storage/' . $pdfSetting->pdf_logo_kiri) }}" alt="Logo Kiri" class="logo"
                        style="width: auto; height: 70px;">
                @else
                    <img src="{{ public_path('img/poltek100.png') }}" alt="Logo Polinema" class="logo"
                        style="width: auto; height: 70px;">
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
                    <img src="{{ public_path('storage/' . $pdfSetting->pdf_logo_kanan) }}" alt="Logo Kanan" class="logo"
                        style="width: auto; height: 70px;">
                @else
                    <img src="{{ public_path('img/logo100.png') }}" alt="Logo Stars" class="logo"
                        style="width: auto; height: 70px;">
                @endif
            </td>
        </tr>
    </table>

    <div class="document-title">Laporan Data Semester</div>

    <table class="data-table">
        <thead>
            <tr>
                <th class="text-center" width="5%">No</th>
                <th class="text-center" width="25%">Nama Semester</th>
                <th class="text-center" width="15%">Tahun</th>
                <th class="text-center" width="15%">Jenis</th>
                <th class="text-center" width="15%">Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($semesters as $semester)
                <tr>
                    <td class="text-center">{{ $loop->iteration }}</td>
                    <td>{{ $semester->semester_nama }}</td>
                    <td class="text-center">{{ $semester->semester_tahun }}</td>
                    <td class="text-center">{{ $semester->semester_jenis }}</td>
                    <td class="text-center">
                        @if ($semester->semester_aktif)
                            <span class="badge badge-success">Aktif</span>
                        @else
                            <span class="badge badge-secondary">Non-Aktif</span>
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer">
        Dokumen ini dicetak pada {{ now()->format('d F Y H:i') }}
    </div>

    <div class="page-number">
        Halaman 1
    </div>

    <div class="watermark">
        STAR SYSTEM
    </div>
</body>

</html>
