<?php

function aboutPreview($html, $limit = 120)
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
        width: 100%;
        height: 240px;
    }

    .about-admin-card img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .logo-card {
        background: linear-gradient(145deg, #f8f8f8, #eeeeee);
        border-radius: 10px;
        padding: 10px;
        min-height: 120px;
        position: relative;
    }

    .logo-card img {
        max-height: 70px;
        width: auto;
        max-width: 100%;
        display: block;
        margin: auto;
        object-fit: contain;
    }
</style>

<div class="container mt-3">

    <?php if (Yii::app()->user->hasFlash('success')): ?>
        <div class="alert alert-success">
            <?php echo Yii::app()->user->getFlash('success'); ?>
        </div>
    <?php endif; ?>

    <div class="mb-3 border-start border-4 ps-3 py-2 bg-light rounded">
        <h5 class="mb-0 fw-semibold">
            Kelola About Website
        </h5>
    </div>

    <hr>

    <!-- ABOUT IMAGES -->
    <div class="row">

        <div class="col-md-12">

            <h6 class="fw-bold mb-3">
                About Images
            </h6>

            <div class="row g-2">

                <?php foreach ($images as $img): ?>

                    <div class="col-md-2 col-6 mb-2">

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

            <div class="mt-3">

                <?php if (AuthHelper::can('WEBSITE|ABOUT|CREATE')): ?>

                    <a href="<?= $this->createUrl('create') ?>"
                       class="btn btn-success">

                        <i class="bi bi-plus-circle"></i>
                        Add More Images

                    </a>

                <?php endif; ?>

            </div>

        </div>

    </div>

    <hr>

    <!-- LOGO -->
    <div class="row">

        <div class="col-md-12">

            <h6 class="fw-bold mb-3">
                Website Logo
            </h6>

            <div class="row g-2">

                <?php if ($logoImage): ?>

                    <div class="col-md-2 col-6">

                        <div class="card logo-card">

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

                            <img src="<?= $logoImage['url'] . '?v=' . time() ?>">

                        </div>

                    </div>

                <?php endif; ?>

                <?php if ($logoImageFooter): ?>

                    <div class="col-md-2 col-6">

                        <div class="card logo-card">

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

                            <span class="badge bg-dark position-absolute"
                                  style="top:6px;left:6px;z-index:2">

                                FOOTER

                            </span>

                            <img src="<?= $logoImageFooter['url'] . '?v=' . time() ?>">

                        </div>

                    </div>

                <?php endif; ?>

            </div>

        </div>

    </div>

    <hr>

    <!-- ABOUT CONTENT -->
    <?php if (!empty($aboutItems)): ?>

        <div class="card mb-3">

            <div class="card-body p-2 small">

                <h5 class="mb-3">
                    About Content
                </h5>

                <?php foreach ($aboutItems as $item): ?>

                    <?php
                    $isActive = true;

                    if (isset($item->is_active)) {
                        if ($item->is_active === '0' || $item->is_active === 0) {
                            $isActive = false;
                        }
                    }
                    ?>

                    <div class="row align-items-center border-top py-2">

                        <!-- LABEL -->
                        <div class="col-md-2 fw-bold small">

                            <?= $aboutLabels[$item->type] ?? $item->type ?>

                        </div>

                        <!-- ID -->
                        <div class="col-md-3">

                            <small class="text-muted">
                                ID
                            </small>

                            <br>

                            <?php if (in_array($item->type, ['about_value_p1', 'about_value_p2'])): ?>

                                <?= CHtml::encode(aboutPreview($item->content)) ?>

                            <?php else: ?>

                                <?= CHtml::encode($item->content) ?>

                            <?php endif; ?>

                        </div>

                        <!-- EN -->
                        <div class="col-md-3">

                            <small class="text-muted">
                                EN
                            </small>

                            <br>

                            <?php if (in_array($item->type, ['about_value_p1', 'about_value_p2'])): ?>

                                <?= CHtml::encode(aboutPreview($item->content_english)) ?>

                            <?php else: ?>

                                <?= CHtml::encode($item->content_english) ?>

                            <?php endif; ?>

                        </div>

                        <!-- STATUS -->
                        <div class="col-md-2">

                            <small class="text-muted">
                                Status
                            </small>

                            <br>

                            <?php if ($isActive): ?>

                                <span class="badge bg-success">
                                    Active
                                </span>

                            <?php else: ?>

                                <span class="badge bg-secondary">
                                    Non Active
                                </span>

                            <?php endif; ?>

                        </div>

                        <!-- ACTION -->
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