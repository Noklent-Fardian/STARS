@extends('layouts.template')

@section('title', 'Verifikasi Lomba | STARS')

@section('page-title', 'Verifikasi Lomba')

@section('breadcrumb')
@endsection

@section('content')
    <div class="card shadow-sm rounded-lg overflow-hidden">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-white">Daftar Lomba untuk Verifikasi</h6>
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

            <!-- Filter Section -->
            <div class="row mb-3">
                <div class="mb-3 d-flex justify-content-between align-items-center flex-wrap">
                    <div class="btn-group-responsive">
                        <select class="form-control filter-control" id="statusFilter"
                            style="width: 200px; display: inline-block;">
                            <option value="">Semua Status</option>
                            <option value="Menunggu">Menunggu Verifikasi</option>
                            <option value="Diterima">Diterima</option>
                            <option value="Ditolak">Ditolak</option>
                        </select>
                    </div>
                </div>
                <div class="ml-auto">
                    <div class="form-group has-search mb-0 ml-auto" style="max-width: 300px;">
                        <span class="fa fa-search form-control-feedback"></span>
                        <input type="text" class="form-control" id="searchBox"
                            placeholder="Cari lomba atau penyelenggara...">
                    </div>
                </div>
            </div>

            <!-- Statistics Cards -->
            <div class="row mb-4">
                <div class="col-md-3">
                    <div class="stat-card stat-pending">
                        <div class="stat-icon">
                            <i class="fas fa-clock"></i>
                        </div>
                        <div class="stat-content">
                            <h4 id="stat-pending-count">0</h4>
                            <p>Menunggu</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="stat-card stat-approved">
                        <div class="stat-icon">
                            <i class="fas fa-check"></i>
                        </div>
                        <div class="stat-content">
                            <h4 id="stat-approved-count">0</h4>
                            <p>Diterima</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="stat-card stat-rejected">
                        <div class="stat-icon">
                            <i class="fas fa-times"></i>
                        </div>
                        <div class="stat-content">
                            <h4 id="stat-rejected-count">0</h4>
                            <p>Ditolak</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="stat-card stat-total">
                        <div class="stat-icon">
                            <i class="fas fa-trophy"></i>
                        </div>
                        <div class="stat-content">
                            <h4 id="stat-total-count">0</h4>
                            <p>Total Lomba</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="table-responsive">
                <table class="table table-hover table-striped" id="table_verification">
                    <thead>
                        <tr>
                            <th width="8%">ID Lomba</th>
                            <th width="20%">Penginput</th>
                            <th width="25%">Nama Lomba</th>
                            <th width="18%">Penyelenggara</th>
                            <th width="12%">Tanggal Input</th>
                            <th width="12%">Status</th>
                            <th width="8%" class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- DataTables akan mengisi ini -->
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

@push('css')
    <!-- DataTables CSS -->
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap4.min.css">
    <style>
        :root {
            --primary-color: #102044;
            --secondary-color: #1a2a4d;
            --accent-color: #fa9d1c;
            --success-color: #28a745;
            --warning-color: #ffc107;
            --danger-color: #dc3545;
            --light-bg: #f8f9fc;
            --light-text: #6c757d;
            --border-color: #e3e6f0;
        }

        /* Card Header Styling */
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

        .filter-control {
            border-radius: 8px;
            padding: 0.6rem 1rem;
            transition: all 0.3s ease;
            border: 1px solid rgba(0, 0, 0, 0.1);
            background-color: rgba(255, 255, 255, 0.9);
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.05);
        }

        .filter-control:focus {
            border-color: var(--accent-color);
            box-shadow: 0 0 0 0.2rem rgba(250, 157, 28, 0.25);
            background-color: #fff;
        }

        /* Enhanced Search Box Styling */
        .has-search .form-control {
            padding-left: 2.8rem;
            border-radius: 8px;
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

        #statusFilter {
            width: 220px !important;
            min-width: 200px;
            max-width: 100%;
        }

        #searchBox {
            width: 320px !important;
            min-width: 200px;
            max-width: 100%;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        /* Statistics Cards */
        .stat-card {
            background: #fff;
            border-radius: 12px;
            padding: 1.5rem;
            margin-bottom: 1rem;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
            border-left: 4px solid;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            display: flex;
            align-items: center;
        }

        .stat-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 16px rgba(0, 0, 0, 0.12);
        }

        .stat-pending {
            border-left-color: var(--warning-color);
        }

        .stat-approved {
            border-left-color: var(--success-color);
        }

        .stat-rejected {
            border-left-color: var(--danger-color);
        }

        .stat-total {
            border-left-color: var(--primary-color);
        }

        .stat-icon {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 1rem;
            font-size: 1.2rem;
        }

        .stat-pending .stat-icon {
            background: rgba(255, 193, 7, 0.1);
            color: var(--warning-color);
        }

        .stat-approved .stat-icon {
            background: rgba(40, 167, 69, 0.1);
            color: var(--success-color);
        }

        .stat-rejected .stat-icon {
            background: rgba(220, 53, 69, 0.1);
            color: var(--danger-color);
        }

        .stat-total .stat-icon {
            background: rgba(16, 32, 68, 0.1);
            color: var(--primary-color);
        }

        .stat-content h4 {
            margin: 0;
            font-size: 1.8rem;
            font-weight: 700;
            color: var(--primary-color);
        }

        .stat-content p {
            margin: 0;
            color: var(--light-text);
            font-size: 0.9rem;
        }

        /* Standard Bootstrap Badges */
        .badge {
            font-size: 0.8em;
            padding: 0.5em 0.8em;
            border-radius: 15px;
        }

        .table-responsive {
            overflow-x: auto;
            padding-bottom: 1rem;
        }

        .dataTables_wrapper {
            overflow-x: auto;
        }

        /* Empty State */
        .empty-state {
            padding: 3rem 1rem;
            text-align: center;
        }

        .empty-icon {
            font-size: 4rem;
            color: var(--light-text);
            margin-bottom: 1rem;
        }

        .empty-title {
            color: var(--primary-color);
            margin-bottom: 0.5rem;
        }

        .empty-text {
            color: var(--light-text);
            margin: 0;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .stat-card {
                margin-bottom: 0.5rem;
            }

            .stat-content h4 {
                font-size: 1.5rem;
            }

            .user-info {
                flex-direction: column;
                align-items: flex-start;
            }

            .table-responsive {
                font-size: 0.9rem;
            }
        }

        @media (max-width: 576px) {
            .table {
                font-size: 0.85rem;
            }

            .lomba-info .lomba-title {
                font-size: 0.9rem;
            }

            .stat-card {
                padding: 1rem;
            }
        }
    </style>
