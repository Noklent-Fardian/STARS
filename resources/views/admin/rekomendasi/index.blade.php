@extends('layouts.template')

@section('title', 'Data Bobot | STARS')

@section('page-title', 'Data Bobot')

@section('breadcrumb')
@endsection

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Kelola Bobot Kriteria</h3>
    </div>
    <div class="card-body">
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <form id="formBobot" action="{{ route('admin.rekomendasi.update') }}" method="POST">
            @csrf
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Kriteria</th>
                        <th>Bobot</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($bobots as $bobot)
                        <tr>
                            <td>{{ $bobot->kriteria }}</td>
                            <td>
                                <input type="number" step="0.01" min="0" max="1"
                                    name="bobot[{{ $bobot->id }}]" value="{{ $bobot->bobot }}" class="form-control">
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <button class="btn btn-primary mt-3">Simpan Perubahan</button>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
    $(document).ready(function () {
        $('#formBobot').submit(function (e) {
            e.preventDefault();
            let form = $(this);
            let url = form.attr('action');
            let data = form.serialize();

            $.ajax({
                type: "POST",
                url: url,
                data: data,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function (response) {
                    $('#notifArea').html(`
                        <div class="alert alert-success">
                            ${response.message ?? 'Bobot berhasil diperbarui.'}
                        </div>
                    `);
                },
                error: function (xhr) {
                    let response = xhr.responseJSON;
                    let message = 'Terjadi kesalahan saat menyimpan.';
                    if (response?.errors) {
                        let errors = Object.values(response.errors).flat().join('<br>');
                        message = errors;
                    }
                    $('#notifArea').html(`
                        <div class="alert alert-danger">
                            ${message}
                        </div>
                    `);
                }
            });
        });
    });
</script>
@endpush