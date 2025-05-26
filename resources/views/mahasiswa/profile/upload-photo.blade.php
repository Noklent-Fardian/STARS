<!-- Modal Upload Foto Profil -->
<div class="modal fade" id="modalPhoto" tabindex="-1" aria-labelledby="modalPhotoLabel" aria-hidden="true">
  <div class="modal-dialog">
    <form action="{{ route('mahasiswa.updatePhoto') }}" method="POST" enctype="multipart/form-data" class="modal-content" id="form-photo">
      @csrf
      <div class="modal-header">
        <h5 class="modal-title" id="modalPhotoLabel">Ganti Foto Profil</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <input type="file" name="profile_picture" class="form-control" accept="image/jpeg,image/png,image/webp" required>
      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-primary">Upload</button>
      </div>
    </form>
  </div>
</div>