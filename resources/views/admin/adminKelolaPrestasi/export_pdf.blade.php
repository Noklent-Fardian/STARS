<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <style>
        body {
            font-family: Arial, Helvetica, sans-serif;
            font-size: 11px;
            margin: 30px 20px 40px 20px;
        }
        .letterhead {
            width: 100%;
            margin-bottom: 10px;
        }
        .ministry {
            font-size: 14px;
            font-weight: bold;
            letter-spacing: 1px;
        }
        .institution {
            font-size: 16px;
            font-weight: bold;
            margin-top: 2px;
        }
        .address {
            font-size: 10px;
        }
        .document-title {
            text-align: center;
            font-size: 15px;
            font-weight: bold;
            margin: 18px 0 12px 0;
            text-transform: uppercase;
        }
        .data-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 18px;
        }
        .data-table th, .data-table td {
            border: 1px solid #333;
            padding: 5px 4px;
            font-size: 10px;
        }
        .data-table th {
            background: #f2a93b;
            color: #fff;
            font-weight: bold;
            text-align: center;
        }
        .data-table td {
            text-align: center;
        }
        .footer {
            font-size: 9px;
            color: #888;
            text-align: right;
            margin-top: 10px;
        }
        .page-number {
            position: fixed;
            bottom: 10px;
            right: 20px;
            font-size: 9px;
            color: #bbb;
        }
        .watermark {
            position: fixed;
            bottom: 40%;
            left: 0;
            width: 100%;
            text-align: center;
            font-size: 40px;
            color: #f2a93b22;
            font-weight: bold;
            z-index: 0;
            transform: rotate(-20deg);
            pointer-events: none;
        }
    </style>
</head>
<body>
    <table class="letterhead">
        <div style="text-align:center; margin-bottom: 10px;">
            <div class="ministry">STARS - Student Achievement Record System</div>
            <div class="institution">POLITEKNIK NEGERI MALANG</div>
            <div class="address">Jl. Soekarno-Hatta No. 9 Malang 65141</div>
            <div class="address">Telepon (0341) 404424 Pes. 101-105, 0341-404420, Fax. (0341) 404420</div>
            <div class="address">Laman: www.polinema.ac.id</div>
        </div>
    </table>

    <div class="document-title">Laporan Data Prestasi</div>

    <table class="data-table">
        <thead>
            <tr>
                <th width="3%">No</th>
                <th width="5%">ID</th>
                <th width="10%">Mahasiswa</th>
                <th width="10%">Lomba</th>
                <th width="7%">Peringkat</th>
                <th width="7%">Tingkatan</th>
                <th width="13%">Judul</th>
                <th width="10%">Tempat</th>
                <th width="8%">Tgl Mulai</th>
                <th width="8%">Tgl Selesai</th>
                <th width="9%">Jumlah Peserta</th>
                <th width="10%">Jumlah Instansi</th>
                <th width="5%">Score</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($prestasi as $item)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $item->id }}</td>
                    <td>{{ $item->mahasiswa->mahasiswa_nama ?? '-' }}</td>
                    <td>{{ $item->lomba->lomba_nama ?? '-' }}</td>
                    <td>{{ $item->peringkat->peringkat_nama ?? '-' }}</td>
                    <td>{{ $item->tingkatan->tingkatan_nama ?? '-' }}</td>
                    <td>{{ $item->penghargaan_judul }}</td>
                    <td>{{ $item->penghargaan_tempat }}</td>
                    <td>{{ $item->penghargaan_tanggal_mulai }}</td>
                    <td>{{ $item->penghargaan_tanggal_selesai }}</td>
                    <td>{{ $item->penghargaan_jumlah_peserta }}</td>
                    <td>{{ $item->penghargaan_jumlah_instansi }}</td>
                    <td>{{ $item->penghargaan_score }}</td>
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