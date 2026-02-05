<div class="container mt-3">

<?php if (Yii::app()->user->hasFlash('success')): ?>
    <div class="alert alert-success"><?php echo Yii::app()->user->getFlash('success'); ?></div>
<?php endif; ?>

<h3 class="mb-3">Setting List</h3>

<?php if (AuthHelper::can('WEBSITE|SETTING|CREATE')): ?>
    <a href="<?php echo $this->createUrl('create'); ?>" class="btn btn-primary mb-3">
        <i class="bi bi-plus-circle"></i> Create
    </a>
<?php endif; ?>

<?php
/*$data = $model->search()->getData();
$aaa = 1;
*/?>

<?php $this->widget('zii.widgets.grid.CGridView', [
    'id'=>'header-grid',
    'dataProvider'=>$model->search(),
    'filter'=>$model,
    'itemsCssClass'=>'table table-bordered table-striped',
    'columns'=>[
        ['name'=>'key','type'=>'raw','value'=>'CHtml::encode($data->key)'],
        ['name'=>'value','type'=>'raw','value'=>'CHtml::encode($data->value)'],
        [
            'class'=>'CButtonColumn',
            'template'=>'{update}',
            'buttons'=>[
                'update'=>[
                    'label'=>'Edit',
                    'url'=>'Yii::app()->createUrl("website/setting/update", ["id"=>$data->id])',
                    'options'=>['class'=>'btn btn-sm btn-warning'],
                ],
            ],
        ],
    ],
]); ?>

</div>