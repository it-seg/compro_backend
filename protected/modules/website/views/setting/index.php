<?php
$groups = [
    'About'   => ['about_bg_1', 'about_bg_2'],
    'Contact' => ['contact_bg_1', 'contact_bg_2'],
    'Event'   => ['event_bg_1', 'event_bg_2'],
    'Footer'  => ['footer_bg_1', 'footer_bg_2'],
    'Gallery' => ['gallery_bg_1', 'gallery_bg_2'],
    'Menu'    => ['menu_bg_1', 'menu_bg_2'],
    'Music'   => ['music_bg_1', 'music_bg_2'],
    'News'    => ['news_bg_1', 'news_bg_2'],
    'Space'   => ['space_bg_1', 'space_bg_2'],
];
?>

<div class="container mt-4">
    <h3 class="mb-4">Setting Color & Style Background</h3>

    <div class="row">
        <?php foreach ($groups as $title => $keys):
            $bg1 = isset($settings[$keys[0]]) ? $settings[$keys[0]] : null;
            $bg2 = isset($settings[$keys[1]]) ? $settings[$keys[1]] : null;

            if (!$bg1 || !$bg2) continue;
            ?>

            <div class="col-md-6 mb-4">
                <div class="card shadow-sm">
                    <div class="card-body">

                        <h5 class="mb-3"><?= CHtml::encode($title) ?> Page</h5>

                        <!-- Gradient Preview -->
                        <div style="
                                height:120px;
                                border-radius:8px;
                                background: linear-gradient(180deg, <?= $bg1->value ?>, <?= $bg2->value ?>);
                                border:1px solid #ddd;
                                margin-bottom:12px;
                                "></div>

                        <!-- Color Info -->
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <small><?= $bg1->key ?>:</small>
                                <code><?= $bg1->value ?></code><br>
                                <small><?= $bg2->key ?>:</small>
                                <code><?= $bg2->value ?></code>
                            </div>

                            <!-- Edit Button -->
                            <div class="text-end">
                                <a href="<?= $this->createUrl('update', ['id'=>$bg1->id]) ?>"
                                   class="btn btn-sm btn-warning mb-1">
                                    Edit 1
                                </a><br>
                                <a href="<?= $this->createUrl('update', ['id'=>$bg2->id]) ?>"
                                   class="btn btn-sm btn-warning">
                                    Edit 2
                                </a>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

        <?php endforeach; ?>
    </div>
</div>
