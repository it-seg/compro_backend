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
    .section-title {
        font-size: 18px;
        font-weight: 600;
        margin-bottom: 12px;
    }

    .about-admin-card {
        height: 130px;
        border-radius: 10px;
        overflow: hidden;
        border: 1px solid #eee;
    }

    .about-admin-card img {
        height: 100%;
        width: 100%;
        object-fit: cover;
    }

    .logo-card {
        background: linear-gradient(145deg, #f8f8f8, #eeeeee);
        border-radius: 10px;
        padding: 10px !important;
        box-shadow: 0 2px 6px rgba(0,0,0,0.05);
        min-height: 120px;
    }

    .logo-card img {
        max-height: 70px;
        width: auto;
        max-width: 100%;
        display: block;
        margin: auto;
        object-fit: contain;
    }

    .about-content-row {
        padding-top: 8px !important;
        padding-bottom: 8px !important;
        font-size: 13px;
    }

    .about-content-row .btn {
        padding: 3px 10px;
        font-size: 12px;
    }

    .badge {
        font-size: 10px;
    }

    .btn-sm {
        font-size: 11px;
        padding: 3px 8px;
    }

    .card-body {
        padding: 14px;
    }

    hr {
        margin-top: 18px;
        margin-bottom: 18px;
    }

    .text-muted {
        font-size: 11px;
    }
</style>

<div class="container mt-3">

    <?php if (Yii::app()->user->hasFlash('success')): ?>
        <div class="alert alert-success py-2 px-3">
            <?php echo Yii::app()->user->getFlash('success'); ?>
        </div>
    <?php endif; ?>

    <h3 class="section-title">About Page Website</h3>

    <div class="row">
        <?php foreach ($images as $img): ?>
            <div class="col-md-2 col-sm-3 col-6 mb-2">

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
        <a href="<?= $this->createUrl('create') ?>" class="btn btn-primary btn-sm mb-3">
            <i class="bi bi-plus-circle"></i> Add More Images
        </a>
    <?php endif; ?>

    <hr>

    <h4 class="section-title">Logo Website</h4>

    <div class="row">

        <?php if ($logoImage): ?>
            <div class="col-md-2 col-sm-4 col-6 mb-2">

                <div class="card logo-card position-relative">

                    <?php if (AuthHelper::can('WEBSITE|ABOUT|CREATE')): ?>
                        <form action="<?= $this->createUrl('replaceLogo') ?>"
                              method="post"
                              enctype="multipart/form-data"
                              class="position-absolute"
                              style="bottom:6px;right:6px;z-index:2">

                            <label class="btn btn-warning btn-sm mb-0">
                                Ganti
                                <input type="file"
                                       name="logo"
                                       accept="image/*"
                                       hidden
                                       onchange="this.form.submit()">
                            </label>

                        </form>
                    <?php endif; ?>

                    <span class="badge bg-info position-absolute"
                          style="top:6px;left:6px;z-index:2">
                        NAVBAR
                    </span>

                    <img src="<?= $logoImage['url'] . '?v=' . time() ?>"
                         alt="Website Logo">

                </div>

            </div>
        <?php endif; ?>


        <?php if ($logoImageFooter): ?>
            <div class="col-md-2 col-sm-4 col-6 mb-2">

                <div class="card logo-card position-relative">

                    <?php if (AuthHelper::can('WEBSITE|ABOUT|CREATE')): ?>
                        <form action="<?= $this->createUrl('replaceLogoFooter') ?>"
                              method="post"
                              enctype="multipart/form-data"
                              class="position-absolute"
                              style="bottom:6px;right:6px;z-index:2">

                            <label class="btn btn-warning btn-sm mb-0">
                                Ganti
                                <input type="file"
                                       name="logo_footer"
                                       accept="image/*"
                                       hidden
                                       onchange="this.form.submit()">
                            </label>

                        </form>
                    <?php endif; ?>

                    <span class="badge bg-info position-absolute"
                          style="top:6px;left:6px;z-index:2">
                        FOOTER
                    </span>

                    <img src="<?= $logoImageFooter['url'] . '?v=' . time() ?>"
                         alt="Website Footer Logo">

                </div>

            </div>
        <?php endif; ?>

    </div>

    <hr>

    <?php if (!empty($aboutItems)): ?>

        <div class="card mb-3">

            <div class="card-body py-2">

                <h5 class="section-title mb-2">About Content</h5>

                <?php foreach ($aboutItems as $item): ?>

                    <div class="row align-items-center border-top about-content-row">

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
                                   class="btn btn-warning btn-sm">
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