<div class="container mt-3">

    <h3>Website Dashboard</h3>
    <hr>
    <div class="d-grid gap-3">
        <?php if (AuthHelper::can('WEBSITE|SETTING')): ?>
        <a class="btn btn-primary"
           href="<?php echo Yii::app()->createUrl('website/setting/index'); ?>">
            Setting
        </a>
        <?php endif; ?>
        <?php if (AuthHelper::can('WEBSITE|HEADER')): ?>
        <a class="btn btn-primary"
           href="<?php echo Yii::app()->createUrl('website/header/index'); ?>">
            Header Contents
        </a>
        <?php endif; ?>
        <?php if (AuthHelper::can('WEBSITE|NAVIGATION')): ?>
        <a class="btn btn-primary"
           href="<?php echo Yii::app()->createUrl('website/navigation/index'); ?>">
            Navigation
        </a>
        <?php endif; ?>
        <?php if (AuthHelper::can('WEBSITE|EVENTS')): ?>
        <a class="btn btn-primary"
           href="<?php echo Yii::app()->createUrl('website/events/index'); ?>">
            Events
        </a>
        <?php endif; ?>
        <?php if (AuthHelper::can('WEBSITE|MENU')): ?>
        <a class="btn btn-primary"
           href="<?php echo Yii::app()->createUrl('website/menu/index'); ?>">
            Menu
        </a>
        <?php endif; ?>
        <?php if (AuthHelper::can('WEBSITE|NEWS')): ?>
        <a class="btn btn-primary"
           href="<?php echo Yii::app()->createUrl('website/news/index'); ?>">
            News
        </a>
        <?php endif; ?>
        <?php if (AuthHelper::can('WEBSITE|SPACE')): ?>
        <a class="btn btn-primary"
           href="<?php echo Yii::app()->createUrl('website/space/index'); ?>">
            Space
        </a>
        <?php endif; ?>
    </div>
</div>
