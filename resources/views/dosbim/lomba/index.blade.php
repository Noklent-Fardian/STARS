@extends('layouts.template')

@section('title', 'Lihat Lomba | STARS')

@section('page-title', 'Lihat Lomba')

@section('breadcrumb')
    <li class="breadcrumb-item active">Lihat Lomba (Dosen)</li>
@endsection

@section('content')
    <div class="container-fluid">
        <!-- Header Section -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="card shadow-sm border-0">
                    <div class="card-body bg-gradient-primary text-white rounded">
                        <div class="row align-items-center">
                            <div class="col-md-8">
                                <h4 class="mb-2 text-white">
                                    <i class="fas fa-medal mr-2"></i>Lomba Tersedia
                                </h4>
                                <p class="mb-0 text-white-50">
                                    Jelajahi berbagai lomba untuk membimbing mahasiswa dan temukan peluang kolaborasi
                                </p>
                            </div>
                            <div class="col-md-4 text-md-right">
                                <button type="button" class="btn btn-light btn-lg" onclick="showNewCompetitionForm()">
                                    <i class="fas fa-plus-circle mr-2"></i>Ajukan Lomba Baru
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Filters and Search Section -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <div class="row">
                            <!-- Search -->
                            <div class="col-md-4 mb-3">
                                <div class="form-group">
                                    <label for="searchInput" class="font-weight-bold">
                                        <i class="fas fa-search mr-1"></i>Pencarian
                                    </label>
                                    <div class="input-group">
                                        <input type="text" id="searchInput" class="form-control"
                                            placeholder="Cari nama lomba, penyelenggara...">
                                        <div class="input-group-append">
                                            <span class="input-group-text bg-primary text-white">
                                                <i class="fas fa-search"></i>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Status Filter -->
                            <div class="col-md-2 mb-3">
                                <div class="form-group">
                                    <label for="statusFilter" class="font-weight-bold">
                                        <i class="fas fa-filter mr-1"></i>Status
                                    </label>
                                    <select id="statusFilter" class="form-control">
                                        <option value="">Semua Status</option>
                                        <option value="verified">Terverifikasi</option>
                                        <option value="unverified">Belum Terverifikasi</option>
                                    </select>
                                </div>
                            </div>

                            <!-- Category Filter -->
                            <div class="col-md-2 mb-3">
                                <div class="form-group">
                                    <label for="categoryFilter" class="font-weight-bold">
                                        <i class="fas fa-tag mr-1"></i>Kategori
                                    </label>
                                    <select id="categoryFilter" class="form-control">
                                        <option value="">Semua Kategori</option>
                                        <option value="Akademik">Akademik</option>
                                        <option value="Non-Akademik">Non-Akademik</option>
                                    </select>
                                </div>
                            </div>

                            <!-- Date Status Filter -->
                            <div class="col-md-2 mb-3">
                                <div class="form-group">
                                    <label for="dateFilter" class="font-weight-bold">
                                        <i class="fas fa-calendar mr-1"></i>Waktu
                                    </label>
                                    <select id="dateFilter" class="form-control">
                                        <option value="">Semua Waktu</option>
                                        <option value="upcoming">Akan Datang</option>
                                        <option value="ongoing">Sedang Berlangsung</option>
                                        <option value="finished">Sudah Selesai</option>
                                    </select>
                                </div>
                            </div>

                            <!-- Sort Filter -->
                            <div class="col-md-2 mb-3">
                                <div class="form-group">
                                    <label for="sortFilter" class="font-weight-bold">
                                        <i class="fas fa-sort mr-1"></i>Urutkan
                                    </label>
                                    <select id="sortFilter" class="form-control">
                                        <option value="name_asc">Nama A-Z</option>
                                        <option value="name_desc">Nama Z-A</option>
                                        <option value="date_start">Tanggal Mulai</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <!-- Clear Filters -->
                        <div class="row">
                            <div class="col-12">
                                <button type="button" class="btn btn-outline-secondary btn-sm" onclick="clearFilters()">
                                    <i class="fas fa-times mr-1"></i>Reset Filter
                                </button>
                                <span id="resultCount" class="ml-3 text-muted"></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Competition Cards -->
        <div class="row" id="lombaContainer">
            @forelse($lombas as $lomba)
                <div class="col-md-6 col-lg-4 mb-4 lomba-item"
                    data-name="{{ strtolower($lomba->lomba_nama . ' ' . $lomba->lomba_penyelenggara) }}"
                    data-status="{{ $lomba->lomba_terverifikasi ? 'verified' : 'unverified' }}"
                    data-category="{{ $lomba->lomba_kategori }}"
                    data-date-start="{{ $lomba->lomba_tanggal_mulai->format('Y-m-d') }}"
                    data-date-end="{{ $lomba->lomba_tanggal_selesai->format('Y-m-d') }}"
                    data-created="{{ $lomba->created_at ? $lomba->created_at->format('Y-m-d') : '' }}">

                    <div class="card h-100 competition-card {{ $lomba->lomba_terverifikasi ? 'verified' : 'unverified' }}"
                        onclick="viewCompetitionDetail({{ $lomba->id }})">

                        <!-- Verification Badge -->
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

                        <!-- Date Status Badge -->
                        <div class="date-status-badge">
                            @php
                                $now = now();
                                $start = $lomba->lomba_tanggal_mulai;
                                $end = $lomba->lomba_tanggal_selesai;
                            @endphp

                            @if ($now < $start)
                                <span class="badge badge-info">
                                    <i class="fas fa-clock"></i> Akan Datang
                                </span>
                            @elseif($now >= $start && $now <= $end)
                                <span class="badge badge-success">
                                    <i class="fas fa-play"></i> Berlangsung
                                </span>
                            @else
                                <span class="badge badge-secondary">
                                    <i class="fas fa-flag-checkered"></i> Selesai
                                </span>
                            @endif
                        </div>

                        <!-- Poster/Image -->
                        <div class="card-img-container">
                            @if ($lomba->lomba_link_poster)
                                <img src="{{ $lomba->lomba_link_poster }}" class="card-img-top"
                                    alt="{{ $lomba->lomba_nama }}" loading="lazy"
                                    onerror="this.src='https://picsum.photos/400/200?random={{ $lomba->id }}'">
                                <div class="default-poster overlay-poster">
                                    <i class="fas fa-trophy fa-3x text-muted"></i>
                                    <p class="text-muted mt-2">{{ $lomba->lomba_nama }}</p>
                                </div>
                            @else
                                <img src="https://picsum.photos/400/200?random={{ $lomba->id }}" class="card-img-top"
                                    alt="{{ $lomba->lomba_nama }}" loading="lazy">>
                                <div class="default-poster overlay-poster">
                                    <i class="fas fa-trophy fa-3x text-muted"></i>
                                    <p class="text-muted mt-2">{{ $lomba->lomba_nama }}</p>
                                </div>
                            @endif
                        </div>

                        <div class="card-body">
                            <h5 class="card-title font-weight-bold">{{ $lomba->lomba_nama }}</h5>

                            <div class="competition-info">
                                <p class="text-muted mb-2">
                                    <i class="fas fa-building mr-2"></i>{{ $lomba->lomba_penyelenggara }}
                                </p>
                                <p class="text-muted mb-2">
                                    <i class="fas fa-tag mr-2"></i>{{ $lomba->lomba_kategori }}
                                </p>
                                <p class="text-muted mb-3">
                                    <i class="fas fa-calendar mr-2"></i>
                                    {{ $lomba->lomba_tanggal_mulai->format('d M Y') }} -
                                    {{ $lomba->lomba_tanggal_selesai->format('d M Y') }}
                                </p>
                            </div>

                            <!-- Tingkatan and Skills -->
                            <div class="badges-container">
                                <span class="badge badge-primary mb-2">
                                    <i class="fas fa-layer-group mr-1"></i>{{ $lomba->tingkatan->tingkatan_nama }}
                                </span>

                                @foreach ($lomba->keahlians->take(2) as $keahlian)
                                    <span class="badge badge-secondary mb-2">
                                        <i class="fas fa-code mr-1"></i>{{ $keahlian->keahlian_nama }}
                                    </span>
                                @endforeach

                                @if ($lomba->keahlians->count() > 2)
                                    <span class="badge badge-light mb-2">
                                        +{{ $lomba->keahlians->count() - 2 }} lainnya
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="card-footer bg-transparent">
                            <div class="row">
                                <div class="col-8">
                                    <button type="button" class="btn btn-primary btn-sm btn-block">
                                        <i class="fas fa-eye mr-1"></i>Klik Untuk Lihat Detail
                                    </button>
                                </div>
                                <div class="col-4">
                                    @if ($lomba->lomba_link_pendaftaran)
                                        <a href="{{ $lomba->lomba_link_pendaftaran }}" target="_blank"
                                            class="btn btn-outline-success btn-sm btn-block"
                                            onclick="event.stopPropagation()">
                                            <i class="fas fa-external-link-alt"></i>
                                        </a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12">
                    <div class="empty-state text-center py-5">
                        <i class="fas fa-trophy fa-4x text-muted mb-3"></i>
                        <h4 class="text-muted">Belum ada lomba tersedia</h4>
                        <p class="text-muted mb-4">Belum ada lomba yang tersedia saat ini. Silakan ajukan lomba baru!</p>
                        <button type="button" class="btn btn-primary" onclick="showNewCompetitionForm()">
                            <i class="fas fa-plus-circle mr-2"></i>Ajukan Lomba Baru
                        </button>
                    </div>
                </div>
            @endforelse
        </div>

        <!-- No Results Message -->
        <div id="noResults" class="row" style="display: none;">
            <div class="col-12">
                <div class="text-center py-5">
                    <i class="fas fa-search fa-4x text-muted mb-3"></i>
                    <h4 class="text-muted">Tidak ada hasil ditemukan</h4>
                    <p class="text-muted">Coba ubah kata kunci pencarian atau filter yang Anda gunakan</p>
                    <button type="button" class="btn btn-outline-secondary" onclick="clearFilters()">
                        <i class="fas fa-times mr-1"></i>Reset Semua Filter
                    </button>
                </div>
            </div>
        </div>

        <!-- Load More Button -->
        <div class="row" id="loadMoreSection" style="display: none;">
            <div class="col-12 text-center">
                <button type="button" class="btn btn-outline-primary" id="loadMoreBtn">
                    <i class="fas fa-plus mr-2"></i>Muat Lebih Banyak
                </button>
            </div>
        </div>
    </div>

    <!-- New Competition Modal -->
    @include('dosbim.lomba.new-competition')
