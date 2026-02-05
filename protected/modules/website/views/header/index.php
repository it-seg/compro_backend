<div class="container mt-3">

<?php if (Yii::app()->user->hasFlash('success')): ?>
    <div class="alert alert-success"><?php echo Yii::app()->user->getFlash('success'); ?></div>
<?php endif; ?>

<h3 class="mb-3">Header Contents List</h3>

    <?php if (AuthHelper::can('WEBSITE|HEADER|CREATE')): ?>
        <a href="<?php echo $this->createUrl('create'); ?>" class="btn btn-primary mb-3">
            <i class="bi bi-plus-circle"></i> Create
        </a>
    <?php endif; ?>

<?php $this->widget('zii.widgets.grid.CGridView', [
    'id'=>'header-grid',
    'dataProvider'=>$model->search(),
    'filter'=>$model,
    'itemsCssClass'=>'table table-bordered table-striped',
    'columns'=>[
        'id',
        'type',
        ['name'=>'content','type'=>'raw','value'=>'CHtml::encode($data->content)'],
        ['name'=>'content_english','type'=>'raw','value'=>'CHtml::encode($data->content_english)'],
        [
            'class'=>'CButtonColumn',
            'template'=>'{update}',
            'buttons'=>[
                'update'=>[
                    'label'=>'Edit',
                    'url'=>'Yii::app()->createUrl("website/header/update", ["id"=>$data->id])',
                    'options'=>['class'=>'btn btn-sm btn-warning'],
                ],
            ],
        ],
    ],
]); ?>

</div>