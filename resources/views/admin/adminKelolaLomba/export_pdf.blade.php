<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <link rel="stylesheet" href="{{ public_path('css/exportPdf.css') }}">
</head>

<body>
    <table class="letterhead">
        <tr>
            <td width="70%" class="text-center">
                <div class="ministry">STARS - Student Achievement Record System</div>
                <div class="institution">POLITEKNIK NEGERI MALANG</div>
                <div class="address">Jl. Soekarno-Hatta No. 9 Malang 65141</div>
                <div class="address">Telepon (0341) 404424 Pes. 101-105, 0341-404420, Fax. (0341) 404420</div>
                <div class="address">Laman: www.polinema.ac.id</div>
            </td>
        </tr>
    </table>

    <div class="document-title">Laporan Data Lomba</div>

    <table class="data-table">
        <thead>
            <tr>
                <th class="text-center" width="3%">No</th>
                <th class="text-center" width="6%">ID</th>
                <th class="text-center" width="6%">Keahlian</th>
                <th class="text-center" width="6%">Tingkatan</th>
                <th class="text-center" width="6%">Semester</th>
                <th class="text-center" width="15%">Nama Lomba</th>
                <th class="text-center" width="10%">Penyelenggara</th>
                <th class="text-center" width="8%">Kategori</th>
                <th class="text-center" width="10%">Tanggal Mulai</th>
                <th class="text-center" width="10%">Tanggal Selesai</th>
                <th class="text-center" width="15%">Link Pendaftaran</th>
                <th class="text-center" width="15%">Link Poster</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($lombas as $lomba)
                <tr>
                    <td class="text-center">{{ $loop->iteration }}</td>
                    <td class="text-center">{{ $lomba->id }}</td>
                    <td class="text-center">{{ $lomba->keahlian->keahlian_nama }}</td>
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