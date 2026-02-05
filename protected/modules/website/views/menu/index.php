<div class="container mt-3">

    <?php if (Yii::app()->user->hasFlash('success')): ?>
        <div class="alert alert-success">
            <?php echo Yii::app()->user->getFlash('success'); ?>
        </div>
    <?php endif; ?>

    <!-- HEADER -->
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3 class="mb-0">Menu List</h3>

        <?php if (AuthHelper::can('WEBSITE|MENU|CREATE')): ?>
            <a href="<?php echo $this->createUrl('create'); ?>" class="btn btn-primary">
                <i class="bi bi-plus-circle"></i> Create Menu
            </a>
        <?php endif; ?>
    </div>

    <?php $this->widget('zii.widgets.grid.CGridView', [
        'id' => 'menu-grid',
        'dataProvider' => $model->search(),
        'filter' => $model,
        'itemsCssClass' => 'table table-bordered table-hover align-middle',
        'summaryCssClass' => 'text-muted mb-2',
        'pagerCssClass' => 'pagination justify-content-end',
        'columns' => [

            /* SLUG */
            [
                'name' => 'slug',
                'type' => 'raw',
                'value' => 'CHtml::encode($data->slug)',
                'htmlOptions' => [
                    'style' => 'width:180px; font-family:monospace;'
                ],
            ],

            /* NAME (ID) */
            [
                'name' => 'name_ind',
                'type' => 'raw',
                'value' => 'CHtml::encode($data->name_ind)',
            ],

            /* NAME (EN) */
            [
                'name' => 'name',
                'type' => 'raw',
                'value' => 'CHtml::encode($data->name)',
            ],

            /* STATUS BADGE */
            [
                'name' => 'is_active',
                'type' => 'raw',
                'value' => '$data->is_active
                    ? "<span class=\"badge bg-primary\">ACTIVE</span>"
                    : "<span class=\"badge bg-danger\">INACTIVE</span>"',
                'filter' => [1 => 'ACTIVE', 0 => 'INACTIVE'],
                'htmlOptions' => [
                    'style' => 'width:120px; text-align:center;'
                ],
            ],

            /* SORT ORDER */
            [
                'name' => 'sort_order',
                'type' => 'raw',
                'value' => 'CHtml::encode($data->sort_order)',
                'htmlOptions' => [
                    'style' => 'width:90px; text-align:center;'
                ],
            ],

            /* ACTION */
            [
                'class' => 'CButtonColumn',
                'header' => 'Action',
                'template' => '{update}',
                'htmlOptions' => [
                    'style' => 'width:90px; text-align:center;'
                ],
                'buttons' => [
                    'update' => [
                        'label' => '<i class="bi bi-pencil-square"></i>',
                        'imageUrl' => false,
                        'url' => 'Yii::app()->createUrl("website/menu/update", ["id"=>$data->id])',
                        'visible' => 'AuthHelper::can("WEBSITE|MENU|UPDATE")',
                        'options' => [
                            'class' => 'btn btn-sm btn-warning',
                            'title' => 'Edit',
                        ],
                    ],
                ],
            ],
        ],
    ]); ?>

</div>
