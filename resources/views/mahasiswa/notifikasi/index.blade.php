@extends('layouts.template')

@section('title', 'Rekomendasi Topsis | STARS')

@section('page-title', 'Rekomendasi TOPSIS')

@section('breadcrumb')
@endsection

@section('content')
<div class="container mt-4">
    <h4 class="mb-3">Notifikasi Rekomendasi Lomba</h4>

    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    @if(count($notifikasi) > 0)
        @foreach($notifikasi as $notif)
            <div class="card mb-3 {{ !$notif['is_read'] ? 'border-primary' : '' }}">
                <div class="card-body">
                    <h5 class="card-title">{{ $notif['judul'] ?? 'Notifikasi' }}</h5>
                    @if(!empty($notif['lomba_nama']))
                        <p class="mb-1"><strong>Lomba:</strong> {{ $notif['lomba_nama'] }}</p>
                    @endif
                    <p class="card-text">
                        {{ $notif['pesan'] ?? '' }}<br>
                        <strong>Nama:</strong> {{ $notif['mahasiswa']['mahasiswa_nama'] ?? '-' }}<br>
                        <strong>Telepon:</strong> {{ $notif['mahasiswa']['mahasiswa_telepon'] ?? '-' }}
                    </p>
                    @if(!empty($notif['data_ranking']))
                        <hr>
                        <strong>Mahasiswa Lain yang Direkomendasikan:</strong>
                        <div class="table-responsive">
                            <table class="table table-bordered table-sm mb-0">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama</th>
                                        <th>NIM</th>
                                        <th>Nomor Telepon</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach(json_decode($notif['data_ranking']) as $mhs)
                                        <tr>
                                            <td>#{{ $mhs->ranking }}</td>
                                            <td>{{ $mhs->nama }}</td>
                                            <td>{{ $mhs->nim }}</td>
                                            <td>{{ $mhs->telepon }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                    <small class="text-muted">{{ \Carbon\Carbon::parse($notif['created_at'])->diffForHumans() }}</small>
                </div>
            </div>
        @endforeach
    @else
        <p>Tidak ada notifikasi saat ini.</p>
    @endif
</div>
@endsection