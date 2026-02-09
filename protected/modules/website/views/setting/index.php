<div class="container mt-3">

<?php if (Yii::app()->user->hasFlash('success')): ?>
    <div class="alert alert-success"><?php echo Yii::app()->user->getFlash('success'); ?></div>
<?php endif; ?>

<h3 class="mb-3">Setting Color & Style Background</h3>

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
        [
            'name' => 'value',
            'type' => 'raw',
            'value' => '
        (preg_match("/^#([A-Fa-f0-9]{3}|[A-Fa-f0-9]{6})$/", $data->value))
        ? 
        "<div style=\"display:flex;align-items:center;gap:10px\">
            <div style=\"
                width:32px;
                height:32px;
                background:{$data->value};
                border:1px solid #ccc;
                border-radius:4px;
            \"></div>
            <code>{$data->value}</code>
        </div>"
        :
        (
            (stripos($data->key, \'font\') !== false)
            ?
            "<div>
                <div style=\"
                    font-family:{$data->value};
                    font-size:16px;
                \">
                    Aa Bb Cc
                </div>
                <small class=\"text-muted\">{$data->value}</small>
            </div>"
            :
            (
                (stripos($data->key, \'radius\') !== false)
                ?
                "<div>
                    <div style=\"
                        width:60px;
                        height:32px;
                        background:#e9ecef;
                        border-radius:{$data->value};
                        border:1px solid #ccc;
                        margin-bottom:4px;
                    \"></div>
                    <small>{$data->value}</small>
                </div>"
                :
                CHtml::encode($data->value)
            )
        )
    ',
        ],

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