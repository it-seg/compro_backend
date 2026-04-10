<style>
    .container {
        font-size: 12px;
    }

    .container h3 {
        font-size: 16px;
    }

    .container h5 {
        font-size: 14px;
    }

    .container h6 {
        font-size: 12px;
    }
    .btn-warning {
        font-size: 11px !important;
        padding: 1px 6px !important;
    }
    /* EDIT BUTTON STYLE */
    .btn-edit {
        font-size: 11px;
        padding: 4px 12px;
        border-radius: 20px;

        background: linear-gradient(135deg, #f4b400, #e09e00);
        border: none;

        transition: all .25s ease;
    }

    /* HOVER EFFECT */
    .btn-edit:hover {
        transform: translateY(-1px);
        box-shadow: 0 4px 10px rgba(0,0,0,0.15);
    }
</style><?php
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
    'Font Color' => [
        'carousel_color_title',
        'carousel_color_sub_title',
        'color_background_running_text',
        'running_text_color_title',
        'navbar_menu_color_title',
        'navbar_bg',
        'navbar_bg_scroll',
        'about_color_title',
        'about_color_sub_title',
        'about_color_view_more',
        'space_color_title',
        'space_color_sub_title',
        'menu_color_title',
        'menu_color_sub_title',
        'event_color_title',
        'event_color_sub_title',
        'news_color_title',
        'news_color_sub_title',
        'sosmed_color_title',
        'footer_color_title',
    ],
    'Button Color' => [
        'color_button_view_menu',
        'color_button_make_reservation',
        'color_background_running_text',
        'color_button_about_view_more',
        'color_button_menu_tabs'
    ],
];
?>

<div class="container mt-4">

    <!-- ================= BACKGROUND ================= -->
    <h3 class="mb-4">Page Background Color Setting</h3>

    <div class="row">
        <?php foreach ($groups as $title => $keys):
            $bg1 = isset($settings[$keys[0]]) ? $settings[$keys[0]] : null;
            $bg2 = isset($settings[$keys[1]]) ? $settings[$keys[1]] : null;

            if (!$bg1 || !$bg2) continue;
            ?>

            <div class="col-xl-2 col-lg-3 col-md-4 col-sm-6 col-12 mb-4">
                <div class="card shadow-sm">
                    <div class="card-body">

                        <h6 class="mb-3 text-center">
                            <?= CHtml::encode($title) ?> Page
                        </h6>
                        <div class="text-center mb-2">
                            <a href="<?= $this->createUrl('update', ['id'=>$bg1->id]) ?>"
                               class="btn btn-warning btn-edit">
                                Edit
                            </a>
                        </div>

                        <!-- Gradient Preview -->
                        <div style="
                                width:100%;
                                aspect-ratio:210/297;
                                max-width:150px;
                                margin:0 auto 12px;
                                border-radius:8px;
                                background:linear-gradient(180deg, <?= $bg1->value ?>, <?= $bg2->value ?>);
                                border:1px solid #ddd;
                                "></div>

                    </div>
                </div>
            </div>

        <?php endforeach; ?>
    </div>


    <!-- ================= FONT & BUTTON ================= -->
    <h3 class="mb-4 mt-5">Font & Button Color</h3>

    <div class="row">

        <?php foreach ($uiColorGroups as $title => $keys): ?>

            <?php
            // GRID LAYOUT
            if ($title === 'Font Color') {
                $colClass = 'col-lg-8 col-md-12';
            } else {
                $colClass = 'col-lg-4 col-md-12';
            }
            ?>

            <div class="<?= $colClass ?> mb-4">
                <div class="card shadow-sm">
                    <div class="card-body">

                        <h5 class="mb-3 text-center">
                            <?= CHtml::encode($title) ?>
                        </h5>

                        <div class="row">
                            <?php foreach ($keys as $key):

                                if (!isset($settings[$key])) continue;
                                $item = $settings[$key];

                                // isi Font Color jadi 2 kolom
                                $itemClass = ($title === 'Font Color')
                                    ? 'col-md-6'
                                    : 'col-12';
                                ?>

                                <div class="<?= $itemClass ?> mb-3">

                                    <div class="d-flex justify-content-between align-items-center">

                                        <!-- LEFT -->
                                        <div class="d-flex align-items-center gap-2">

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

                                        <!-- RIGHT -->
                                        <a href="<?= $this->createUrl('update', ['id'=>$item->id]) ?>"
                                           class="btn btn-sm btn-warning">
                                            Edit
                                        </a>

                                    </div>

                                </div>

                            <?php endforeach; ?>
                        </div>

                    </div>
                </div>
            </div>

        <?php endforeach; ?>

    </div>

</div>