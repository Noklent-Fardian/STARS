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
                <div class="card">
                    <div class="card-body">
                        <div class="step-progress">
                            <div class="step active">
                                <div class="step-number">1</div>
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
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">Pilih Lomba</h5>
                        <small class="text-muted">Pilih lomba yang sudah tersedia atau ajukan lomba baru</small>
                    </div>
                    <div class="card-body">
                        <!-- Search Box -->
                        <div class="row mb-4">
                            <div class="col-md-4">
                                <input type="text" id="searchLomba" class="form-control"
                                    placeholder="Cari nama lomba...">
                            </div>
                            <div class="col-md-4">
                                <select id="statusFilter" class="form-control">
                                    <option value="">Semua Status</option>
                                    <option value="verified">Hanya Terverifikasi</option>
                                    <option value="unverified">Belum Terverifikasi</option>
                                </select>
                            </div>
                            <div class="col-md-4 text-right">
                                <button type="button" class="btn btn-primary" onclick="showNewCompetitionForm()">
                                    <i class="fas fa-plus"></i> Ajukan Lomba Baru
                                </button>
                            </div>
                        </div>

                        <!-- Competition List -->

                        <div class="row" id="lombaList">
                            @forelse($lombas as $lomba)
                                <div class="col-md-6 col-lg-4 mb-3 lomba-item"
                                    data-name="{{ strtolower($lomba->lomba_nama) }}">
                                    <div
                                        class="card h-100 competition-card {{ $lomba->lomba_terverifikasi ? 'verified' : 'unverified' }}">
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
                                            <h6 class="card-title">{{ $lomba->lomba_nama }}</h6>
                                            <p class="card-text">
                                                <small class="text-muted">
                                                    <i class="fas fa-building"></i> {{ $lomba->lomba_penyelenggara }}<br>
                                                    <i class="fas fa-tag"></i> {{ $lomba->lomba_kategori }}<br>
                                                    <i class="fas fa-calendar"></i>
                                                    {{ $lomba->lomba_tanggal_mulai->format('d M Y') }} -
                                                    {{ $lomba->lomba_tanggal_selesai->format('d M Y') }}
                                                </small>
                                            </p>
                                            <div class="mt-3">
                                                <span
                                                    class="badge badge-info">{{ $lomba->tingkatan->tingkatan_nama }}</span>
                                                @foreach ($lomba->keahlians as $keahlian)
                                                    <span
                                                        class="badge badge-secondary">{{ $keahlian->keahlian_nama }}</span>
                                                @endforeach
                                            </div>

                                            <!-- Status description for unverified competitions -->
                                            @if (!$lomba->lomba_terverifikasi)
                                                <div class="mt-2">
                                                    <small class="text-warning">
                                                        <i class="fas fa-info-circle"></i>
                                                        Lomba ini sedang menunggu verifikasi admin
                                                    </small>
                                                </div>
                                            @endif
                                        </div>
                                        <div class="card-footer">
                                            <form action="{{ route('student.achievement.select-competition') }}"
                                                method="POST">
                                                @csrf
                                                <input type="hidden" name="lomba_id" value="{{ $lomba->id }}">
                                                <button type="submit"
                                                    class="btn btn-sm btn-block {{ $lomba->lomba_terverifikasi ? 'btn-primary' : 'btn-outline-warning' }}">
                                                    @if ($lomba->lomba_terverifikasi)
                                                        Pilih Lomba Ini
                                                    @else
                                                        Pilih Lomba (Belum Terverifikasi)
                                                    @endif
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <div class="col-12">
                                    <div class="text-center py-5">
                                        <i class="fas fa-trophy fa-3x text-muted mb-3"></i>
                                        <h5 class="text-muted">Belum ada lomba tersedia</h5>
                                        <p class="text-muted">Silakan ajukan lomba baru untuk memulai</p>
                                        <button type="button" class="btn btn-primary" onclick="showNewCompetitionForm()">
                                            <i class="fas fa-plus"></i> Ajukan Lomba Baru
                                        </button>
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
    <div class="modal fade" id="newCompetitionModal" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Ajukan Lomba Baru</h5>
                    <button type="button" class="close" data-dismiss="modal">
                        <span>&times;</span>
                    </button>
                </div>
                <form action="{{ route('student.achievement.store') }}" method="POST" id="newCompetitionForm">
                    @csrf
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Nama Lomba <span class="text-danger">*</span></label>
                                    <input type="text" name="lomba_nama" class="form-control" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Penyelenggara <span class="text-danger">*</span></label>
                                    <input type="text" name="lomba_penyelenggara" class="form-control" required>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Kategori Lomba <span class="text-danger">*</span></label>
                                    <input type="text" name="lomba_kategori" class="form-control" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Tingkatan Lomba <span class="text-danger">*</span></label>
                                    <select name="lomba_tingkatan_id" class="form-control" required>
                                        <option value="">Pilih Tingkatan</option>
                                        @foreach ($tingkatans as $tingkatan)
                                            <option value="{{ $tingkatan->id }}">{{ $tingkatan->tingkatan_nama }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Bidang Keahlian <span class="text-danger">*</span></label>
                                    <div class="github-topics-container">
                                        <!-- Input field for typing -->
                                        <div class="topics-input-wrapper">
                                            <div class="selected-topics" id="selectedTopics"></div>
                                            <input type="text" id="topicsInput" class="topics-input"
                                                placeholder="Ketik bidang keahlian..." autocomplete="off">
                                        </div>

                                        <!-- Dropdown suggestions -->
                                        <div class="topics-dropdown" id="topicsDropdown">
                                            <div class="dropdown-content" id="dropdownContent"></div>
                                        </div>
                                    </div>

                                    <!-- Hidden inputs container -->
                                    <div id="hiddenKeahlianInputs"></div>

                                    <small class="text-muted">
                                        Ketik untuk mencari bidang keahlian. Tekan Enter untuk menambah bidang baru jika
                                        tidak ditemukan.
                                    </small>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Link Pendaftaran</label>
                            <input type="url" name="lomba_link_pendaftaran" class="form-control">
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Tanggal Mulai <span class="text-danger">*</span></label>
                                    <input type="date" name="lomba_tanggal_mulai" class="form-control" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Tanggal Selesai <span class="text-danger">*</span></label>
                                    <input type="date" name="lomba_tanggal_selesai" class="form-control" required>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Link Poster</label>
                            <input type="url" name="lomba_link_poster" class="form-control">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary" id="submitBtn">Ajukan Lomba</button>
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
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background-color: #e9ecef;
            color: #6c757d;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            margin-bottom: 8px;
        }

        .step.active .step-number {
            background-color: #007bff;
            color: white;
        }

        .step-title {
            font-size: 12px;
            text-align: center;
            color: #6c757d;
        }

        .step.active .step-title {
            color: #007bff;
            font-weight: 600;
        }

        .step-line {
            width: 100px;
            height: 2px;
            background-color: #e9ecef;
            margin: 0 20px;
            margin-bottom: 20px;
        }

        .competition-card {
            transition: transform 0.2s;
            cursor: pointer;
            position: relative;
        }

        .competition-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }

        /* Verification status styling */
        .competition-card.verified {
            border-left: 4px solid #28a745;
        }

        .competition-card.unverified {
            border-left: 4px solid #ffc107;
            background-color: #fffdf5;
        }

        .verification-badge {
            position: absolute;
            top: 10px;
            right: 10px;
            z-index: 1;
        }

        .verification-badge .badge {
            font-size: 0.7rem;
            padding: 0.3rem 0.5rem;
        }

        .badge-success {
            background-color: #28a745;
        }

        .badge-warning {
            background-color: #ffc107;
            color: #212529;
        }

        .btn-outline-warning {
            color: #856404;
            border-color: #ffc107;
        }

        .btn-outline-warning:hover {
            color: #fff;
            background-color: #ffc107;
            border-color: #ffc107;
        }

        .competition-card .card-body {
            padding-top: 3rem;
        }

        .github-topics-container {
            position: relative;
        }

        .topics-input-wrapper {
            border: 1px solid #ced4da;
            border-radius: 0.375rem;
            padding: 8px;
            min-height: 45px;
            display: flex;
            flex-wrap: wrap;
            align-items: center;
            gap: 6px;
            background: white;
            cursor: text;
        }

        .topics-input-wrapper:focus-within {
            border-color: #007bff;
            box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
        }

        .selected-topics {
            display: flex;
            flex-wrap: wrap;
            gap: 6px;
        }

        .topic-tag {
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 12px;
            padding: 4px 8px 4px 12px;
            font-size: 12px;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            max-width: 200px;
        }

        .topic-tag.new-topic {
            background-color: #28a745;
        }

        .topic-text {
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .topic-remove {
            background: none;
            border: none;
            color: white;
            cursor: pointer;
            padding: 0;
            margin: 0;
            width: 16px;
            height: 16px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 12px;
            line-height: 1;
        }

        .topic-remove:hover {
            background-color: rgba(255, 255, 255, 0.2);
        }

        .topics-input {
            border: none;
            outline: none;
            flex: 1;
            min-width: 120px;
            font-size: 14px;
            padding: 4px;
        }

        .topics-dropdown {
            top: 100%;
            left: 0;
            right: 0;
            background: white;
            border: 1px solid #ced4da;
            border-top: none;
            border-radius: 0 0 0.375rem 0.375rem;
            max-height: 200px;
            overflow-y: auto;
            z-index: 1000;
            display: none;
        }

        .topics-dropdown.show {
            display: block;
        }

        .dropdown-item {
            padding: 8px 12px;
            cursor: pointer;
            border-bottom: 1px solid #f8f9fa;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .dropdown-item:hover {
            background-color: #f8f9fa;
        }

        .dropdown-item.active {
            background-color: #007bff;
            color: white;
        }

        .dropdown-item.create-new {
            color: #28a745;
            font-weight: 500;
        }

        .dropdown-item.create-new:hover {
            background-color: #e8f5e8;
        }

        .dropdown-item .fa-plus {
            color: #28a745;
        }

        .empty-state {
            padding: 12px;
            text-align: center;
            color: #6c757d;
            font-style: italic;
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

        // Initialize topics input
        document.addEventListener('DOMContentLoaded', function() {
            const topicsInput = document.getElementById('topicsInput');
            const topicsDropdown = document.getElementById('topicsDropdown');
            const selectedTopicsContainer = document.getElementById('selectedTopics');
            const inputWrapper = document.querySelector('.topics-input-wrapper');

            // Focus input when clicking wrapper
            inputWrapper.addEventListener('click', () => {
                topicsInput.focus();
            });

            // Handle input events
            topicsInput.addEventListener('input', handleInput);
            topicsInput.addEventListener('keydown', handleKeydown);
            topicsInput.addEventListener('focus', () => {
                if (topicsInput.value.trim()) {
                    showDropdown();
                }
            });

            // Hide dropdown when clicking outside
            document.addEventListener('click', (e) => {
                if (!e.target.closest('.github-topics-container')) {
                    hideDropdown();
                }
            });
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
                        // Create new keahlian if input has value
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

            // Add existing keahlians
            filtered.forEach(keahlian => {
                const item = createDropdownItem(keahlian.keahlian_nama, () => {
                    addKeahlian(keahlian);
                });
                dropdown.appendChild(item);
            });

            // Add "Create new" option if no exact match
            const exactMatch = filtered.some(k => k.keahlian_nama.toLowerCase() === searchValue.toLowerCase());
            if (searchValue && !exactMatch) {
                const createItem = createDropdownItem(
                    `<i class="fas fa-plus"></i> Buat "${searchValue}"`,
                    () => addNewKeahlian(searchValue),
                    'create-new'
                );
                dropdown.appendChild(createItem);
            }

            // Show empty state if no results
            if (dropdown.children.length === 0) {
                const emptyItem = document.createElement('div');
                emptyItem.className = 'empty-state';
                emptyItem.textContent = 'Tidak ada hasil ditemukan';
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
            // Generate temporary negative ID for new keahlians
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

        // Form validation
        document.getElementById('newCompetitionForm').addEventListener('submit', function(e) {
            if (selectedKeahlians.length === 0) {
                e.preventDefault();
                alert('Silakan pilih minimal satu bidang keahlian!');
                return false;
            }
        });

        // Search functionality for existing competitions
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

        // Reset form when modal is closed
        $('#newCompetitionModal').on('hidden.bs.modal', function() {
            selectedKeahlians = [];
            updateSelectedTopics();
            updateHiddenInputs();
            clearInput();
            hideDropdown();
        });

        // Filter competitions by status
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
    </script>
@endpush