@endsection

@push('css')
    <style>
        .bg-gradient-primary {
            background: linear-gradient(135deg, #102044, #1a365d) !important;
        }

        .competition-card {
            transition: all 0.3s ease;
            cursor: pointer;
            border: 2px solid transparent;
            position: relative;
            overflow: hidden;
        }

        .competition-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.15);
        }

        .competition-card.verified {
            border-left: 4px solid #28a745;
        }

        .competition-card.verified:hover {
            border-color: #28a745;
        }

        .competition-card.unverified {
            border-left: 4px solid #ffc107;
            background-color: #fffef7;
        }

        .competition-card.unverified:hover {
            border-color: #ffc107;
        }

        .verification-badge {
            position: absolute;
            top: 15px;
            right: 15px;
            z-index: 10;
        }

        .date-status-badge {
            position: absolute;
            top: 15px;
            left: 15px;
            z-index: 10;
        }

        .card-img-container {
            height: 200px;
            overflow: hidden;
            position: relative;
        }

        .card-img-top {
            height: 100%;
            width: 100%;
            object-fit: cover;
            transition: transform 0.3s ease;
        }

        .competition-card:hover .card-img-top {
            transform: scale(1.05);
        }

        .default-poster {
            height: 100%;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            background: linear-gradient(45deg, #f8f9fa, #e9ecef);
            text-align: center;
            padding: 20px;
        }

        .competition-info {
            margin-bottom: 1rem;
        }

        .competition-info p {
            font-size: 0.9rem;
            margin-bottom: 0.5rem;
        }

        .badges-container {
            margin-bottom: 1rem;
        }

        .badges-container .badge {
            font-size: 0.75rem;
            margin-right: 0.5rem;
            margin-bottom: 0.5rem;
        }

        .empty-state {
            padding: 3rem 1rem;
        }

        .form-group label {
            font-size: 0.9rem;
            color: #495057;
            margin-bottom: 0.5rem;
        }

        .input-group-text {
            border: none;
        }

        .btn {
            font-weight: 500;
        }

        @media (max-width: 768px) {

            .verification-badge,
            .date-status-badge {
                top: 10px;
            }

            .verification-badge {
                right: 10px;
            }

            .date-status-badge {
                left: 10px;
            }

            .card-img-container {
                height: 150px;
            }

            .badges-container .badge {
                font-size: 0.7rem;
            }
        }

        .overlay-poster {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(248, 249, 250, 0.8) !important;
            z-index: 2;
            opacity: 0;
            transition: opacity 0.2s ease;
        }

        .competition-card:hover .overlay-poster {
            opacity: 1;
        }

        .default-poster {
            height: 100%;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            background: linear-gradient(45deg, #f8f9fa, #e9ecef);
            text-align: center;
            padding: 20px;
        }
    </style>
@endpush

@push('js')
    <script>
        $(document).ready(function() {
            // Initialize filters
            updateResultCount();

            // Search functionality
            $('#searchInput').on('input', debounce(filterAndSort, 300));

            // Filter functionality
            $('#statusFilter, #categoryFilter, #dateFilter, #sortFilter').on('change', filterAndSort);
        });

        // Debounce function for search
        function debounce(func, wait) {
            let timeout;
            return function executedFunction(...args) {
                const later = () => {
                    clearTimeout(timeout);
                    func(...args);
                };
                clearTimeout(timeout);
                timeout = setTimeout(later, wait);
            };
        }

        // Main filter and sort function
        function filterAndSort() {
            const searchTerm = $('#searchInput').val().toLowerCase();
            const statusFilter = $('#statusFilter').val();
            const categoryFilter = $('#categoryFilter').val();
            const dateFilter = $('#dateFilter').val();
            const sortFilter = $('#sortFilter').val();

            let visibleItems = [];
            const today = new Date();

            $('.lomba-item').each(function() {
                const $item = $(this);
                const name = $item.data('name');
                const status = $item.data('status');
                const category = $item.data('category');
                const startDate = new Date($item.data('date-start'));
                const endDate = new Date($item.data('date-end'));

                let show = true;

                // Search filter
                if (searchTerm && !name.includes(searchTerm)) {
                    show = false;
                }

                // Status filter
                if (statusFilter && status !== statusFilter) {
                    show = false;
                }

                // Category filter
                if (categoryFilter && category !== categoryFilter) {
                    show = false;
                }

                // Date filter
                if (dateFilter) {
                    if (dateFilter === 'upcoming' && today >= startDate) {
                        show = false;
                    } else if (dateFilter === 'ongoing' && (today < startDate || today > endDate)) {
                        show = false;
                    } else if (dateFilter === 'finished' && today <= endDate) {
                        show = false;
                    }
                }

                if (show) {
                    visibleItems.push($item);
                    $item.show();
                } else {
                    $item.hide();
                }
            });

            // Sort visible items
            if (visibleItems.length > 0) {
                sortItems(visibleItems, sortFilter);
            }

            updateResultCount();
            toggleNoResults(visibleItems.length === 0);
        }

        // Sort items function
        function sortItems(items, sortType) {
            const container = $('#lombaContainer');

            items.sort(function(a, b) {
                const $a = $(a);
                const $b = $(b);

                switch (sortType) {
                    case 'newest':
                        return new Date($b.data('created')) - new Date($a.data('created'));
                    case 'oldest':
                        return new Date($a.data('created')) - new Date($b.data('created'));
                    case 'name_asc':
                        return $a.data('name').localeCompare($b.data('name'));
                    case 'name_desc':
                        return $b.data('name').localeCompare($a.data('name'));
                    case 'date_start':
                        return new Date($a.data('date-start')) - new Date($b.data('date-start'));
                    default:
                        return 0;
                }
            });

            // Reorder items in DOM
            items.forEach(item => {
                container.append(item);
            });
        }

        // Update result count
        function updateResultCount() {
            const visible = $('.lomba-item:visible').length;
            const total = $('.lomba-item').length;
            $('#resultCount').text(`Menampilkan ${visible} dari ${total} lomba`);
        }

        // Toggle no results message
        function toggleNoResults(show) {
            if (show) {
                $('#lombaContainer').hide();
                $('#noResults').show();
            } else {
                $('#lombaContainer').show();
                $('#noResults').hide();
            }
        }

        // Clear all filters
        function clearFilters() {
            $('#searchInput').val('');
            $('#statusFilter').val('');
            $('#categoryFilter').val('');
            $('#dateFilter').val('');
            $('#sortFilter').val('newest');

            $('.lomba-item').show();
            updateResultCount();
            toggleNoResults(false);
        }

        // View competition detail
        function viewCompetitionDetail(lombaId) {
            window.location.href = `{{ route('dosen.lomba.show', '') }}/${lombaId}`;
        }

        // Show new competition form
        function showNewCompetitionForm() {
            $('#newCompetitionModal').modal('show');
            setTimeout(() => {
                document.getElementById('topicsInput').focus();
            }, 300);
        }

        // Available keahlian data
        const availableKeahlians = @json(\App\Models\Keahlian::where('keahlian_visible', true)->get(['id', 'keahlian_nama']));
        let selectedKeahlians = [];
        let currentIndex = -1;

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
                    if (e.target.value === '' && selectedKeahlian.length > 0) {
                        removeKeahlian(selectedKeahlian.length - 1);
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
                emptyItem.className = 'dropdown-item';
                emptyItem.innerHTML = '<i class="fas fa-search mr-2"></i>Tidak ada hasil ditemukan';
                emptyItem.style.cursor = 'default';
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
                url: '{{ route('dosen.achievement.store') }}',
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
                        text: 'Lomba berhasil diajukan dan akan segera ditambahkan ke daftar.',
                        confirmButtonColor: '#102044',
                        showClass: {
                            popup: 'animate__animated animate__bounceIn'
                        }
                    }).then(() => {
                        $('#newCompetitionModal').modal('hide');
                        // Reload the page to show the new competition
                        window.location.reload();
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
