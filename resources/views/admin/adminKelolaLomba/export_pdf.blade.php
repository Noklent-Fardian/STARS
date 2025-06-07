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
                <div class="ministry">
                    {{ isset($pdfSetting) && $pdfSetting->pdf_instansi1 ? $pdfSetting->pdf_instansi1 : 'STARS - Student Achievement Record System' }}
                </div>
                <div class="institution">
                    {{ isset($pdfSetting) && $pdfSetting->pdf_instansi2 ? $pdfSetting->pdf_instansi2 : 'POLITEKNIK NEGERI MALANG' }}
                </div>
                <div class="address">
                    {{ isset($pdfSetting) && $pdfSetting->pdf_alamat ? $pdfSetting->pdf_alamat : 'Jl. Soekarno-Hatta No. 9 Malang 65141' }}
                </div>
                <div class="address">
                    Telepon
                    {{ isset($pdfSetting) && $pdfSetting->pdf_telepon ? $pdfSetting->pdf_telepon : '(0341) 404424' }}
                    {{ isset($pdfSetting) && $pdfSetting->pdf_pes ? ' Pes. ' . $pdfSetting->pdf_pes : ' Pes. 101-105, 0341-404420' }}
                    {{ isset($pdfSetting) && $pdfSetting->pdf_fax ? ', Fax. ' . $pdfSetting->pdf_fax : ', Fax. (0341) 404420' }}
                </div>
                <div class="address">Laman:
                    {{ isset($pdfSetting) && $pdfSetting->pdf_website ? $pdfSetting->pdf_website : 'www.polinema.ac.id' }}
                </div>
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

    <div class="document-title">Laporan Data Lomba</div>

    <table class="data-table">
        <thead>
            <tr>
                <th class="text-center" width="3%">No</th>
                <th class="text-center" width="5%">ID</th>
                <th class="text-center" width="5%">Keahlian</th>
                <th class="text-center" width="5%">Tingkatan</th>
                <th class="text-center" width="5%">Semester</th>
                <th class="text-center" width="12%">Nama Lomba</th>
                <th class="text-center" width="10%">Penyelenggara</th>
                <th class="text-center" width="8%">Kategori</th>
                <th class="text-center" width="8%">Tanggal Mulai</th>
                <th class="text-center" width="8%">Tanggal Selesai</th>
                <th class="text-center" width="15%">Link Pendaftaran</th>
                <th class="text-center" width="16%">Link Poster</th>>
            </tr>
        </thead>
        <tbody>
            @foreach ($lombas as $lomba)
                <tr>
                    <td class="text-center">{{ $loop->iteration }}</td>
                    <td class="text-center">{{ $lomba->id }}</td>
                    <td>
                        @if($lomba->keahlians->count())
                            {{ $lomba->keahlians->pluck('keahlian_nama')->implode(', ') }}
                        @else
                            -
                        @endif
                    </td>
                    <td class="text-center">{{ $lomba->tingkatan->tingkatan_nama }}</td>
                    <td class="text-center">{{ $lomba->semester->semester_nama }}</td>
                    <td class="text-center">{{ $lomba->lomba_nama }}</td>
                    <td class="text-center">{{ $lomba->lomba_penyelenggara }}</td>
                    <td class="text-center">{{ $lomba->lomba_kategori }}</td>
                    <td class="text-center">{{ $lomba->lomba_tanggal_mulai }}</td>
                    <td class="text-center">{{ $lomba->lomba_tanggal_selesai }}</td>
                    <td>
                        <a href="{{ $lomba->lomba_link_pendaftaran }}">{{ $lomba->lomba_link_pendaftaran }}</a>
                    </td>
                    <td>
                        <a href="{{ $lomba->lomba_link_poster }}">{{ $lomba->lomba_link_poster }}</a>
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