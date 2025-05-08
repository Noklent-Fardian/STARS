@extends('layouts.template')

@section('title', 'Admin Profile | STARS')

@section('page-title', 'Profil Admin')

@section('breadcrumb')
<li class="breadcrumb-item active">Profil</li>
@endsection

@section('content')
@section('content')
@if (session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
@endif
<div class="row justify-content-center">
    <!-- Profile Card -->
    <div class="col-lg-6">
        <div class="card shadow mb-4 position-relative">
            <div class="card-header py-3 d-flex justify-content-between align-items-center">
                <h6 class="m-0 font-weight-bold text-primary">Profil Admin</h6>
                <a href="{{ route('admin.editProfile') }}" class="btn btn-sm btn-primary" title="Edit Profil">
                    <i class="fas fa-edit"></i>
                </a>
            </div>
            <div class="card-body text-center">
                <img src="{{ asset('img/admin_default.png') }}" alt="Foto Admin" class="img-fluid rounded-circle mb-3" width="150">
                <h4>{{ $admin->admin_name }}</h4>
                <p class="text-muted">{{ $admin->admin_gender }}</p>
                <p><strong>Nomor Telepon:</strong> {{ $admin->admin_nomor_telepon ?? '-' }}</p>
                <p><strong>Username:</strong> {{ $admin->user->username }}</p>
            </div>
        </div>
    </div>
</div>
@endsection

@push('css')
<style>
    .card-body img {
        object-fit: cover;
    }
</style>
@endpush
