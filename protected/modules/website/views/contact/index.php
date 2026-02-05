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

    <?php if (!empty($settingItems)): ?>
        <div class="card mb-4">
            <div class="card-body py-2">

                <h5 class="mb-3">Contact Website</h5>

                <?php foreach ($settingItems as $item): ?>
                    <div class="row align-items-center border-top py-2">

                        <!-- Label -->
                        <div class="col-md-3 fw-bold">
                            <?= $settingLabels[$item->key] ?? $item->key ?>
                        </div>

                        <div class="col-md-4">
                            <?php if ($item->key === 'map'): ?>
                                <div class="ratio ratio-16x9">
                                    <iframe
                                            src="<?= CHtml::encode($item->value) ?>"
                                            style="border:0;"
                                            allowfullscreen=""
                                            loading="lazy"
                                            referrerpolicy="no-referrer-when-downgrade">
                                    </iframe>
                                </div>
                            <?php else: ?>
                                <?= CHtml::encode($item->value) ?>
                            <?php endif; ?>
                        </div>

                        <!-- Action -->
                        <div class="col-md-2 text-end">
                            <?php if (AuthHelper::can('WEBSITE|CONTACT|CREATE')): ?>
                                <a href="<?= $this->createUrl('updateSetting', ['type'=>$item->key]) ?>"
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