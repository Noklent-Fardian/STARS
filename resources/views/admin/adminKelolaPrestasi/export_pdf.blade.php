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
            @foreach ($prestasis as $prestasi)
                <tr>
                    <td class="text-center">{{ $loop->iteration }}</td>
                    <td class="text-center">{{ $penghargaan->id }}</td>
                    <td class="text-center">{{ $penghargaan->keahlian->keahlian_nama }}</td>
                    <td class="text-center">{{ $penghargaan->tingkatan->tingkatan_nama }}</td>
                    <td class="text-center">{{ $penghargaan->semester->semester_nama }}</td>
                    <td class="text-center">{{ $penghargaan->penghargaan_nama }}</td>
                    <td class="text-center">{{ $penghargaan->penghargaan_penyelenggara }}</td>
                    <td class="text-center">{{ $penghargaan->penghargaan_kategori }}</td>
                    <td class="text-center">{{ $penghargaan->penghargaan_tanggal_mulai }}</td>
                    <td class="text-center">{{ $penghargaan->penghargaan_tanggal_selesai }}</td>
                    <td>
                        <a href="{{ $penghargaan->penghargaan_link_pendaftaran }}">{{ $penghargaan->penghargaan_link_pendaftaran }}</a>
                    </td>
                    <td>
                        <a href="{{ $penghargaan->penghargaan_link_poster }}">{{ $penghargaan->penghargaan_link_poster }}</a>
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
