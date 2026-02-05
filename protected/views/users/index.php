<div class="container mt-3">
    <h3>User List</h3>
    <hr>
    <a href="<?php echo Yii::app()->createUrl('users/create'); ?>"
       class="btn btn-primary mb-3">
        <i class="bi bi-plus-circle"></i> Create User
    </a>
</div>

<?php
$this->widget('zii.widgets.grid.CGridView', [
    'id' => 'users-grid',
    'dataProvider' => $model->search(),
    'filter' => $model,
    'itemsCssClass' => 'table table-bordered table-striped',
    'columns' => [
        'username',
        'fullname',
        [
            'header' => 'Role',
            'name'   => 'role_id',
            'value'  => '$data->role ? $data->role->name : ""',
            'filter' => CHtml::listData(
                Roles::model()->findAll(['order' => 'name ASC']),
                'id',
                'name'
            ),
        ],
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
        [
            'class' => 'CButtonColumn',
            'template' => '{changepass}',
            'buttons' => [
                'changepass' => [
                    'label' => '<i class="bi bi-key-fill"></i>',  // icon only
                    'imageUrl' => false,
                    'encodeLabel' => false,
                    'url' => 'Yii::app()->createUrl("users/update", ["id" => $data->id, "action" => "change-password"])',
                    'options' => [
                        'class' => 'btn btn-sm btn-warning',
                        'title' => 'Change Password',  // <-- tooltip on hover
                    ],
                ],
            ],
        ],
    ],
]);
?>
