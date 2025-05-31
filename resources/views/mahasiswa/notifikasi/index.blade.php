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
                    <p class="card-text">
                        {{ $notif['pesan'] ?? '' }}<br>
                        <strong>Nama Anda:</strong> {{ $notif['mahasiswa']['mahasiswa_nama'] ?? '-' }}<br>
                        <strong>Telepon:</strong> {{ $notif['mahasiswa']['mahasiswa_telepon'] ?? '-' }}
                    </p>
                    @if(!empty($notif['data_ranking']))
                        <hr>
                        <strong>Mahasiswa Lain yang Direkomendasikan:</strong>
                        <ul>
                            @foreach(json_decode($notif['data_ranking']) as $mhs)
                                <li>#{{ $mhs->ranking }} - {{ $mhs->nama }} ({{ $mhs->nim }}) - {{ $mhs->telepon }}</li>
                            @endforeach
                        </ul>
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