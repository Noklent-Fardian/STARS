<div class="modal fade" id="newCompetitionModal" tabindex="-1" role="dialog" aria-labelledby="newCompetitionModalLabel">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-gradient-primary text-white">
                <h5 class="modal-title" id="newCompetitionModalLabel">
                    <i class="fas fa-plus-circle mr-2"></i>Ajukan Lomba Baru (Mahasiswa)
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
                                <label><i class="fas fa-trophy mr-1"></i>Nama Lomba <span class="text-danger">*</span></label>
                                <input type="text" name="lomba_nama" class="form-control" required>
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label><i class="fas fa-building mr-1"></i>Penyelenggara <span class="text-danger">*</span></label>
                                <input type="text" name="lomba_penyelenggara" class="form-control" required>
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label><i class="fas fa-tag mr-1"></i>Kategori Lomba <span class="text-danger">*</span></label>
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
                                <label><i class="fas fa-layer-group mr-1"></i>Tingkatan Lomba <span class="text-danger">*</span></label>
                                <select name="lomba_tingkatan_id" class="form-control" required>
                                    <option value="">Pilih Tingkatan</option>
                                    @foreach(\App\Models\Tingkatan::where('tingkatan_visible', true)->get() as $tingkatan)
                                        <option value="{{ $tingkatan->id }}">{{ $tingkatan->tingkatan_nama }}</option>
                                    @endforeach
                                </select>
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label><i class="fas fa-code mr-1"></i>Bidang Keahlian <span class="text-danger">*</span></label>
                                <div class="github-topics-container">
                                    <div class="topics-input-wrapper">
                                        <div class="selected-topics" id="selectedTopics"></div>
                                        <input type="text" id="topicsInput" class="topics-input" placeholder="Ketik bidang keahlian..." autocomplete="off">
                                    </div>
                                    <div class="topics-dropdown" id="topicsDropdown">
                                        <div class="dropdown-content" id="dropdownContent"></div>
                                    </div>
                                </div>
                                <div id="hiddenKeahlianInputs"></div>
                                <small class="text-muted">
                                    <i class="fas fa-info-circle mr-1"></i>
                                    Ketik untuk mencari bidang keahlian. Tekan Enter untuk menambah bidang baru jika tidak ditemukan.
                                </small>
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label><i class="fas fa-calendar-alt mr-1"></i>Tanggal Mulai <span class="text-danger">*</span></label>
                                <input type="date" name="lomba_tanggal_mulai" class="form-control" required>
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label><i class="fas fa-calendar-check mr-1"></i>Tanggal Selesai <span class="text-danger">*</span></label>
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
                            <i class="fas fa-spinner fa-spin mr-1"></i>Memproses...
                        </span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
.bg-gradient-primary {
    background: linear-gradient(135deg, #102044, #1a365d) !important;
}

.github-topics-container {
    position: relative;
}

.topics-input-wrapper {
    border: 2px solid #e3e6f0;
    border-radius: 0.375rem;
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
    border-color: #102044;
    box-shadow: 0 0 0 0.2rem rgba(16, 32, 68, 0.25);
}

.selected-topics {
    display: flex;
    flex-wrap: wrap;
    gap: 8px;
}

.topic-tag {
    background: linear-gradient(135deg, #102044, #1a365d);
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
    border-radius: 0 0 0.375rem 0.375rem;
    max-height: 250px;
    overflow-y: auto;
    z-index: 1000;
    display: none;
    box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.15);
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
    background-color: #102044;
    color: white;
}

.dropdown-item.create-new {
    color: #28a745;
    font-weight: 600;
}

.dropdown-item.create-new:hover {
    background-color: #e8f5e8;
}

.invalid-feedback {
    display: none;
    width: 100%;
    margin-top: 0.25rem;
    font-size: 0.875rem;
    color: #dc3545;
}

.is-invalid ~ .invalid-feedback {
    display: block;
}

.is-invalid {
    border-color: #dc3545;
}

@media (max-width: 768px) {
    .topics-input {
        min-width: 100px;
    }
}
</style>