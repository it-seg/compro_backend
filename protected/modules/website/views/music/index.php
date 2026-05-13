<style>
    .music-admin-card {
        aspect-ratio: 3 / 4;
        width: 100%;
        overflow: hidden;
        border-radius: 14px;
        border: 0;
        box-shadow: 0 4px 14px rgba(0,0,0,0.06);
        background: #fff;
        transition: .2s ease;
    }

    .music-admin-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(0,0,0,0.08);
    }

    .music-admin-card img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .music-header {
        border-left: 4px solid #6610f2;
        background: #f8f9fa;
        border-radius: 10px;
        padding: 12px 16px;
        margin-bottom: 18px;
    }

    .music-header h5 {
        margin: 0;
        font-weight: 700;
        font-size: 18px;
        color: #212529;
    }

    .music-header p {
        margin: 3px 0 0;
        font-size: 12px;
        color: #6c757d;
    }

    .music-toolbar {
        margin-bottom: 18px;
    }

    .music-toolbar .btn {
        border-radius: 10px;
        font-weight: 600;
        padding: 8px 14px;
        font-size: 13px;
    }

    .music-empty {
        border: 1px dashed #ced4da;
        border-radius: 14px;
        padding: 50px 20px;
        text-align: center;
        background: #fafafa;
    }

    .music-empty-icon {
        font-size: 40px;
        margin-bottom: 10px;
    }

    .music-empty-title {
        font-size: 15px;
        font-weight: 700;
        margin-bottom: 4px;
        color: #212529;
    }

    .music-empty-subtitle {
        font-size: 12px;
        color: #6c757d;
    }

    .music-delete-btn {
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
    <div class="music-header">

        <h5>
            Kelola Music Website
        </h5>

        <p>
            Upload dan kelola music cover image website.
        </p>

    </div>

    <!-- TOOLBAR -->
    <div class="music-toolbar">

        <?php if (AuthHelper::can('WEBSITE|GALLERY|CREATE')): ?>

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

                    <div class="card position-relative music-admin-card">

                        <?php if (AuthHelper::can('WEBSITE|GALLERY|DELETE')): ?>

                            <a href="<?= $this->createUrl('deleteImage', ['file' => $img['name']]) ?>"
                               class="btn btn-danger btn-sm position-absolute music-delete-btn"
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
        <div class="music-empty">

            <div class="music-empty-icon">
                🎵
            </div>

            <div class="music-empty-title">
                Music Gallery Masih Kosong
            </div>

            <div class="music-empty-subtitle">
                Upload gambar pertama untuk music section website.
            </div>

        </div>

    <?php endif; ?>

</div>