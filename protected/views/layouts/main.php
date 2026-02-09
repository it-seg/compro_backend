<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= CHtml::encode($this->pageTitle); ?></title>

    <link rel="stylesheet" href="<?= Yii::app()->baseUrl ?>/css/backend-custom.css">

    <style>
        @media (max-width: 768px) {
            #content {
                padding: 20px !important;
            }
        }
    </style>
</head>

<body>

<?php
$isLoginPage =
    Yii::app()->controller->id === 'site' &&
    Yii::app()->controller->action->id === 'login';

$isDashboard =
    Yii::app()->controller->id === 'site' &&
    Yii::app()->controller->action->id === 'index';

$moduleId     = Yii::app()->controller->module->id ?? null;
$controllerId = Yii::app()->controller->id ?? null;

/* ===============================
   WEBSITE CONTROLLER GROUPING
================================ */
$websiteContentControllers = [
    'carousel',
    'about',
    'contact',
    'gallery',
    'music',
    'events',
    'news',
    'menu',
    'space',
];

$websiteSettingControllers = ['image','setting','header','navigation', 'homepage'];

$isWebsiteContentActive =
    $isDashboard ||
    (
        $moduleId === 'website' &&
        in_array($controllerId, $websiteContentControllers)
    );


$isWebsiteSettingActive =
    $isDashboard ||
    (
        $moduleId === 'website' &&
        in_array($controllerId, $websiteSettingControllers)
    );


/* ===============================
   WEBSITE PERMISSION CHECK
================================ */
$canWebsiteContent =
    AuthHelper::can('WEBSITE|CAROUSEL') ||
    AuthHelper::can('WEBSITE|ABOUT') ||
    AuthHelper::can('WEBSITE|GALLERY') ||
    AuthHelper::can('WEBSITE|MUSIC') ||
    AuthHelper::can('WEBSITE|EVENTS') ||
    AuthHelper::can('WEBSITE|NEWS') ||
    AuthHelper::can('WEBSITE|MENU') ||
    AuthHelper::can('WEBSITE|SPACE');

$canWebsiteSetting =
    AuthHelper::can('WEBSITEIMAGES') ||
    AuthHelper::can('WEBSITE|SETTING') ||
    AuthHelper::can('WEBSITE|HEADER') ||
    AuthHelper::can('WEBSITE|NAVIGATION')||
    AuthHelper::can('WEBSITE|HOMEPAGE');
?>

<?php if (!$isLoginPage):


