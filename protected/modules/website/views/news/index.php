<div class="container mt-3">

    <?php if (Yii::app()->user->hasFlash('success')): ?>
        <div class="alert alert-success">
            <?php echo Yii::app()->user->getFlash('success'); ?>
        </div>
    <?php endif; ?>

    <!-- HEADER -->
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3 class="mb-0">News List</h3>

        <?php if (AuthHelper::can('WEBSITE|NEWS|CREATE')): ?>
            <a href="<?php echo $this->createUrl('create'); ?>" class="btn btn-primary">
                <i class="bi bi-plus-circle"></i> Create News
            </a>
        <?php endif; ?>
    </div>

    <?php $this->widget('zii.widgets.grid.CGridView', [
        'id' => 'news-grid',
        'dataProvider' => $model->search(),
        'filter' => $model,
        'itemsCssClass' => 'table table-bordered table-hover align-middle',
        'summaryCssClass' => 'text-muted mb-2',
        'pagerCssClass' => 'pagination justify-content-end',
        'columns' => [

            // IMAGE THUMBNAIL
            [
                'header' => 'Image',
                'type' => 'raw',
                'value' => '($data->image)
        ? CHtml::tag(
            "div",
            ["style" => "width:120px;height:80px;
                         display:flex;
                         align-items:center;
                         justify-content:center;
                         background:#f5f5f5;
                         border-radius:6px;"],
            CHtml::image(
                Yii::app()->params["websiteImageUrl"] . str_replace("/images","",$data->image),
                "",
                [
                    "style" => "max-width:100%;
                                max-height:100%;
                                object-fit:contain;"
                ]
            )
        )
        : "<span class=\"text-muted\">-</span>"',
                'filter' => false,
                'htmlOptions' => [
                    'style' => 'width:140px; text-align:center;'
                ],
            ],


            // TITLE
            [
                'name' => 'title_ind',
                'type' => 'raw',
                'value' => 'CHtml::encode($data->title_ind)',
            ],

            // PUBLISH DATE
            [
                'name' => 'publish_date',
                'value' => 'date("d M Y", strtotime($data->publish_date))',
                'htmlOptions' => ['style' => 'width:120px;'],
            ],

            // MAIN NEWS BADGE
            [
                'name' => 'is_main',
                'type' => 'raw',
                'value' => '$data->is_main
                ? "<span class=\"badge bg-success\">YES</span>"
                : "<span class=\"badge bg-secondary\">NO</span>"',
                'filter' => [1 => 'YES', 0 => 'NO'],
                'htmlOptions' => ['style' => 'width:90px;text-align:center;'],
            ],

            // STATUS BADGE
            [
                'name' => 'is_active',
                'type' => 'raw',
                'value' => '$data->is_active
                ? "<span class=\"badge bg-primary\">ACTIVE</span>"
                : "<span class=\"badge bg-danger\">INACTIVE</span>"',
                'filter' => [1 => 'ACTIVE', 0 => 'INACTIVE'],
                'htmlOptions' => ['style' => 'width:110px;text-align:center;'],
            ],

            // ACTIONS
            [
                'class' => 'CButtonColumn',
                'header' => 'Action',
                'template' => '{update}',
                'htmlOptions' => ['style' => 'width:90px;text-align:center;'],
                'buttons' => [
                    'update' => [
                        'label' => '<i class="bi bi-pencil-square"></i>',
                        'imageUrl' => false,
                        'url' => 'Yii::app()->createUrl("website/news/update", ["id"=>$data->id])',
                        'visible' => 'AuthHelper::can("WEBSITE|NEWS|UPDATE")',
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
