@extends('layouts.template')

@section('title', 'Verifikasi Prestasi | STARS')

@section('page-title', 'Verifikasi Prestasi Mahasiswa')

@section('breadcrumb')
@endsection

@section('content')
    <div class="card shadow-sm rounded-lg overflow-hidden">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-white">
                <i class="fas fa-check-circle mr-2"></i>Daftar Prestasi untuk Verifikasi Admin
            </h6>
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
                            <p>Total</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Filter Section -->
            <div class="row mb-3">
                <div class="col-md-3">
                    <div class="has-filter">
                        <select class="form-control filter-control" id="statusFilter">
                            <option value="">Semua Status</option>
                            <option value="Menunggu">Menunggu Verifikasi</option>
                            <option value="Diterima">Diterima</option>
                            <option value="Ditolak">Ditolak</option>
                        </select>
                        <span class="form-control-feedback">
                            <i class="fas fa-filter"></i>
                        </span>
                    </div>
                </div>
                <div class="col-md-9">
                    <div class="has-search">
                        <input type="text" class="form-control" placeholder="Cari prestasi, mahasiswa, atau lomba..."
                            id="searchBox">
                        <span class="form-control-feedback">
                            <i class="fas fa-search"></i>
                        </span>
                    </div>
                </div>
            </div>

            <div class="table-responsive">
                <table class="table table-hover table-striped" id="table_prestasi_verification">
                    <thead>
                        <tr>
                            <th width="5%">No</th>
                            <th width="20%">Mahasiswa</th>
                            <th width="25%">Prestasi</th>
                            <th width="15%">Dosen Pembimbing</th>
                            <th width="10%">Status Dosen</th>
                            <th width="10%">Status Admin</th>
                            <th width="15%" class="text-center">Aksi</th>
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

        /* Filter Controls */
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
        }

        .has-filter {
            position: relative;
        }

        .has-filter .form-control-feedback {
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
            left: 0;
            top: 0;
        }

        /* Mahasiswa Info Styling */
        .mahasiswa-info {
            display: flex;
            flex-direction: column;
            gap: 0.25rem;
        }

        .mahasiswa-nama {
            font-weight: 600;
            color: var(--primary-color);
        }

        .mahasiswa-nim {
            font-size: 0.875rem;
            color: var(--light-text);
        }

        .mahasiswa-prodi {
            font-size: 0.8rem;
            color: var(--light-text);
            font-style: italic;
        }

        /* Prestasi Info Styling */
        .prestasi-info {
            display: flex;
            flex-direction: column;
            gap: 0.25rem;
        }

        .prestasi-judul {
            font-weight: 600;
            color: var(--primary-color);
            font-size: 0.9rem;
        }

        .prestasi-detail {
            font-size: 0.8rem;
            color: var(--light-text);
        }

        /* Badge Styling */
        .badge {
            font-size: 0.8em;
            padding: 0.5em 0.8em;
            border-radius: 15px;
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

            .mahasiswa-info {
                flex-direction: column;
                align-items: flex-start;
            }

            .table-responsive {
                font-size: 0.9rem;
            }
        }
    </style>
@endpush

@push('js')
    <!-- DataTables JS -->
    <script type="text/javascript" src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap4.min.js"></script>
    <script>
        var dataPrestasiVerification;

        $(document).ready(function() {
            // Initialize DataTable
            dataPrestasiVerification = $('#table_prestasi_verification').DataTable({
                scrollX: true,
                serverSide: true,
                processing: true,
                ajax: {
                    url: "{{ route('admin.prestasiVerification.list') }}",
                    dataType: "json",
                    type: "GET",
                    data: function(d) {
                        d.status = $('#statusFilter').val();
                    }
                },
                columns: [{
                        data: "DT_RowIndex",
                        className: "text-center",
                        width: "5%",
                        orderable: false
                    },
                    {
                        data: "mahasiswa_info",
                        width: "20%",
                        orderable: false,
                        render: function(data, type, row) {
                            return `
                                <div class="mahasiswa-info">
                                    <div class="mahasiswa-nama">${data.nama}</div>
                                    <div class="mahasiswa-nim">NIM: ${data.nim}</div>
                                    <div class="mahasiswa-prodi">${data.prodi}</div>
                                </div>
                            `;
                        }
                    },
                    {
                        data: "prestasi_info",
                        width: "25%",
                        orderable: false,
                        render: function(data, type, row) {
                            return `
                                <div class="prestasi-info">
                                    <div class="prestasi-judul">${data.judul}</div>
                                    <div class="prestasi-detail">Lomba: ${data.lomba}</div>
                                    <div class="prestasi-detail">Peringkat: ${data.peringkat}</div>
                                    <div class="prestasi-detail">Score: ${data.score}</div>
                                </div>
                            `;
                        }
                    },
                    {
                        data: "dosen_pembimbing",
                        width: "15%",
                        orderable: false
                    },
                    {
                        data: "status_verifikasi_dosen",
                        className: "text-center",
                        width: "10%",
                        orderable: false
                    },
                    {
                        data: "status_verifikasi",
                        className: "text-center",
                        width: "10%",
                        orderable: false
                    },
                    {
                        data: "aksi",
                        className: "text-center",
                        width: "15%",
                        orderable: false,
                        searchable: false
                    }
                ],
                pageLength: 10,
                lengthMenu: [
                    [10, 25, 50, 100],
                    [10, 25, 50, 100]
                ],
                order: [
                    [0, "desc"]
                ],
                language: {
                    processing: '<div class="spinner-border text-primary" role="status"><span class="sr-only">Loading...</span></div>',
                    search: "",
                    searchPlaceholder: "Cari...",
                    lengthMenu: "Tampilkan _MENU_ data per halaman",
                    zeroRecords: "<div class='empty-state'><i class='fas fa-trophy empty-icon'></i><h5 class='empty-title'>Belum ada prestasi</h5><p class='empty-text'>Belum ada prestasi yang perlu diverifikasi.</p></div>",
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
                drawCallback: function(settings) {
                    var api = this.api();
                    var response = api.ajax.json();
                    updateStatistics(response);
                }
            });

            // Custom search functionality
            $('#searchBox').on('keyup', function() {
                dataPrestasiVerification.search(this.value).draw();
            });

            // Status filter
            $('#statusFilter').on('change', function() {
                dataPrestasiVerification.ajax.reload();
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
    </script>
@endpush
