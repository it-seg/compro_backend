<?php

$carouselLabels = [
    'header'     => 'Header Title',
    'sub_header'     => 'Sub Title',
    'view_menus'    => 'Menu Button Title',
    'sub_view_menus'    => 'Menu Button Sub Title',
    'hero_reservation'    => 'Reservation Button Title',
    'sub_hero_reservation'    => 'Reservation Button Sub Title'

];
?>
<style>
    .carousel-admin-card {
        height: 190px;
    }

    .carousel-admin-card img {
        height: 100%;
        width: 100%;
        object-fit: cover;
    }

</style>
<div class="container mt-3">

    <?php if (Yii::app()->user->hasFlash('success')): ?>
        <div class="alert alert-success"><?php echo Yii::app()->user->getFlash('success'); ?></div>
    <?php endif; ?>

    <h3 class="mb-3">Carousel Images Website</h3>

    <div class="row">
        <?php foreach ($images as $img): ?>
            <div class="col-md-3 col-sm-4 col-6 mb-3">
                <div class="card position-relative carousel-admin-card">

                    <?php if ($img['name'] === 'cover.jpg'): ?>
                        <span class="badge bg-success position-absolute"
                              style="top:6px;left:6px;z-index:2">
                        COVER
                    </span>
                    <?php endif; ?>

                    <?php if (AuthHelper::can('WEBSITE|CAROUSEL|DELETE')): ?>
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



    <?php if (AuthHelper::can('WEBSITE|CAROUSEL|CREATE')): ?>
        <a href="<?= $this->createUrl('create') ?>" class="btn btn-primary mb-3">
            <i class="bi bi-plus-circle"></i> Add More Images
        </a>
    <?php endif; ?>

    <?php if (!empty($carouselItems)): ?>
        <div class="card mb-4">
            <div class="card-body py-2">

                <h5 class="mb-3">Carousel Content</h5>

                <?php foreach ($carouselItems as $item): ?>
                    <div class="row align-items-center border-top py-2">

                        <!-- Label -->
                        <div class="col-md-2 fw-bold">
                            <?= $carouselLabels[$item->type] ?? $item->type ?>
                        </div>

                        <!-- Bahasa ID -->
                        <div class="col-md-4">
                            <small class="text-muted">ID</small><br>
                            <?= CHtml::encode($item->content) ?>
                        </div>

                        <!-- Bahasa EN -->
                        <div class="col-md-4">
                            <small class="text-muted">EN</small><br>
                            <?= CHtml::encode($item->content_english) ?>
                        </div>

                        <!-- Action -->
                        <div class="col-md-2 text-end">
                            <?php if (AuthHelper::can('WEBSITE|CAROUSEL|CREATE')): ?>
                                <a href="<?= $this->createUrl('updateHeader', ['type'=>$item->type]) ?>"
                                   class="btn btn-sm btn-warning">
                                    Edit
                                </a>
                            <?php endif; ?>
                        </div>

                    </div>
                <?php endforeach; ?>

            </div>
        </div>
    <?php endif; ?>





</div>