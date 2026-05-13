<style>
    .gallery-admin-card {
        aspect-ratio: 3 / 4;
        width: 100%;
        overflow: hidden;
        border-radius: 14px;
        border: 0;
        box-shadow: 0 4px 14px rgba(0,0,0,0.06);
        background: #fff;
        transition: .2s ease;
    }

    .gallery-admin-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(0,0,0,0.08);
    }

    .gallery-admin-card img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .gallery-header {
        border-left: 4px solid #0d6efd;
        background: #f8f9fa;
        border-radius: 10px;
        padding: 12px 16px;
        margin-bottom: 18px;
    }

    .gallery-header h5 {
        margin: 0;
        font-weight: 700;
        font-size: 18px;
        color: #212529;
    }

    .gallery-header p {
        margin: 3px 0 0;
        font-size: 12px;
        color: #6c757d;
    }

    .gallery-toolbar {
        margin-bottom: 18px;
    }

    .gallery-toolbar .btn {
        border-radius: 10px;
        font-weight: 600;
        padding: 8px 14px;
        font-size: 13px;
    }

    .gallery-empty {
        border: 1px dashed #ced4da;
        border-radius: 14px;
        padding: 50px 20px;
        text-align: center;
        background: #fafafa;
    }

    .gallery-empty-icon {
        font-size: 40px;
        margin-bottom: 10px;
    }

    .gallery-empty-title {
        font-size: 15px;
        font-weight: 700;
        margin-bottom: 4px;
        color: #212529;
    }

    .gallery-empty-subtitle {
        font-size: 12px;
        color: #6c757d;
    }

    .gallery-delete-btn {
        border-radius: 8px;
        padding: 4px 8px;
        font-size: 11px;
        font-weight: 600;
        backdrop-filter: blur(4px);
    }
</style>

<div class="container mt-3">

    <?php if (Yii::app()->user->hasFlash('success')): ?>
        <div class="alert alert-success">
            <?php echo Yii::app()->user->getFlash('success'); ?>
        </div>
    <?php endif; ?>

    <!-- HEADER -->
    <div class="gallery-header">

        <h5>
            Kelola Gallery Website
        </h5>

        <p>
            Upload dan kelola gallery image website.
        </p>

    </div>

    <!-- TOOLBAR -->
    <div class="gallery-toolbar">

        <?php if (AuthHelper::can('WEBSITE|MUSIC|CREATE')): ?>

            <a href="<?= $this->createUrl('create') ?>"
               class="btn btn-primary">

                <i class="bi bi-plus-circle"></i>
                Add More Images

            </a>

        <?php endif; ?>

    </div>

    <!-- IMAGE LIST -->
    <?php if (!empty($images)): ?>

        <div class="row">

            <?php foreach ($images as $img): ?>

                <div class="col-md-3 col-sm-4 col-6 mb-3">

                    <div class="card position-relative gallery-admin-card">

                        <?php if (AuthHelper::can('WEBSITE|MUSIC|DELETE')): ?>

                            <a href="<?= $this->createUrl('deleteImage', ['file' => $img['name']]) ?>"
                               class="btn btn-danger btn-sm position-absolute gallery-delete-btn"
                               style="top:8px;right:8px;z-index:2"
                               onclick="return confirm('Hapus gambar ini?')">

                                ✕

                            </a>

                        <?php endif; ?>

                        <img src="<?= $img['url'] ?>" class="rounded">

                    </div>

                </div>

            <?php endforeach; ?>

        </div>

    <?php else: ?>

        <!-- EMPTY STATE -->
        <div class="gallery-empty">

            <div class="gallery-empty-icon">
                🖼️
            </div>

            <div class="gallery-empty-title">
                Gallery Masih Kosong
            </div>

            <div class="gallery-empty-subtitle">
                Upload gambar pertama untuk mulai membuat gallery website.
            </div>

        </div>

    <?php endif; ?>

</div>