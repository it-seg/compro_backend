<div class="container mt-3">
    <h3>Roles List</h3>
    <hr>
    <a href="<?php echo Yii::app()->createUrl('roles/create'); ?>"
       class="btn btn-primary mb-3">
        <i class="bi bi-plus-circle"></i> Create Roles
    </a>
</div>

<?php
$this->widget('zii.widgets.grid.CGridView', [
    'id' => 'roles-grid',
    'dataProvider' => $model->search(),
    'filter' => $model,
    'itemsCssClass' => 'table table-bordered table-striped',
    'columns' => [
        'name',
        [
            'class' => 'CButtonColumn',
            'template' => '{update}',
            'buttons' => [
                'update' => [
                    'label' => 'Edit',
                    'options' => ['class' => 'btn btn-sm btn-warning'],
                ]
            ]
        ],
    ],
]);
?>
