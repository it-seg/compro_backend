<div class="container mt-3">

    <?php if (Yii::app()->user->hasFlash('success')): ?>
        <div class="alert alert-success">
            <?php echo Yii::app()->user->getFlash('success'); ?>
        </div>
    <?php endif; ?>

    <h3 class="mb-3">Homepage Sections</h3>

    <?php if (AuthHelper::can('WEBSITE|HOMEPAGE|CREATE')): ?>
        <a href="<?php echo $this->createUrl('create'); ?>" class="btn btn-primary mb-3">
            <i class="bi bi-plus-circle"></i> Create
        </a>
    <?php endif; ?>

    <?php $this->widget('zii.widgets.grid.CGridView', [
        'id' => 'homepage-grid',
        'dataProvider' => $model->search(),
        'filter' => $model,
        'itemsCssClass' => 'table table-bordered table-striped',
        'columns' => [
            'section_key',
            [
                'name' => 'is_active',
                'type' => 'raw',
                'filter' => [
                    1 => 'Active',
                    0 => 'Non Active',
                ],
                'value' => function($data) {
                    return $data->is_active == 1
                        ? '<span class="badge bg-success">Aktif</span>'
                        : '<span class="badge bg-danger">Tidak Aktif</span>';
                },
            ],
            'sort_order',
            [
                'class' => 'CButtonColumn',
                'template' => '{update}',
                'buttons' => [
                    'update' => [
                        'label' => 'Edit',
                        'url' => 'Yii::app()->createUrl("website/homepage/update", ["id"=>$data->id])',
                        'options' => ['class' => 'btn btn-sm btn-warning'],
                    ],
                ],
            ],
        ],
    ]); ?>

</div>
