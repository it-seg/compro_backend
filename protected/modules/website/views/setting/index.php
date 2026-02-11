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

$uiColorGroups = [
    'Carousel Font Color' => [
        'carousel_color_title',
        'carousel_color_sub_title',
    ],
    'UI Background & Button Color' => [
        'color_button_view_menu',
        'color_button_make_reservation',
        'color_background_running_text',
    ],
];

?>

<div class="container mt-4">
    <h3 class="mb-4">Page Color Setting</h3>

    <div class="row">
        <?php foreach ($groups as $title => $keys):
            $bg1 = isset($settings[$keys[0]]) ? $settings[$keys[0]] : null;
            $bg2 = isset($settings[$keys[1]]) ? $settings[$keys[1]] : null;

            if (!$bg1 || !$bg2) continue;
            ?>

            <div class="col-md-6 mb-4">
                <div class="card shadow-sm">
                    <div class="card-body">

                        <h5 class="mb-3" style="text-align: center"><?= CHtml::encode($title) ?> Background Page</h5>

                        <!-- Gradient Preview -->
                        <div style="
                                width:100%;
                                aspect-ratio: 210 / 297;
                                max-width: 280px;
                                margin: 0 auto 12px;
                                border-radius:8px;
                                background: linear-gradient(180deg, <?= $bg1->value ?>, <?= $bg2->value ?>);
                                border:1px solid #ddd;
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
                                   class="btn btn-sm btn-warning">
                                    Edit
                                </a>
                            </div>

                        </div>

                    </div>
                </div>
            </div>

        <?php endforeach; ?>
    </div>

    <h3 class="mb-4 mt-5">Font Color & Background Color</h3>

    <div class="row">
        <?php foreach ($uiColorGroups as $title => $keys): ?>
            <div class="col-md-6 mb-4">
                <div class="card shadow-sm">
                    <div class="card-body">

                        <h5 class="mb-3 text-center"><?= CHtml::encode($title) ?></h5>

                        <?php foreach ($keys as $key):
                            if (!isset($settings[$key])) continue;
                            $item = $settings[$key];
                            ?>
                            <div class="d-flex justify-content-between align-items-center mb-3">

                                <div class="d-flex align-items-center gap-2">
                                    <!-- Color Preview -->
                                    <div style="
                                            width:30px;
                                            height:30px;
                                            background:<?= CHtml::encode($item->value) ?>;
                                            border:1px solid #ccc;
                                            border-radius:4px;
                                            "></div>

                                    <div>
                                        <small><?= CHtml::encode($item->key) ?></small><br>
                                        <code><?= CHtml::encode($item->value) ?></code>
                                    </div>
                                </div>

                                <!-- Edit -->
                                <a href="<?= $this->createUrl('update', ['id'=>$item->id]) ?>"
                                   class="btn btn-sm btn-warning">
                                    Edit
                                </a>

                            </div>
                        <?php endforeach; ?>

                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>

</div>
