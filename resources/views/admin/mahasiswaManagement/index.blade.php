@extends('layouts.template')

@section('title', 'Data Mahasiswa | STARS')

@section('page-title', 'Data Mahasiswa')

@section('breadcrumb')
@endsection

@section('content')
    <div class="card shadow-sm rounded-lg overflow-hidden">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-white">Daftar Mahasiswa</h6>
        </div>
        <div class="card-body">
            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif
            @if (session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{ session('error') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif

            <div class="row mb-3">
                <div class="mb-3 d-flex justify-content-between align-items-center flex-wrap">
                    <div class="btn-group-responsive">
                        <button onclick="modalAction('{{ route('admin.mahasiswaManagement.createAjax') }}')"
                            class="btn btn-primary mb-2 mb-sm-0 mr-2">
                            <i class="fas fa-plus-circle mr-1"></i> Tambah Mahasiswa
                        </button>
                        <a href="{{ route('admin.mahasiswaManagement.exportExcel') }}"
                            class="btn btn-success mb-2 mb-sm-0 mr-2">
                            <i class="fas fa-file-excel mr-1"></i> Export Excel
                        </a>
                        <a href="{{ route('admin.mahasiswaManagement.exportPDF') }}" class="btn btn-warning mb-2 mb-sm-0 mr-2">
                            <i class="fas fa-file-pdf mr-1"></i> Export PDF
                        </a>
                        <button onclick="modalAction('{{ route('admin.mahasiswaManagement.importForm') }}')"
                            class="btn btn-info mb-2 mb-sm-0">
                            <i class="fas fa-file-import mr-1"></i> Import Excel
                        </button>
                    </div>
                </div>
                <div class="ml-auto">
                    <div class="form-group has-search mb-0 ml-auto" style="max-width: 300px;">
                        <span class="fa fa-search form-control-feedback"></span>
                        <input type="text" class="form-control" id="searchBox" placeholder="Cari mahasiswa...">
                    </div>
                </div>
            </div>

            <div class="table-responsive">
                <table class="table table-hover table-striped" id="table_mahasiswa">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nama Mahasiswa</th>
                            <th>NIM</th>
                            <th>Status</th>
                            <th>Program Studi</th>
                            <th>Angkatan</th>
                            <th class="text-center text-nowrap">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- DataTables akan mengisi ini -->
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div id="myModal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true"></div>
@endsection

@push('css')
    <style>
        .has-search .form-control {
            padding-left: 2.375rem;
            border-radius: 20px;
        }

        .has-search .form-control-feedback {
            position: absolute;
            z-index: 2;
            display: block;
            width: 2.375rem;
            height: 2.375rem;
            line-height: 2.375rem;
            text-align: center;
            pointer-events: none;
            color: var(--light-text);
        }

        #table_mahasiswa tbody tr {
            transition: all 0.2s ease;
        }

        #table_mahasiswa tbody tr:hover {
            background-color: rgba(var(--primary-color-rgb), 0.05);
        }

        .card-header {
            background: linear-gradient(-45deg, #102044, #1a2a4d, #293c5d, #1a2a4d);
            background-size: 400% 400%;
            height: 70px;
            overflow: hidden;
            display: flex;
            align-items: center;
            position: relative;
        }

        @media (max-width: 576px) {
            .container-fluid {
                padding: 0 10px;
            }

            .card {
                margin-bottom: 10px;
            }
        }

        /* Enhanced Search Box Styling */
        .has-search .form-control {
            padding-left: 2.8rem;
            border-radius: 50px;
            transition: all 0.3s ease;
            border: 1px solid rgba(0, 0, 0, 0.1);
            background-color: rgba(255, 255, 255, 0.9);
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.05);
        }

        .has-search .form-control:focus {
            border-color: var(--accent-color);
            box-shadow: 0 0 0 0.2rem rgba(250, 157, 28, 0.25);
            background-color: #fff;
        }

        .has-search .form-control-feedback {
            position: absolute;
            z-index: 2;
            display: block;
            width: 2.8rem;
            height: 2.8rem;
            line-height: 2.8rem;
            text-align: center;
            pointer-events: none;
            color: var(--light-text);
            transition: color 0.3s ease;
        }

        .has-search .form-control:focus+.form-control-feedback {
            color: var(--accent-color);
        }

        .has-search {
            position: relative;
            max-width: 300px;
            margin-left: auto;
        }
    </style>
@endpush

@push('js')
    <script>
        function modalAction(url = '') {
            $('#myModal').load(url, function() {
                $('#myModal').modal('show');
            });
        }

        var dataMahasiswa;
        $(document).ready(function() {
            dataMahasiswa = $('#table_mahasiswa').DataTable({
                serverSide: true,
                processing: true,
                ajax: {
                    url: "{{ route('admin.mahasiswaManagement.list') }}",
                    dataType: "json",
                    type: "GET"
                },
                columns: [{
                        data: "id",
                        className: "text-center",
                        width: "5%"
                    },
                    {
                        data: "mahasiswa_nama",
                        width: "20%"
                    },
                    {
                        data: "mahasiswa_nim",
                        width: "15%"
                    },
                    {
                        data: "mahasiswa_status",
                        width: "15%"
                    },
                    {
                        data: "prodi_nama",
                        width: "20%"
                    },
                    {
                        data: "mahasiswa_angkatan",
                        className: "text-center",
                        width: "10%"
                    },
                    {
                        data: "aksi",
                        className: "text-center text-nowrap",
                        orderable: false,
                        searchable: false,
                        width: "15%"
                    }
                ],
                language: {
                    processing: '<div class="spinner-border text-primary" role="status"></div>',
                    search: "",
                    searchPlaceholder: "Cari...",
                    lengthMenu: "Tampilkan _MENU_ data per halaman",
                    zeroRecords: "Tidak ada data yang tersedia",
                    info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ data",
                    infoEmpty: "Menampilkan 0 sampai 0 dari 0 data",
                    infoFiltered: "(difilter dari _MAX_ total data)",
                    paginate: {
                        first: "Pertama",
                        last: "Terakhir",
                        next: "<i class='fas fa-chevron-right'></i>",
                        previous: "<i class='fas fa-chevron-left'></i>"
                    }
                },
                dom: "<'row'<'col-sm-12 col-md-6'l><'col-sm-12 col-md-6'f>>" +
                    "<'row'<'col-sm-12'tr>>" +
                    "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>"
            });

            $('#searchBox').on('keyup', function() {
                dataMahasiswa.search(this.value).draw();
            });

            $('.dataTables_filter').hide();
        });
    </script>
@endpush