?>

    <!-- TOP NAVBAR -->
    <nav class="navbar navbar-dark bg-dark px-3">
        <button class="btn btn-outline-light me-2 d-md-none" id="sidebarToggle">
            <i class="bi bi-list"></i>
        </button>
        <span class="navbar-brand">Dashboard</span>

        <div class="ms-auto">
            <a href="<?= Yii::app()->createUrl('users/update', ['id'=>Yii::app()->user->id,'action'=>'change-password']) ?>"
               class="btn btn-sm btn-warning">Change Password</a>
            <a href="<?= Yii::app()->createUrl('site/logout') ?>"
               class="btn btn-sm btn-danger">Logout</a>
        </div>
    </nav>

    <div class="d-flex">

        <!-- SIDEBAR -->
        <div id="sidebar" class="bg-light border-end"
             style="width:250px; min-height:100vh; transition:0.3s;">
            <div class="p-3">
                <h5 class="mb-3">Menu</h5>

                <ul class="nav flex-column">

                    <li class="nav-item">
                        <a class="nav-link" href="<?= Yii::app()->createUrl('site/index') ?>">
                            <i class="bi bi-house-heart-fill"></i> Home
                        </a>
                    </li>

                    <?php if (AuthHelper::can('DASHBOARD')): ?>
                        <li class="nav-item">
                            <a class="nav-link" href="<?= Yii::app()->createUrl('admin/index') ?>">
                                <i class="bi bi-speedometer2"></i> Dashboard
                            </a>
                        </li>
                    <?php endif; ?>

                    <?php if (AuthHelper::can('USERS')): ?>
                        <li class="nav-item">
                            <a class="nav-link" href="<?= Yii::app()->createUrl('users/index') ?>">
                                <i class="bi bi-people"></i> Users
                            </a>
                        </li>
                    <?php endif; ?>

                    <?php if (AuthHelper::can('ROLES')): ?>
                        <li class="nav-item">
                            <a class="nav-link" href="<?= Yii::app()->createUrl('roles/index') ?>">
                                <i class="bi bi-key"></i> Roles
                            </a>
                        </li>
                    <?php endif; ?>

                    <!-- WEBSITE CONTENT -->
                    <?php if ($canWebsiteContent): ?>
                        <li class="nav-item">
                            <a class="nav-link d-flex align-items-center <?= $isWebsiteContentActive ? '' : 'collapsed' ?>"
                               data-bs-toggle="collapse"
                               href="#menuWebsiteContent"
                               aria-expanded="<?= $isWebsiteContentActive ? 'true' : 'false' ?>">
                                <i class="bi bi-globe2 me-2"></i>
                                <span>Website Content</span>
                                <i class="bi bi-chevron-down ms-auto"></i>
                            </a>

                            <div class="collapse <?= $isWebsiteContentActive ? 'show' : '' ?>"
                                 id="menuWebsiteContent">
                                <ul class="nav nav-sm flex-column ms-3">
                                    <?php if (AuthHelper::can('WEBSITE|CAROUSEL')): ?>
                                        <li class="nav-item">
                                            <a class="nav-link <?= $controllerId==='carousel'?'active':'' ?>"
                                               href="<?= Yii::app()->createUrl('website/carousel/index') ?>">
                                                Carousel Images
                                            </a>
                                        </li>
                                    <?php endif; ?>
                                    <?php if (AuthHelper::can('WEBSITE|ABOUT')): ?>
                                        <li class="nav-item">
                                            <a class="nav-link <?= $controllerId==='about'?'active':'' ?>"
                                               href="<?= Yii::app()->createUrl('website/about/index') ?>">
                                                About
                                            </a>
                                        </li>
                                    <?php endif; ?>
                                    <?php if (AuthHelper::can('WEBSITE|CONTACT')): ?>
                                        <li class="nav-item">
                                            <a class="nav-link <?= $controllerId==='contact'?'active':'' ?>"
                                               href="<?= Yii::app()->createUrl('website/contact/index') ?>">
                                                Contact
                                            </a>
                                        </li>
                                    <?php endif; ?>
                                    <?php if (AuthHelper::can('WEBSITE|GALLERY')): ?>
                                        <li class="nav-item">
                                            <a class="nav-link <?= $controllerId==='gallery'?'active':'' ?>"
                                               href="<?= Yii::app()->createUrl('website/gallery/index') ?>">
                                                Gallery
                                            </a>
                                        </li>
                                    <?php endif; ?>
                                    <?php if (AuthHelper::can('WEBSITE|MUSIC')): ?>
                                        <li class="nav-item">
                                            <a class="nav-link <?= $controllerId==='music'?'active':'' ?>"
                                               href="<?= Yii::app()->createUrl('website/music/index') ?>">
                                                Music
                                            </a>
                                        </li>
                                    <?php endif; ?>

                                    <?php if (AuthHelper::can('WEBSITE|EVENTS')): ?>
                                        <li class="nav-item">
                                            <a class="nav-link <?= $controllerId==='events'?'active':'' ?>"
                                               href="<?= Yii::app()->createUrl('website/events/index') ?>">
                                                Events
                                            </a>
                                        </li>
                                    <?php endif; ?>

                                    <?php if (AuthHelper::can('WEBSITE|NEWS')): ?>
                                        <li class="nav-item">
                                            <a class="nav-link <?= $controllerId==='news'?'active':'' ?>"
                                               href="<?= Yii::app()->createUrl('website/news/index') ?>">
                                                News
                                            </a>
                                        </li>
                                    <?php endif; ?>

                                    <?php if (AuthHelper::can('WEBSITE|MENU')): ?>
                                        <li class="nav-item">
                                            <a class="nav-link <?= $controllerId==='menu'?'active':'' ?>"
                                               href="<?= Yii::app()->createUrl('website/menu/index') ?>">
                                                Menu
                                            </a>
                                        </li>
                                    <?php endif; ?>

                                    <?php if (AuthHelper::can('WEBSITE|SPACE')): ?>
                                        <li class="nav-item">
                                            <a class="nav-link <?= $controllerId==='space'?'active':'' ?>"
                                               href="<?= Yii::app()->createUrl('website/space/index') ?>">
                                                Space
                                            </a>
                                        </li>
                                    <?php endif; ?>

                                </ul>
                            </div>
                        </li>
                    <?php endif; ?>

                    <!-- WEBSITE SETTINGS -->
                    <?php if ($canWebsiteSetting): ?>
                        <li class="nav-item">
                            <a class="nav-link d-flex align-items-center <?= $isWebsiteSettingActive ? '' : 'collapsed' ?>"
                               data-bs-toggle="collapse"
                               href="#menuWebsiteSetting"
                               aria-expanded="<?= $isWebsiteSettingActive ? 'true' : 'false' ?>">
                                <i class="bi bi-gear-fill me-2"></i>
                                <span>Website Settings</span>
                                <i class="bi bi-chevron-down ms-auto"></i>
                            </a>

                            <div class="collapse <?= $isWebsiteSettingActive ? 'show' : '' ?>"
                                 id="menuWebsiteSetting">
                                <ul class="nav nav-sm flex-column ms-3">

                                    <?php if (AuthHelper::can('WEBSITEIMAGES')): ?>
                                        <li class="nav-item">
                                            <a class="nav-link <?= $controllerId==='image'?'active':'' ?>"
                                               href="<?= Yii::app()->createUrl('website/image/index') ?>">
                                                Images
                                            </a>
                                        </li>
                                    <?php endif; ?>

                                    <?php if (AuthHelper::can('WEBSITE|SETTING')): ?>
                                        <li class="nav-item">
                                            <a class="nav-link <?= $controllerId==='setting'?'active':'' ?>"
                                               href="<?= Yii::app()->createUrl('website/setting/index') ?>">
                                                Setting Color
                                            </a>
                                        </li>
                                    <?php endif; ?>

                                    <?php if (AuthHelper::can('WEBSITE|HEADER')): ?>
                                        <li class="nav-item">
                                            <a class="nav-link <?= $controllerId==='header'?'active':'' ?>"
                                               href="<?= Yii::app()->createUrl('website/header/index') ?>">
                                                Header Language
                                            </a>
                                        </li>
                                    <?php endif; ?>

                                    <?php if (AuthHelper::can('WEBSITE|NAVIGATION')): ?>
                                        <li class="nav-item">
                                            <a class="nav-link <?= $controllerId==='navigation'?'active':'' ?>"
                                               href="<?= Yii::app()->createUrl('website/navigation/index') ?>">
                                                Navigation
                                            </a>
                                        </li>
                                    <?php endif; ?>

                                    <?php if (AuthHelper::can('WEBSITE|HOMEPAGE')): ?>
                                        <li class="nav-item">
                                            <a class="nav-link <?= $controllerId==='homepage'?'active':'' ?>"
                                               href="<?= Yii::app()->createUrl('website/homepage/index') ?>">
                                                Homepage
                                            </a>
                                        </li>
                                    <?php endif; ?>

                                </ul>
                            </div>
                        </li>
                    <?php endif; ?>

                </ul>
            </div>
        </div>

        <div id="content" class="flex-grow-1 p-4">
            <?= $content ?>
        </div>

    </div>

<?php else: ?>
    <div class="container mt-5">
        <?= $content ?>
    </div>
<?php endif; ?>

<script>
    document.getElementById('sidebarToggle')?.addEventListener('click', function () {
        let sidebar = document.getElementById('sidebar');
        sidebar.style.marginLeft =
            sidebar.style.marginLeft === '-250px' ? '0' : '-250px';
    });

</script>

</body>
</html>
