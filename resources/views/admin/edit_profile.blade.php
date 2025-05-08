@extends('layouts.template')

@section('title', 'Edit Admin Profile | STARS')

@section('page-title', 'Edit Profil Admin')

@section('breadcrumb')
<li class="breadcrumb-item"><a href="{{ route('admin.profile') }}">Profil</a></li>
<li class="breadcrumb-item active">Edit</li>
@endsection

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-6">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Edit Profil Admin</h6>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.updateProfile') }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="form-group">
                        <label>Nama</label>
                        <input type="text" name="admin_name" class="form-control" value="{{ $admin->admin_name }}" required>
                    </div>

                    <div class="form-group">
                        <label>Nomor Telepon</label>
                        <input type="text" name="admin_nomor_telepon" class="form-control" value="{{ $admin->admin_nomor_telepon }}">
                    </div>

                    <div class="form-group">
                        <label>Gender</label>
                        <select name="admin_gender" class="form-control">
                            <option value="Laki-laki" {{ $admin->admin_gender == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                            <option value="Perempuan" {{ $admin->admin_gender == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                        </select>
                    </div>

                    <div class="d-flex justify-content-between">
                        <a href="{{ route('admin.profile') }}" class="btn btn-secondary">Batal</a>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