@endpush

@push('js')
    <!-- DataTables JS -->
    <script type="text/javascript" src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap4.min.js"></script>
    <script>
        var dataVerification;

        $(document).ready(function () {
            // Initialize DataTable with server-side processing
            dataVerification = $('#table_verification').DataTable({
                scrollX: true,
                serverSide: true,
                processing: true,
                ajax: {
                    url: "{{ route('admin.lombaVerification.list') }}",
                    dataType: "json",
                    type: "GET",
                    data: function (d) {
                        d.status = $('#statusFilter').val();
                    }
                },
                columns: [
                    {
                        data: "id",
                        className: "text-center",
                        width: "8%",
                        orderable: true
                    },
                    {
                        data: "penginput",
                        width: "20%",
                        orderable: true,
                        render: function (data, type, row) {
                            return `<div class="user-info">
                                            <div>${row.mahasiswa_nama || 'N/A'}</div>
                                            <small class="text-muted">
                                                <i class="fas fa-user-graduate mr-1"></i> ${row.mahasiswa_nim || 'N/A'}
                                            </small>
                                        </div>`;
                        }
                    },
                    {
                        data: "lomba_nama",
                        width: "25%",
                        orderable: true,
                        render: function (data, type, row) {
                            return `<div class="lomba-info">
                                            <div class="lomba-title">${data}</div>
                                            <small class="text-muted">
                                                <i class="fas fa-layer-group mr-1"></i> ${row.lomba_kategori}
                                            </small>
                                        </div>`;
                        }
                    },
                    {
                        data: "lomba_penyelenggara",
                        width: "18%",
                        orderable: true
                    },
                    {
                        data: "created_at",
                        width: "12%",
                        orderable: true,
                        render: function (data) {
                            return data ? new Date(data).toLocaleDateString('id-ID') : '-';
                        }
                    },
                    {
                        data: "pendaftaran_status",
                        width: "12%",
                        orderable: true,
                        render: function (data) {
                            if (data === 'Menunggu') {
                                return '<span class="badge badge-warning"><i class="fas fa-clock mr-1"></i> Menunggu</span>';
                            } else if (data === 'Diterima') {
                                return '<span class="badge badge-success"><i class="fas fa-check mr-1"></i> Diterima</span>';
                            } else {
                                return '<span class="badge badge-danger"><i class="fas fa-times mr-1"></i> Ditolak</span>';
                            }
                        }
                    },
                    {
                        data: "aksi",
                        className: "text-center text-nowrap",
                        width: "8%",
                        orderable: false,
                        searchable: false,
                        render: function (data, type, row) {
                            return `<a href="{{ route('admin.lombaVerification.show', '') }}/${row.id}" 
                                           class="btn btn-info btn-sm" 
                                           title="Lihat Detail & Verifikasi">
                                            <i class="fas fa-eye"></i>
                                        </a>`;
                        }
                    }
                ],
                pageLength: 10,
                lengthMenu: [[10, 25, 50, 100], [10, 25, 50, 100]],
                order: [[0, "desc"]],
                language: {
                    processing: '<div class="spinner-border text-primary" role="status"></div>',
                    search: "",
                    searchPlaceholder: "Cari...",
                    lengthMenu: "Tampilkan _MENU_ data per halaman",
                    zeroRecords: "Tidak ada data yang ditemukan",
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
                dom: "<'row'<'col-sm-12 col-md-6'l><'col-sm-12 col-md-6'>>" +
                    "<'row'<'col-sm-12'tr>>" +
                    "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
                drawCallback: function (settings) {
                    updateStatistics(settings.json);
                }
            });

            // Custom search functionality
            $('#searchBox').on('keyup', function () {
                dataVerification.search(this.value).draw();
            });

            // Status filter
            $('#statusFilter').on('change', function () {
                dataVerification.ajax.reload();
            });

            // Hide default DataTables search
            $('.dataTables_filter').hide();
        });

        // Function to update statistics
        function updateStatistics(data) {
            if (data && data.statistics) {
                $('#stat-pending-count').text(data.statistics.pending || 0);
                $('#stat-approved-count').text(data.statistics.approved || 0);
                $('#stat-rejected-count').text(data.statistics.rejected || 0);
                $('#stat-total-count').text(data.statistics.total || 0);
            }
        }

        // Animation for statistics cards
        $(window).on('load', function () {
            $('.stat-card').each(function (index) {
                $(this).delay(index * 100).animate({
                    opacity: 1,
                    transform: 'translateY(0)'
                }, 500);
            });
        });
    </script>
@endpush