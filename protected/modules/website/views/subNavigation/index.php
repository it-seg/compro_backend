<div class="container mt-3">

<?php if (Yii::app()->user->hasFlash('success')): ?>
    <div class="alert alert-success"><?php echo Yii::app()->user->getFlash('success'); ?></div>
<?php endif; ?>

<h3 class="mb-3">Sub Navigations</h3>

<a href="<?php echo $this->createUrl('create'); ?>" class="btn btn-primary mb-3">
    <i class="bi bi-plus-circle"></i> Create
</a>

<?php $this->widget('zii.widgets.grid.CGridView', [
    'id'=>'subnav-grid',
    'dataProvider'=>$model->search(),
    'filter'=>$model,
    'itemsCssClass'=>'table table-bordered table-striped',
    'columns'=>[
        'id',
        ['name'=>'navigation_id','value'=>'$data->navigation? $data->navigation->label : "-"'],
        'label',
        'url',
        'sort_order',
        [
            'class'=>'CButtonColumn',
            'template'=>'{update}',
            'buttons'=>[
                'update'=>[
                    'label'=>'Edit',
                    'url'=>'Yii::app()->createUrl("website/subNavigation/update", ["id"=>$data->id])',
                    'options'=>['class'=>'btn btn-sm btn-warning'],
                ],
            ],
        ],
    ],
]); ?>

</div>