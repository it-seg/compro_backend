<h4>About Images</h4>
<hr>

<form method="post" enctype="multipart/form-data">
    <div class="mb-3">
        <label class="form-label">Upload Gambar</label>
        <input type="file" name="image" class="form-control" required accept="image/*">
    </div>

    <button class="btn btn-primary">Upload</button>
    <a href="<?= $this->createUrl('index') ?>" class="btn btn-secondary">Kembali</a>
</form>
