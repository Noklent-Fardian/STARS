<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <link rel="stylesheet" href="{{ public_path('css/exportPdf.css') }}">
</head>

<body>
    <table class="letterhead">
        <tr>
            <td width="70%" class="text-center">
                <div class="ministry">STARS-Student Achievement Record System</div>
                <div class="institution">POLITEKNIK NEGERI MALANG</div>
                <div class="address">Jl. Soekarno-Hatta No. 9 Malang 65141</div>
                <div class="address">Telepon (0341) 404424 Pes. 101-105, 0341-404420, Fax. (0341) 404420</div>
                <div class="address">Laman: www.polinema.ac.id</div>
            </td>
        </tr>
    </table>

    <div class="document-title">Laporan Data Peringkat Lomba</div>

    <table class="data-table">
        <thead>
            <tr>
                <th class="text-center" width="5%" style="text-align: center;">No</th>
                <th class="text-center" width="50%" style="text-align: center;">Nama Peringkat</th>
                <th class="text-center" width="45%" style="text-align: center;">Bobot</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($peringkats as $peringkat)
                <tr>
                    <td class="text-center">{{ $loop->iteration }}</td>
                    <td>{{ $peringkat->peringkat_nama }}</td>
                    <td class="text-center">{{ $peringkat->peringkat_bobot }}</td>
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