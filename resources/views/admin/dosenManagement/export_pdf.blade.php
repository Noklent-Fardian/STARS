<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <link rel="stylesheet" href="{{ public_path('css/exportPdf.css') }}">
</head>

<body>
    <table class="letterhead">
        <tr>
            <td width="100%" class="text-center">
                <div class="ministry">STARS-Student Achievement Record System</div>
                <div class="institution">POLITEKNIK NEGERI MALANG</div>
                <div class="address">Jl. Soekarno-Hatta No. 9 Malang 65141</div>
                <div class="address">Telepon (0341) 404424 Pes. 101-105, 0341-404420, Fax. (0341) 404420</div>
                <div class="address">Laman: www.polinema.ac.id</div>
            </td>
        </tr>
    </table>

    <div class="document-title">Laporan Data Dosen</div>

    <table class="data-table">
        <thead>
            <tr>
                <th class="text-center" width="5%">No</th>
                <th class="text-center" width="15%">NIDN/NIP</th>
                <th class="text-center" width="30%">Nama Dosen</th>
                <th class="text-center" width="20%">Program Studi</th>
                <th class="text-center" width="15%">Status</th>
                <th class="text-center" width="15%">Telepon</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($dosens as $dosen)
                <tr>
                    <td class="text-center">{{ $loop->iteration }}</td>
                    <td>{{ $dosen->dosen_nip }}</td>
                    <td>{{ $dosen->dosen_nama }}</td>
                    <td>{{ $dosen->prodi->prodi_nama ?? '-' }}</td>
                    <td class="text-center">{{ $dosen->dosen_visible ? 'Aktif' : 'Non-Aktif' }}</td>
                    <td>{{ $dosen->dosen_nomor_telepon ?? '-' }}</td>
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
