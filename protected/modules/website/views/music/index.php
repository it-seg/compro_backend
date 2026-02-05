<style>
    .carousel-admin-card {
        aspect-ratio: 3 / 4;   /* portrait */
        width: 100%;
        overflow: hidden;
    }

    .carousel-admin-card img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

</style>
<div class="container mt-3">

    <?php if (Yii::app()->user->hasFlash('success')): ?>
        <div class="alert alert-success"><?php echo Yii::app()->user->getFlash('success'); ?></div>
    <?php endif; ?>

    <h3 class="mb-3">Galery Images</h3>
    <?php if (AuthHelper::can('WEBSITE|GALLERY|CREATE')): ?>
        <a href="<?= $this->createUrl('create') ?>" class="btn btn-primary mb-3">
            <i class="bi bi-plus-circle"></i> Add More Images
        </a>
    <?php endif; ?>

    <div class="row">
        <?php foreach ($images as $img): ?>
            <div class="col-md-3 col-sm-4 col-6 mb-3">
                <div class="card position-relative carousel-admin-card">
                    <?php if (AuthHelper::can('WEBSITE|GALLERY|DELETE')): ?>
                        <a href="<?= $this->createUrl('deleteImage', ['file' => $img['name']]) ?>"
                           class="btn btn-danger btn-sm position-absolute"
                           style="top:6px;right:6px;z-index:2"
                           onclick="return confirm('Hapus gambar ini?')">
                            ✕
                        </a>
                    <?php endif; ?>

                    <img src="<?= $img['url'] ?>" class="rounded">
                </div>
            </div>
        <?php endforeach; ?>
    </div>





</div>