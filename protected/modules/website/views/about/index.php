<?php

function aboutPreview($html, $limit = 160)
{
    $text = trim(strip_tags($html));
    if (mb_strlen($text) > $limit) {
        return mb_substr($text, 0, $limit) . '…';
    }
    return $text;
}


$aboutLabels = [
    'about_title' => 'About Title',
    'about_sub_title' => 'About Sub Title',
    'about_button' => 'About Button Text',
    'about_value_p1' => 'About Value Point 1',
    'about_value_p2' => 'About Value Point 2',
];
?>
<style>
    .about-admin-card {
        height: 190px;
    }

    .about-admin-card img {
        height: 100%;
        width: 100%;
        object-fit: cover;
    }

</style>
<div class="container mt-3">

    <?php if (Yii::app()->user->hasFlash('success')): ?>
        <div class="alert alert-success"><?php echo Yii::app()->user->getFlash('success'); ?></div>
    <?php endif; ?>

    <h3 class="mb-3">About Page Website</h3>

    <div class="row">
        <?php foreach ($images as $img): ?>
            <div class="col-md-3 col-sm-4 col-6 mb-3">
                <div class="card position-relative about-admin-card">

                    <?php if ($img['name'] === 'cover.jpg'): ?>
                        <span class="badge bg-success position-absolute"
                              style="top:6px;left:6px;z-index:2">
                        COVER
                    </span>
                    <?php endif; ?>

                    <?php if (AuthHelper::can('WEBSITE|ABOUT|DELETE')): ?>
                        <a href="<?= $this->createUrl('deleteImage', ['file' => $img['name']]) ?>"
                           class="btn btn-danger btn-sm position-absolute"
                           style="top:6px;right:6px;z-index:2"
                           onclick="return confirm('Hapus gambar ini?')">
                            ✕
                        </a>
                    <?php endif; ?>

                    <?php if ($img['name'] !== 'cover.jpg'): ?>
                        <a href="<?= $this->createUrl('setCover', ['file' => $img['name']]) ?>"
                           class="btn btn-dark btn-sm position-absolute"
                           style="bottom:6px;right:6px;z-index:2">
                            Set Cover
                        </a>
                    <?php endif; ?>

                    <img src="<?= $img['url'] ?>" class="rounded">
                </div>
            </div>
        <?php endforeach; ?>
    </div>


    <?php if (AuthHelper::can('WEBSITE|ABOUT|CREATE')): ?>
        <a href="<?= $this->createUrl('create') ?>" class="btn btn-primary mb-3">
            <i class="bi bi-plus-circle"></i> Add More Images
        </a>
    <?php endif; ?>

    <hr class="my-4">

    <h4 class="mb-3">Logo Website</h4>

    <?php if ($logoImage): ?>
        <div class="row">
            <div class="col-md-4 col-sm-6 col-12">
                <div class="card logo-card position-relative">
                    <?php if (AuthHelper::can('WEBSITE|ABOUT|CREATE')): ?>
                        <form action="<?= $this->createUrl('replaceLogo') ?>"
                              method="post"
                              enctype="multipart/form-data"
                              class="position-absolute"
                              style="bottom:8px;right:8px;z-index:2">

                            <label class="btn btn-sm btn-warning mb-0">
                                Ganti Logo
                                <input type="file"
                                       name="logo"
                                       accept="image/*"
                                       hidden
                                       onchange="this.form.submit()">
                            </label>
                        </form>
                    <?php endif; ?>


                    <span class="badge bg-info position-absolute"
                      style="top:8px;left:8px;z-index:2">
                    LOGO
                </span>

                    <img src="<?= $logoImage['url'] ?>" alt="Website Logo">
                </div>
            </div>
        </div>
    <?php endif; ?>

    <hr>

    <?php if (!empty($aboutItems)): ?>
        <div class="card mb-4">
            <div class="card-body py-2">

                <h5 class="mb-3">About Content</h5>

                <?php foreach ($aboutItems as $item): ?>
                    <div class="row align-items-center border-top py-2">

                        <!-- Label -->
                        <div class="col-md-2 fw-bold">
                            <?= $aboutLabels[$item->type] ?? $item->type ?>
                        </div>

                        <!-- Bahasa ID -->
                        <div class="col-md-4">
                            <small class="text-muted">ID</small><br>
                            <?php if (in_array($item->type, ['about_value_p1', 'about_value_p2'])): ?>
                                <?= CHtml::encode(aboutPreview($item->content)) ?>
                            <?php else: ?>
                                <?= CHtml::encode($item->content) ?>
                            <?php endif; ?>
                        </div>

                        <!-- Bahasa EN -->
                        <div class="col-md-4">
                            <small class="text-muted">EN</small><br>
                            <?php if (in_array($item->type, ['about_value_p1', 'about_value_p2'])): ?>
                                <?= CHtml::encode(aboutPreview($item->content_english)) ?>
                            <?php else: ?>
                                <?= CHtml::encode($item->content_english) ?>
                            <?php endif; ?>
                        </div>

                        <!-- Action -->
                        <div class="col-md-2 text-end">
                            <?php if (AuthHelper::can('WEBSITE|ABOUT|CREATE')): ?>
                                <a href="<?= $this->createUrl('updateHeader', ['type' => $item->type]) ?>"
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