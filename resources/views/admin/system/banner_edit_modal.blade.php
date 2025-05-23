<div class="modal-dialog" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">Edit Banner</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <form action="{{ route('admin.system.updateBanner', $banner->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="modal-body">
                <div class="form-group">
                    <label for="banner_nama">Nama Banner</label>
                    <input type="text" class="form-control" id="banner_nama" name="banner_nama" value="{{ $banner->banner_nama }}" required>
                </div>
                <div class="form-group">
                    <label for="banner_link">Link</label>
                    <input type="text" class="form-control" id="banner_link" name="banner_link" value="{{ $banner->banner_link }}" required>
                </div>
                <div class="form-group">
                    <label for="banner_gambar">Gambar Banner</label>
                    <div class="custom-file">
                        <input type="file" class="custom-file-input" id="banner_gambar" name="banner_gambar" accept="image/*">
                        <label class="custom-file-label" for="banner_gambar">Pilih file baru...</label>
                    </div>
                    <small class="form-text text-muted">Format: JPG, PNG. Max: 2MB. Biarkan kosong jika tidak ingin mengubah gambar.</small>
                    @if($banner->banner_gambar)
                        <div class="mt-2 text-center">
                            <p class="mb-1">Gambar Saat Ini:</p>
                            <img src="{{ asset('storage/' . $banner->banner_gambar) }}" alt="{{ $banner->banner_nama }}" class="img-thumbnail" style="max-height: 150px;">
                        </div>
                    @endif
                    <div class="mt-2">
                        <img id="preview-edit-image" src="#" alt="Preview" style="max-height: 150px; display: none;">
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
            </div>
        </form>
    </div>
</div>

<script>
    $(document).ready(function() {
        // Preview image before upload
        $('#banner_gambar').change(function() {
            const file = this.files[0];
            if (file) {
                let reader = new FileReader();
                reader.onload = function(event) {
                    $('#preview-edit-image').attr('src', event.target.result);
                    $('#preview-edit-image').css('display', 'block');
                }
                reader.readAsDataURL(file);
            }
        });
    });
</script>