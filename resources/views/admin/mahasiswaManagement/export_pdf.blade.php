<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <link rel="stylesheet" href="{{ public_path('css/exportPdf.css') }}">
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 10pt;
        }
        .letterhead {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        .ministry {
            font-size: 14pt;
            font-weight: bold;
            margin-bottom: 5px;
        }
        .institution {
            font-size: 12pt;
            font-weight: bold;
            margin-bottom: 5px;
        }
        .address {
            font-size: 10pt;
            margin-bottom: 2px;
        }
        .document-title {
            font-size: 14pt;
            font-weight: bold;
            text-align: center;
            margin: 15px 0;
            text-decoration: underline;
        }
        .data-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        .data-table th, .data-table td {
            border: 1px solid #000;
            padding: 5px;
        }
        .data-table th {
            background-color: #f2f2f2;
            font-weight: bold;
            text-align: center;
        }
        .text-center {
            text-align: center;
        }
        .footer {
            font-size: 9pt;
            text-align: right;
            margin-top: 10px;
        }
        .page-number {
            position: absolute;
            bottom: 20px;
            right: 20px;
            font-size: 9pt;
        }
        .watermark {
            position: fixed;
            opacity: 0.1;
            font-size: 80pt;
            width: 100%;
            text-align: center;
            z-index: -1;
            transform: rotate(-45deg);
            top: 40%;
            left: 0;
        }
    </style>
</head>
<body>
    <table class="letterhead">
        <tr>
            <td width="15%" class="text-center">
                @if (isset($pdfSetting) && $pdfSetting->pdf_logo_kiri)
                    <img src="{{ public_path('storage/' . $pdfSetting->pdf_logo_kiri) }}" alt="Logo Kiri" class="logo" style="width: auto; height: 70px;">
                @else
                    <img src="{{ public_path('img/poltek100.png') }}" alt="Logo Polinema" class="logo" style="width: auto; height: 70px;">
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
                @if (isset($pdfSetting) && $pdfSetting->pdf_logo_kanan)
                    <img src="{{ public_path('storage/' . $pdfSetting->pdf_logo_kanan) }}" alt="Logo Kanan" class="logo" style="width: auto; height: 70px;">
                @else
                    <img src="{{ public_path('img/logo100.png') }}" alt="Logo Stars" class="logo" style="width: auto; height: 70px;">
                @endif
            </td>
        </tr>
    </table>

    <div class="document-title">Laporan Data Mahasiswa</div>

    <table class="data-table">
        <thead>
            <tr>
                <th class="text-center" width="5%">No</th>
                <th class="text-center" width="15%">NIM</th>
                <th class="text-center" width="25%">Nama Mahasiswa</th>
                <th class="text-center" width="10%">Username</th>
                <th class="text-center" width="10%">Jenis Kelamin</th>
                <th class="text-center" width="10%">Angkatan</th>
                <th class="text-center" width="10%">Status</th>
                <th class="text-center" width="15%">Program Studi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($mahasiswas as $mahasiswa)
                <tr>
                    <td class="text-center">{{ $loop->iteration }}</td>
                    <td>{{ $mahasiswa->mahasiswa_nim }}</td>
                    <td>{{ $mahasiswa->mahasiswa_nama }}</td>
                    <td>{{ $mahasiswa->user->username }}</td>
                    <td class="text-center">{{ $mahasiswa->mahasiswa_gender }}</td>
                    <td class="text-center">{{ $mahasiswa->mahasiswa_angkatan }}</td>
                    <td class="text-center">{{ $mahasiswa->mahasiswa_status }}</td>
                    <td>{{ $mahasiswa->prodi ? $mahasiswa->prodi->prodi_nama : '-' }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer">
        Dokumen ini dicetak pada {{ now()->format('d F Y H:i') }}
    </div>

    <div class="page-number">
        Halaman <span class="page-number"></span>
    </div>

    <div class="watermark">
        STAR SYSTEM
    </div>
</body>
</html>