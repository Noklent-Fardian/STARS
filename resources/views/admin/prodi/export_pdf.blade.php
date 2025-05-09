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

    <div class="document-title">Laporan Data Program Studi</div>

    <table class="data-table">
        <thead>
            <tr>
                <th class="text-center" width="5%" style="text-align: center;">No</th>
                                <th class="text-center" width="35%" style="text-align: center;">Kode Prodi</th>

                <th class="text-center" width="60%" style="text-align: center;">Nama Program Studi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($prodis as $prodi)
                <tr>
                    <td class="text-center">{{ $loop->iteration }}</td>
                    <td class="text-center">{{ $prodi->prodi_kode }}</td>
                    <td>{{ $prodi->prodi_nama }}</td>
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
