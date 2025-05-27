@extends('layouts.template')

@section('title', 'Verifikasi Prestasi - Pilih Lomba | STARS')

@section('page-title', 'Verifikasi Prestasi')

@section('breadcrumb')
    <li class="breadcrumb-item active">Verifikasi Prestasi</li>
@endsection

@section('content')
    <div class="container-fluid">
        <!-- Progress Steps -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <div class="step-progress">
                            <div class="step active">
                                <div class="step-number">
                                    <i class="fas fa-trophy"></i>
                                </div>
                                <div class="step-title">Pilih Lomba</div>
                            </div>
                            <div class="step-line"></div>
                            <div class="step">
                                <div class="step-number">2</div>
                                <div class="step-title">Data Penghargaan</div>
                            </div>
                            <div class="step-line"></div>
                            <div class="step">
                                <div class="step-number">3</div>
                                <div class="step-title">Selesai</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Competition Selection -->
        <div class="row">
            <div class="col-12">
                <div class="card shadow-sm">
                    <div class="card-header bg-gradient-primary text-white">
                        <div class="d-flex align-items-center">
                            <i class="fas fa-medal mr-2"></i>
                            <div>
                                <h5 class="mb-0 text-white">Pilih Lomba</h5>
                                <small class="text-white-50">Pilih lomba yang sudah tersedia atau ajukan lomba baru</small>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <!-- Action Buttons -->
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <div class="d-flex flex-wrap gap-2">
                                    <button type="button" class="btn btn-primary" onclick="showNewCompetitionForm()">
                                        <i class="fas fa-plus-circle mr-1"></i>Ajukan Lomba Baru
                                    </button>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <!-- Search and Filter -->
                                <div class="d-flex flex-wrap gap-2 justify-content-md-end">
                                    <div class="has-search flex-grow-1" style="max-width: 300px;">
                                        <span class="fa fa-search form-control-feedback"></span>
                                        <input type="text" id="searchLomba" class="form-control"
                                            placeholder="Cari lomba...">
                                    </div>
                                    <select id="statusFilter" class="form-control" style="max-width: 200px;">
                                        <option value="">Semua Status</option>
                                        <option value="verified">Terverifikasi</option>
                                        <option value="unverified">Belum Terverifikasi</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <!-- Competition List -->
                        <div class="row" id="lombaList">
                            @forelse($lombas as $lomba)
                                <div class="col-md-6 col-lg-4 mb-3 lomba-item"
                                    data-name="{{ strtolower($lomba->lomba_nama) }}">
                                    <div class="card h-100 competition-card {{ $lomba->lomba_terverifikasi ? 'verified' : 'unverified' }}"
                                        onclick="selectCompetition({{ $lomba->id }})">
                                        <!-- Verification Status Badge -->
                                        <div class="verification-badge">
                                            @if ($lomba->lomba_terverifikasi)
                                                <span class="badge badge-success">
                                                    <i class="fas fa-check-circle"></i> Terverifikasi
                                                </span>
                                            @else
                                                <span class="badge badge-warning">
                                                    <i class="fas fa-clock"></i> Menunggu Verifikasi
                                                </span>
                                            @endif
                                        </div>

                                        <div class="card-body">
                                            <h6 class="card-title font-weight-bold">{{ $lomba->lomba_nama }}</h6>
                                            <p class="card-text">
                                                <small class="text-muted">
                                                    <i
                                                        class="fas fa-building mr-1"></i>{{ $lomba->lomba_penyelenggara }}<br>
                                                    <i class="fas fa-tag mr-1"></i>{{ $lomba->lomba_kategori }}<br>
                                                    <i class="fas fa-calendar mr-1"></i>
                                                    {{ $lomba->lomba_tanggal_mulai->format('d M Y') }} -
                                                    {{ $lomba->lomba_tanggal_selesai->format('d M Y') }}
                                                </small>
                                            </p>
                                            <div class="mt-3">
                                                <span class="badge badge-info">
                                                    <i
                                                        class="fas fa-layer-group mr-1"></i>{{ $lomba->tingkatan->tingkatan_nama }}
                                                </span>
                                                @foreach ($lomba->keahlians as $keahlian)
                                                    <span class="badge badge-secondary">
                                                        <i class="fas fa-code mr-1"></i>{{ $keahlian->keahlian_nama }}
                                                    </span>
                                                @endforeach
                                            </div>

                                            <!-- Status description for unverified competitions -->
                                            @if (!$lomba->lomba_terverifikasi)
                                                <div class="mt-2">
                                                    <small class="text-warning">
                                                        <i class="fas fa-info-circle mr-1"></i>
                                                        Lomba ini sedang menunggu verifikasi admin
                                                    </small>
                                                </div>
                                            @endif
                                        </div>
                                        <div class="card-footer bg-transparent">
                                            <button type="button"
                                                class="btn btn-sm btn-block {{ $lomba->lomba_terverifikasi ? 'btn-primary' : 'btn-outline-warning' }}">
                                                @if ($lomba->lomba_terverifikasi)
                                                    <i class="fas fa-arrow-right mr-1"></i> Pilih Lomba Ini
                                                @else
                                                    <i class="fas fa-exclamation-triangle mr-1"></i>Pilih Lomba (Belum
                                                    Terverifikasi)
                                                @endif
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <div class="col-12">
                                    <div class="text-center py-5">
                                        <div class="empty-state">
                                            <i class="fas fa-trophy fa-4x text-muted mb-3"></i>
                                            <h5 class="text-muted">Belum ada lomba tersedia</h5>
                                            <p class="text-muted">Silakan ajukan lomba baru untuk memulai verifikasi
                                                prestasi</p>
                                            <button type="button" class="btn btn-primary"
                                                onclick="showNewCompetitionForm()">
                                                <i class="fas fa-plus-circle mr-1"></i>Ajukan Lomba Baru
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            @endforelse
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- New Competition Modal -->
    <div class="modal fade" id="newCompetitionModal" tabindex="-1" role="dialog"
        aria-labelledby="newCompetitionModalLabel">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header bg-gradient-primary text-white">
                    <h5 class="modal-title" id="newCompetitionModalLabel">
                        <i class="fas fa-plus-circle mr-2"></i>Ajukan Lomba Baru
                    </h5>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="newCompetitionForm">
                    @csrf
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label><i class="fas fa-trophy mr-1"></i>Nama Lomba <span
                                            class="text-danger">*</span></label>
                                    <input type="text" name="lomba_nama" class="form-control" required>
                                    <div class="invalid-feedback"></div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label><i class="fas fa-building mr-1"></i>Penyelenggara <span
                                            class="text-danger">*</span></label>
                                    <input type="text" name="lomba_penyelenggara" class="form-control" required>
                                    <div class="invalid-feedback"></div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label><i class="fas fa-tag mr-1"></i>Kategori Lomba <span
                                            class="text-danger">*</span></label>
                                    <select name="lomba_kategori" class="form-control" required>
                                        <option value="">Pilih Kategori</option>
                                        <option value="Akademik">Akademik</option>
                                        <option value="Non-Akademik">Non-Akademik</option>
                                    </select>
                                    <div class="invalid-feedback"></div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label><i class="fas fa-layer-group mr-1"></i>Tingkatan Lomba <span
                                            class="text-danger">*</span></label>
                                    <select name="lomba_tingkatan_id" class="form-control" required>
                                        <option value="">Pilih Tingkatan</option>
                                        @foreach ($tingkatans as $tingkatan)
                                            <option value="{{ $tingkatan->id }}">{{ $tingkatan->tingkatan_nama }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <div class="invalid-feedback"></div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label><i class="fas fa-code mr-1"></i>Bidang Keahlian <span
                                            class="text-danger">*</span></label>
                                    <div class="github-topics-container">
                                        <div class="topics-input-wrapper">
                                            <div class="selected-topics" id="selectedTopics"></div>
                                            <input type="text" id="topicsInput" class="topics-input"
                                                placeholder="Ketik bidang keahlian..." autocomplete="off">
                                        </div>
                                        <div class="topics-dropdown" id="topicsDropdown">
                                            <div class="dropdown-content" id="dropdownContent"></div>
                                        </div>
                                    </div>
                                    <div id="hiddenKeahlianInputs"></div>
                                    <small class="text-muted">
                                        <i class="fas fa-info-circle mr-1"></i>
                                        Ketik untuk mencari bidang keahlian. Tekan Enter untuk menambah bidang baru jika
                                        tidak ditemukan.
                                    </small>
                                    <div class="invalid-feedback"></div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label><i class="fas fa-calendar-alt mr-1"></i>Tanggal Mulai <span
                                            class="text-danger">*</span></label>
                                    <input type="date" name="lomba_tanggal_mulai" class="form-control" required>
                                    <div class="invalid-feedback"></div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label><i class="fas fa-calendar-check mr-1"></i>Tanggal Selesai <span
                                            class="text-danger">*</span></label>
                                    <input type="date" name="lomba_tanggal_selesai" class="form-control" required>
                                    <div class="invalid-feedback"></div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label><i class="fas fa-link mr-1"></i>Link Pendaftaran</label>
                                    <input type="url" name="lomba_link_pendaftaran" class="form-control">
                                    <div class="invalid-feedback"></div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label><i class="fas fa-image mr-1"></i>Link Poster</label>
                                    <input type="url" name="lomba_link_poster" class="form-control">
                                    <div class="invalid-feedback"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer bg-light">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">
                            <i class="fas fa-times mr-1"></i>Batal
                        </button>
                        <button type="submit" class="btn btn-primary" id="submitBtn">
                            <i class="fas fa-paper-plane mr-1"></i>
                            <span class="submit-text">Ajukan Lomba</span>
                            <span class="submit-loading" style="display: none;">
                            </span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('css')
    <style>
        .step-progress {
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 20px 0;
        }

        .step {
            display: flex;
            flex-direction: column;
            align-items: center;
            position: relative;
        }

        .step-number {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            background-color: #e9ecef;
            color: #6c757d;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            margin-bottom: 8px;
            transition: var(--transition);
            font-size: 1.1rem;
        }

        .step.active .step-number {
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            color: white;
            box-shadow: var(--shadow);
        }

        .step-title {
            font-size: 14px;
            text-align: center;
            color: #6c757d;
            font-weight: 500;
        }

        .step.active .step-title {
            color: var(--primary-color);
            font-weight: 600;
        }

        .step-line {
            width: 100px;
            height: 3px;
            background-color: #e9ecef;
            margin: 0 20px;
            margin-bottom: 25px;
            border-radius: 2px;
        }

        .competition-card {
            transition: all 0.3s ease;
            cursor: pointer;
            position: relative;
            border: 2px solid transparent;
        }

        .competition-card.unverified:hover {
            transform: translateY(-8px);
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1);
            border-color: var(--accent-color);
        }

        .competition-card.verified:hover {
            transform: translateY(-8px);
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1);
            border-color: #28a745;
        }

        .competition-card.verified {
            border-left: 4px solid #28a745;
        }


        .competition-card.unverified {
            border-left: 4px solid var(--accent-color);
            background-color: #fffdf5;
        }

        .verification-badge {
            position: absolute;
            top: 15px;
            right: 15px;
            z-index: 2;
        }

        .verification-badge .badge {
            font-size: 0.75rem;
            padding: 0.4rem 0.6rem;
            border-radius: 20px;
            font-weight: 600;
        }

        .competition-card .card-body {
            padding-top: 3.5rem;
        }

        .bg-gradient-primary {
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color)) !important;
        }

        .has-search {
            position: relative;
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
            color: #aaa;
        }

        .has-search .form-control {
            padding-left: 2.375rem;
        }

        .github-topics-container {
            position: relative;
        }

        .topics-input-wrapper {
            border: 2px solid #e3e6f0;
            border-radius: var(--border-radius);
            padding: 10px;
            min-height: 50px;
            display: flex;
            flex-wrap: wrap;
            align-items: center;
            gap: 8px;
            background: white;
            cursor: text;
            transition: border-color 0.3s ease;
        }

        .topics-input-wrapper:focus-within {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 0.2rem rgba(16, 32, 68, 0.25);
        }

        .selected-topics {
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
        }

        .topic-tag {
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            color: white;
            border: none;
            border-radius: 20px;
            padding: 6px 10px 6px 14px;
            font-size: 13px;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            max-width: 250px;
            font-weight: 500;
        }

        .topic-tag.new-topic {
            background: linear-gradient(135deg, #28a745, #20c997);
        }

        .topic-text {
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .topic-remove {
            background: rgba(255, 255, 255, 0.2);
            border: none;
            color: white;
            cursor: pointer;
            padding: 0;
            margin: 0;
            width: 18px;
            height: 18px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 12px;
            transition: background-color 0.2s ease;
        }

        .topic-remove:hover {
            background: rgba(255, 255, 255, 0.3);
        }

        .topics-input {
            border: none;
            outline: none;
            flex: 1;
            min-width: 150px;
            font-size: 14px;
            padding: 6px;
        }

        .topics-dropdown {
            top: 100%;
            left: 0;
            right: 0;
            background: white;
            border: 2px solid #e3e6f0;
            border-top: none;
            border-radius: 0 0 var(--border-radius) var(--border-radius);
            max-height: 250px;
            overflow-y: auto;
            z-index: 1000;
            display: none;
            box-shadow: var(--shadow);
        }

        .topics-dropdown.show {
            display: block;
        }

        .dropdown-item {
            padding: 12px 16px;
            cursor: pointer;
            border-bottom: 1px solid #f8f9fa;
            display: flex;
            align-items: center;
            gap: 10px;
            transition: background-color 0.2s ease;
        }

        .dropdown-item:hover {
            background-color: #f8f9fc;
        }

        .dropdown-item.active {
            background-color: var(--primary-color);
            color: white;
        }

        .dropdown-item.create-new {
            color: #28a745;
            font-weight: 600;
        }

        .dropdown-item.create-new:hover {
            background-color: #e8f5e8;
        }

        .empty-state {
            padding: 3rem 1rem;
        }

        .invalid-feedback {
            display: none;
            width: 100%;
            margin-top: 0.25rem;
            font-size: 0.875rem;
            color: #dc3545;
        }

        .is-invalid~.invalid-feedback {
            display: block;
        }

        .is-invalid {
            border-color: #dc3545;
        }

        .submit-loading {
            display: none;
        }

        .spinner-border-sm {
            width: 1rem;
            height: 1rem;
        }

        @media (max-width: 768px) {
            .step-number {
                width: 40px;
                height: 40px;
                font-size: 1rem;
            }

            .step-title {
                font-size: 12px;
            }

            .step-line {
                width: 50px;
                margin: 0 10px;
                margin-bottom: 20px;
            }

            .verification-badge {
                top: 10px;
                right: 10px;
            }

            .competition-card .card-body {
                padding-top: 3rem;
            }

            .topics-input {
                min-width: 100px;
            }
        }
    </style>
@endpush

@push('js')
    <script>
        // Available keahlian data
        const availableKeahlians = @json(\App\Models\Keahlian::where('keahlian_visible', true)->get(['id', 'keahlian_nama']));
        let selectedKeahlians = [];
        let currentIndex = -1;

        function showNewCompetitionForm() {
            $('#newCompetitionModal').modal('show');
            setTimeout(() => {
                document.getElementById('topicsInput').focus();
            }, 300);
        }



        function selectCompetition(lombaId) {
            Swal.fire({
                title: 'Konfirmasi',
                text: 'Apakah Anda yakin ingin memilih lomba ini?',
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#102044',
                cancelButtonColor: '#6c757d',
                confirmButtonText: '<i class="fas fa-check mr-1"></i>Ya, Pilih',
                cancelButtonText: '<i class="fas fa-times mr-1"></i>Batal',
                showClass: {
                    popup: 'animate__animated animate__fadeIn'
                }
            }).then((result) => {
                if (result.isConfirmed) {


                    // Create form and submit
                    const form = document.createElement('form');
                    form.method = 'POST';
                    form.action = '{{ route('student.achievement.select-competition') }}';

                    const csrfToken = document.createElement('input');
                    csrfToken.type = 'hidden';
                    csrfToken.name = '_token';
                    csrfToken.value = '{{ csrf_token() }}';

                    const lombaInput = document.createElement('input');
                    lombaInput.type = 'hidden';
                    lombaInput.name = 'lomba_id';
                    lombaInput.value = lombaId;

                    form.appendChild(csrfToken);
                    form.appendChild(lombaInput);
                    document.body.appendChild(form);
                    form.submit();
                }
            });
        }

        // Initialize topics input
        document.addEventListener('DOMContentLoaded', function() {
            const topicsInput = document.getElementById('topicsInput');
            const topicsDropdown = document.getElementById('topicsDropdown');
            const selectedTopicsContainer = document.getElementById('selectedTopics');
            const inputWrapper = document.querySelector('.topics-input-wrapper');

            if (inputWrapper) {
                inputWrapper.addEventListener('click', () => {
                    topicsInput.focus();
                });

                topicsInput.addEventListener('input', handleInput);
                topicsInput.addEventListener('keydown', handleKeydown);
                topicsInput.addEventListener('focus', () => {
                    if (topicsInput.value.trim()) {
                        showDropdown();
                    }
                });

                document.addEventListener('click', (e) => {
                    if (!e.target.closest('.github-topics-container')) {
                        hideDropdown();
                    }
                });
            }
        });

        function handleInput(e) {
            const value = e.target.value.trim();
            currentIndex = -1;

            if (value.length === 0) {
                hideDropdown();
                return;
            }

            const filtered = availableKeahlians.filter(keahlian =>
                keahlian.keahlian_nama.toLowerCase().includes(value.toLowerCase()) &&
                !selectedKeahlians.some(selected => selected.id === keahlian.id)
            );

            updateDropdown(filtered, value);
            showDropdown();
        }

        function handleKeydown(e) {
            const dropdown = document.getElementById('dropdownContent');
            const items = dropdown.querySelectorAll('.dropdown-item');

            switch (e.key) {
                case 'ArrowDown':
                    e.preventDefault();
                    currentIndex = Math.min(currentIndex + 1, items.length - 1);
                    updateActiveItem(items);
                    break;

                case 'ArrowUp':
                    e.preventDefault();
                    currentIndex = Math.max(currentIndex - 1, -1);
                    updateActiveItem(items);
                    break;

                case 'Enter':
                    e.preventDefault();
                    if (currentIndex >= 0 && items[currentIndex]) {
                        items[currentIndex].click();
                    } else {
                        const value = e.target.value.trim();
                        if (value) {
                            addNewKeahlian(value);
                        }
                    }
                    break;

                case 'Escape':
                    hideDropdown();
                    e.target.blur();
                    break;

                case 'Backspace':
                    if (e.target.value === '' && selectedKeahlians.length > 0) {
                        removeKeahlian(selectedKeahlians.length - 1);
                    }
                    break;
            }
        }

        function updateActiveItem(items) {
            items.forEach((item, index) => {
                item.classList.toggle('active', index === currentIndex);
            });
        }

        function updateDropdown(filtered, searchValue) {
            const dropdown = document.getElementById('dropdownContent');
            dropdown.innerHTML = '';

            filtered.forEach(keahlian => {
                const item = createDropdownItem(`<i class="fas fa-code mr-2"></i>${keahlian.keahlian_nama}`, () => {
                    addKeahlian(keahlian);
                });
                dropdown.appendChild(item);
            });

            const exactMatch = filtered.some(k => k.keahlian_nama.toLowerCase() === searchValue.toLowerCase());
            if (searchValue && !exactMatch) {
                const createItem = createDropdownItem(
                    `<i class="fas fa-plus mr-2"></i> Buat "${searchValue}"`,
                    () => addNewKeahlian(searchValue),
                    'create-new'
                );
                dropdown.appendChild(createItem);
            }

            if (dropdown.children.length === 0) {
                const emptyItem = document.createElement('div');
                emptyItem.className = 'empty-state';
                emptyItem.innerHTML = '<i class="fas fa-search mr-2"></i>Tidak ada hasil ditemukan';
                dropdown.appendChild(emptyItem);
            }
        }

        function createDropdownItem(text, onClick, className = '') {
            const item = document.createElement('div');
            item.className = `dropdown-item ${className}`;
            item.innerHTML = text;
            item.addEventListener('click', (e) => {
                e.preventDefault();
                onClick();
            });
            return item;
        }

        function addKeahlian(keahlian) {
            selectedKeahlians.push({
                id: keahlian.id,
                nama: keahlian.keahlian_nama,
                isNew: false
            });

            updateSelectedTopics();
            clearInput();
            hideDropdown();
            updateHiddenInputs();
        }

        function addNewKeahlian(nama) {
            const tempId = -Date.now();

            selectedKeahlians.push({
                id: tempId,
                nama: nama,
                isNew: true
            });

            updateSelectedTopics();
            clearInput();
            hideDropdown();
            updateHiddenInputs();
        }

        function removeKeahlian(index) {
            selectedKeahlians.splice(index, 1);
            updateSelectedTopics();
            updateHiddenInputs();
        }

        function updateSelectedTopics() {
            const container = document.getElementById('selectedTopics');
            container.innerHTML = '';

            selectedKeahlians.forEach((keahlian, index) => {
                const tag = document.createElement('div');
                tag.className = `topic-tag ${keahlian.isNew ? 'new-topic' : ''}`;
                tag.innerHTML = `
                    <span class="topic-text" title="${keahlian.nama}">${keahlian.nama}</span>
                    <button type="button" class="topic-remove" onclick="removeKeahlian(${index})">&times;</button>
                `;
                container.appendChild(tag);
            });
        }

        function updateHiddenInputs() {
            const container = document.getElementById('hiddenKeahlianInputs');
            container.innerHTML = '';

            selectedKeahlians.forEach(keahlian => {
                const input = document.createElement('input');
                input.type = 'hidden';
                input.name = keahlian.isNew ? 'new_keahlian_names[]' : 'lomba_keahlian_ids[]';
                input.value = keahlian.isNew ? keahlian.nama : keahlian.id;
                container.appendChild(input);
            });
        }

        function clearInput() {
            document.getElementById('topicsInput').value = '';
        }

        function showDropdown() {
            document.getElementById('topicsDropdown').classList.add('show');
        }

        function hideDropdown() {
            document.getElementById('topicsDropdown').classList.remove('show');
            currentIndex = -1;
        }

        // Clear validation errors
        function clearValidationErrors() {
            document.querySelectorAll('.is-invalid').forEach(field => {
                field.classList.remove('is-invalid');
            });
            document.querySelectorAll('.invalid-feedback').forEach(feedback => {
                feedback.textContent = '';
            });
        }

        // Show validation errors
        function showValidationErrors(errors) {
            for (const field in errors) {
                const input = document.querySelector(`[name="${field}"]`);
                if (input) {
                    input.classList.add('is-invalid');
                    const feedback = input.parentNode.querySelector('.invalid-feedback');
                    if (feedback) {
                        feedback.textContent = errors[field][0];
                    }
                }
            }
        }

        // Form submission with AJAX
        document.getElementById('newCompetitionForm').addEventListener('submit', function(e) {
            e.preventDefault();

            if (selectedKeahlians.length === 0) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Bidang Keahlian Diperlukan',
                    text: 'Silakan pilih minimal satu bidang keahlian!',
                    confirmButtonColor: '#102044',
                    showClass: {
                        popup: 'animate__animated animate__shakeX'
                    }
                });
                return false;
            }

            clearValidationErrors();

            const submitBtn = document.getElementById('submitBtn');
            const submitText = submitBtn.querySelector('.submit-text');
            const submitLoading = submitBtn.querySelector('.submit-loading');

            submitBtn.disabled = true;
            submitText.style.display = 'none';
            submitLoading.style.display = 'inline-flex';

            const formData = new FormData(this);

            $.ajax({
                url: '{{ route('student.achievement.store') }}',
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                headers: {
                    'Accept': 'application/json',
                },
                success: function(response) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil!',
                        text: 'Lomba berhasil diajukan dan akan segera diproses.',
                        confirmButtonColor: '#102044',
                        showClass: {
                            popup: 'animate__animated animate__bounceIn'
                        }
                    }).then(() => {
                        // Create form and submit to select-competition route
                        const form = document.createElement('form');
                        form.method = 'POST';
                        form.action = '{{ route('student.achievement.select-competition') }}';

                        const csrfToken = document.createElement('input');
                        csrfToken.type = 'hidden';
                        csrfToken.name = '_token';
                        csrfToken.value = '{{ csrf_token() }}';

                        const lombaInput = document.createElement('input');
                        lombaInput.type = 'hidden';
                        lombaInput.name = 'lomba_id';
                        lombaInput.value = response.lomba_id;

                        form.appendChild(csrfToken);
                        form.appendChild(lombaInput);
                        document.body.appendChild(form);
                        form.submit();
                    });
                },
                error: function(xhr) {
                    submitBtn.disabled = false;
                    submitText.style.display = 'inline';
                    submitLoading.style.display = 'none';

                    if (xhr.status === 422) {
                        const errors = xhr.responseJSON.errors;
                        showValidationErrors(errors);

                        Swal.fire({
                            icon: 'error',
                            title: 'Validasi Gagal',
                            text: 'Silakan periksa kembali form yang Anda isi.',
                            confirmButtonColor: '#102044',
                            showClass: {
                                popup: 'animate__animated animate__shakeX'
                            }
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Terjadi Kesalahan',
                            text: 'Mohon coba lagi beberapa saat.',
                            confirmButtonColor: '#102044'
                        });
                    }
                }
            });
        });

        // Search functionality
        document.getElementById('searchLomba').addEventListener('input', function() {
            const searchTerm = this.value.toLowerCase();
            const lombaItems = document.querySelectorAll('.lomba-item');

            lombaItems.forEach(item => {
                const lombaName = item.getAttribute('data-name');
                if (lombaName.includes(searchTerm)) {
                    item.style.display = 'block';
                } else {
                    item.style.display = 'none';
                }
            });
        });

        // Filter by status
        document.getElementById('statusFilter').addEventListener('change', function() {
            const filterValue = this.value;
            const lombaItems = document.querySelectorAll('.lomba-item');

            lombaItems.forEach(item => {
                const card = item.querySelector('.competition-card');
                const isVerified = card.classList.contains('verified');

                if (filterValue === '') {
                    item.style.display = 'block';
                } else if (filterValue === 'verified' && isVerified) {
                    item.style.display = 'block';
                } else if (filterValue === 'unverified' && !isVerified) {
                    item.style.display = 'block';
                } else {
                    item.style.display = 'none';
                }
            });
        });

        // Reset form when modal is closed
        $('#newCompetitionModal').on('hidden.bs.modal', function() {
            selectedKeahlians = [];
            updateSelectedTopics();
            updateHiddenInputs();
            clearInput();
            hideDropdown();
            clearValidationErrors();
            document.getElementById('newCompetitionForm').reset();

            const submitBtn = document.getElementById('submitBtn');
            const submitText = submitBtn.querySelector('.submit-text');
            const submitLoading = submitBtn.querySelector('.submit-loading');

            submitBtn.disabled = false;
            submitText.style.display = 'inline';
            submitLoading.style.display = 'none';
        });
    </script>
@endpush
