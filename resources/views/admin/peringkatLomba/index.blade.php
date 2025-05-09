@extends('layouts.template')

@section('title', 'Data Peringkat Lomba | STARS')

@section('page-title', 'Data Peringkat Lomba')

@section('breadcrumb')
@endsection

@section('content')
    <div class="card shadow-sm rounded-lg overflow-hidden">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-white">Daftar Peringkat Lomba</h6>
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

            <div class="mb-3 d-flex justify-content-between align-items-center flex-wrap">
                <div class="mb-2 mb-md-0">
                    <button onclick="modalAction('{{ route('admin.master.peringkatLomba.createAjax') }}')"
                        class="btn btn-primary">
                        <i class="fas fa-plus-circle mr-1"></i> Tambah Peringkat Lomba
                    </button>
                    <a href="{{ url('/admin/master/peringkatLomba/export_pdf') }}" class="btn btn-warning">
                        <i class="fas fa-file-pdf mr-1"></i> Export PDF
                    </a>
                </div>
                <div class="form-group has-search mb-0">
                    <span class="fa fa-search form-control-feedback"></span>
                    <input type="text" class="form-control" id="searchBox" placeholder="Cari peringkat lomba...">
                </div>
            </div>

            <div class="table-responsive">
                <table class="table table-hover table-striped" id="table_peringkat">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nama Peringkat</th>
                            <th>Bobot</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- DataTables will fill this -->
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

        #table_peringkat tbody tr {
            transition: all 0.2s ease;
        }

        #table_peringkat tbody tr:hover {
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

        var dataPeringkat;
        $(document).ready(function() {
            // Initialize DataTable
            dataPeringkat = $('#table_peringkat').DataTable({
                serverSide: true,
                processing: true,
                ajax: {
                    "url": "{{ route('admin.master.peringkatLomba.list') }}",
                    "dataType": "json",
                    "type": "GET",
                },
                columns: [{
                    data: "id",
                    className: "text-center",
                    width: "5%"
                }, {
                    data: "peringkat_nama",
                    width: "35%"
                }, {
                    data: "peringkat_bobot",
                    width: "10%",
                    render: function(data, type, row) {
                        if (type === 'display' || type === 'filter') {
                            return parseFloat(data).toFixed(2);
                        }
                        return data;
                    }
                }, {
                    data: "aksi",
                    className: "text-center",
                    orderable: false,
                    searchable: false,
                    width: "15%"
                }, ],
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
                    "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
            });

            // Connect custom search box to DataTable
            $('#searchBox').on('keyup', function() {
                dataPeringkat.search(this.value).draw();
            });

            // Hide default search box
            $('.dataTables_filter').hide();
        });
    </script>
@endpush