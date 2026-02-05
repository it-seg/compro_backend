<div class="container mt-3">

<?php if (Yii::app()->user->hasFlash('success')): ?>
    <div class="alert alert-success"><?php echo Yii::app()->user->getFlash('success'); ?></div>
<?php endif; ?>

<h3 class="mb-3">Navigations</h3>

    <?php if (AuthHelper::can('WEBSITE|NAVIGATION|CREATE')): ?>
        <a href="<?php echo $this->createUrl('create'); ?>" class="btn btn-primary mb-3">
            <i class="bi bi-plus-circle"></i> Create
        </a>
    <?php endif; ?>

<?php $this->widget('zii.widgets.grid.CGridView', [
    'id'=>'nav-grid',
    'dataProvider'=>$model->search(),
    'filter'=>$model,
    'itemsCssClass'=>'table table-bordered table-striped',
    'columns'=>[
        'label',
        'label_ind',
        'url',
        'sort_order',
        [
            'class'=>'CButtonColumn',
            'template'=>'{update}',
            'buttons'=>[
                'update'=>[
                    'label'=>'Edit',
                    'url'=>'Yii::app()->createUrl("website/navigation/update", ["id"=>$data->id])',
                    'options'=>['class'=>'btn btn-sm btn-warning'],
                ],
            ],
        ],
    ],
]); ?>

</div>