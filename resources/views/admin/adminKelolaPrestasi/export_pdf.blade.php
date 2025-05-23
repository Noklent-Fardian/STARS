<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
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

    <div class="document-title">Laporan Data Prestasi</div>

    <table class="data-table">
        <thead>
            <tr>
                <th class="text-center" width="3%">No</th>
                <th class="text-center" width="5%">ID</th>
                <th class="text-center" width="10%">Mahasiswa</th>
                <th class="text-center" width="10%">Lomba</th>
                <th class="text-center" width="7%">Peringkat</th>
                <th class="text-center" width="7%">Tingkatan</th>
                <th class="text-center" width="13%">Judul</th>
                <th class="text-center" width="10%">Tempat</th>
                <th class="text-center" width="8%">Tgl Mulai</th>
                <th class="text-center" width="8%">Tgl Selesai</th>
                <th class="text-center" width="9%">Jumlah Peserta</th>
                <th class="text-center" width="10%">Jumlah Instansi</th>
                <th class="text-center" width="5%">Score</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($prestasi as $item)
                <tr>
                    <td class="text-center">{{ $loop->iteration }}</td>
                    <td class="text-center">{{ $item->id }}</td>
                    <td class="text-center">{{ $item->mahasiswa->mahasiswa_nama ?? '-' }}</td>
                    <td class="text-center">{{ $item->lomba->lomba_nama ?? '-' }}</td>
                    <td class="text-center">{{ $item->peringkat->peringkat_nama ?? '-' }}</td>
                    <td class="text-center">{{ $item->tingkatan->tingkatan_nama ?? '-' }}</td>
                    <td class="text-center">{{ $item->penghargaan_judul }}</td>
                    <td class="text-center">{{ $item->penghargaan_tempat }}</td>
                    <td class="text-center">{{ $item->penghargaan_tanggal_mulai }}</td>
                    <td class="text-center">{{ $item->penghargaan_tanggal_selesai }}</td>
                    <td class="text-center">{{ $item->penghargaan_jumlah_peserta }}</td>
                    <td class="text-center">{{ $item->penghargaan_jumlah_instansi }}</td>
                    <td class="text-center">{{ $item->penghargaan_score }}</td>
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