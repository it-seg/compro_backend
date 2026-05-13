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
        width: 100%;
        height: 120px;
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

    <div class="mb-3 border-start border-4 ps-3 py-2 bg-light rounded">
        <h5 class="mb-0 fw-semibold">
            Kelola Carousel Website
        </h5>
    </div>
    <hr>
    <div class="row">

        <!-- LEFT : IMAGE LIST -->
        <div class="col-md-4">

            <h6 class="fw-bold mb-3">
                Carousel Images
            </h6>

            <div class="row g-2">

                <?php foreach ($images as $img): ?>

                    <div class="col-6 mb-2">

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

            <div class="mt-3">
                <?php if (AuthHelper::can('WEBSITE|CAROUSEL|CREATE')): ?>
                    <a href="<?= $this->createUrl('create') ?>"
                       class="btn btn-primary">
                        <i class="bi bi-plus-circle"></i>
                        Add More Images
                    </a>
                <?php endif; ?>
            </div>

        </div>



        <!-- RIGHT : LIVE PREVIEW -->
        <div class="col-md-8">

            <div class="position-relative">

                <!-- floating title -->
                <div class="position-absolute px-3 py-1 rounded"
                     style="
                    top:15px;
                    left:15px;
                    z-index:10;
                    background:rgba(0,0,0,.55);
                    color:#fff;
                    font-weight:600;
                    backdrop-filter:blur(4px);
                 ">
                    Live Preview
                </div>

                <?php
                $runningText = '';

                foreach ($carouselItems as $item) {

                    $isActive = true;

                    if (isset($item->is_active)) {
                        if ($item->is_active === '0' || $item->is_active === 0) {
                            $isActive = false;
                        }
                    }

                    if ($item->type === 'running_text' && $isActive) {
                        $runningText = $item->content;
                        break;
                    }
                }
                ?>

                <div id="websiteCarouselPreview"
                     class="carousel slide"
                     data-bs-ride="carousel"
                     data-bs-interval="1500">

                    <!-- indicators -->
                    <div class="carousel-indicators">
                        <?php foreach ($images as $i => $img): ?>
                            <button type="button"
                                    data-bs-target="#websiteCarouselPreview"
                                    data-bs-slide-to="<?= $i ?>"
                                    class="<?= $i === 0 ? 'active' : '' ?>">
                            </button>
                        <?php endforeach; ?>
                    </div>

                    <!-- slides -->
                    <div class="carousel-inner rounded overflow-hidden">

                        <?php foreach ($images as $i => $img): ?>
                            <div class="carousel-item <?= $i === 0 ? 'active' : '' ?>">

                                <img src="<?= $img['url'] ?>"
                                     class="d-block w-100"
                                     style="height:420px;object-fit:cover;">

                            </div>
                        <?php endforeach; ?>

                    </div>

                    <!-- prev -->
                    <button class="carousel-control-prev"
                            type="button"
                            data-bs-target="#websiteCarouselPreview"
                            data-bs-slide="prev">

                        <span class="carousel-control-prev-icon"></span>
                    </button>

                    <!-- next -->
                    <button class="carousel-control-next"
                            type="button"
                            data-bs-target="#websiteCarouselPreview"
                            data-bs-slide="next">

                        <span class="carousel-control-next-icon"></span>
                    </button>

                </div>

                <!-- RUNING TEXT -->
                <?php if (!empty($runningText)): ?>

                    <div class="position-absolute w-100"
                         style="
            bottom:0;
            left:0;
            z-index:9;
            background:rgba(0,0,0,.78);
            color:#fff;
            overflow:hidden;
            height:42px;
            display:flex;
            align-items:center;
            white-space:nowrap;
         ">

                        <marquee behavior="scroll"
                                 direction="left"
                                 scrollamount="5"
                                 scrolldelay="20"
                                 style="
                    font-size:15px;
                    font-weight:500;
                    letter-spacing:3px;
                    text-transform:uppercase;
                 ">

                            <?= CHtml::encode($runningText) ?>
                            &nbsp;&nbsp;&nbsp;&nbsp;

                            <?= CHtml::encode($runningText) ?>
                            &nbsp;&nbsp;&nbsp;&nbsp;

                            <?= CHtml::encode($runningText) ?>

                        </marquee>

                    </div>

                <?php endif; ?>

            </div>



        </div>



    </div>

    <hr>

    <?php if (!empty($carouselItems)): ?>
        <div class="card mb-3">
            <div class="card-body p-2 small">

                <h5 class="mb-3">Carousel Content</h5>

                <?php foreach ($carouselItems as $item): ?>
                    <div class="row align-items-center border-top py-1">

                        <!-- Label -->
                        <div class="col-md-2 fw-bold small">
                            <?= $carouselLabels[$item->type] ?? $item->type ?>
                        </div>

                        <!-- Bahasa ID -->
                        <div class="col-md-3">
                            <small class="text-muted">ID</small><br>
                            <?= CHtml::encode($item->content) ?>
                        </div>

                        <!-- Bahasa EN -->
                        <div class="col-md-3">
                            <small class="text-muted">EN</small><br>
                            <?= CHtml::encode($item->content_english) ?>
                        </div>

                        <!-- Status -->
                        <div class="col-md-2">
                            <small class="text-muted">Status</small><br>
                            <?php
                            $isActive = true;
                            if (isset($item->is_active)) {
                                if ($item->is_active === '0' || $item->is_active === 0) {
                                    $isActive = false;
                                }
                            }
                            ?>

                            <?php if ($isActive): ?>
                                <span class="badge bg-success">Active</span>
                            <?php else: ?>
                                <span class="badge bg-secondary">Non Active</span>
                            <?php endif; ?>
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