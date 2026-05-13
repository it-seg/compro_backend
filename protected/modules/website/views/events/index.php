<style>
    .events-header {
        border-left: 4px solid #dc3545;
        background: linear-gradient(135deg, #ffffff, #f8f9fa);
        border-radius: 14px;
        padding: 16px 20px;
        margin-bottom: 20px;
        box-shadow: 0 3px 10px rgba(0,0,0,0.04);
    }

    .events-header h4 {
        margin: 0;
        font-size: 24px;
        font-weight: 700;
        color: #212529;
    }

    .events-header p {
        margin: 4px 0 0;
        font-size: 13px;
        color: #6c757d;
    }

    .events-toolbar {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 12px;
        flex-wrap: wrap;
        margin-bottom: 18px;
    }

    .events-total {
        font-size: 14px;
        color: #6c757d;
    }

    .events-total strong {
        color: #212529;
    }

    .btn-create {
        border-radius: 12px;
        padding: 10px 16px;
        font-size: 13px;
        font-weight: 700;
        box-shadow: 0 4px 10px rgba(13,110,253,.15);
    }

    .events-grid-wrapper {
        background: #fff;
        border-radius: 18px;
        overflow: hidden;
        box-shadow: 0 5px 18px rgba(0,0,0,0.05);
        border: 1px solid #f1f3f5;
    }

    .events-grid-wrapper .table {
        margin-bottom: 0;
    }

    .events-grid-wrapper .table thead th {
        background: #fafafa;
        border-bottom: 1px solid #eee;
        font-size: 12px;
        font-weight: 700;
        color: #495057;
        padding: 16px 14px;
        vertical-align: middle;
    }

    .events-grid-wrapper .table tbody td {
        padding: 18px 14px;
        vertical-align: middle;
        border-color: #f5f5f5;
    }

    .events-grid-wrapper .filters input,
    .events-grid-wrapper .filters select {
        border-radius: 10px;
        border: 1px solid #dee2e6;
        min-height: 40px;
        font-size: 12px;
        box-shadow: none !important;
        transition: .2s;
    }

    .events-grid-wrapper .filters input:focus,
    .events-grid-wrapper .filters select:focus {
        border-color: #0d6efd;
    }

    .event-card {
        display: flex;
        align-items: center;
        gap: 14px;
    }

    .event-thumb {
        width: 110px;
        height: 74px;
        border-radius: 12px;
        overflow: hidden;
        background: #f8f9fa;
        border: 1px solid #eee;
        flex-shrink: 0;
    }

    .event-thumb img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .event-title {
        font-size: 15px;
        font-weight: 700;
        color: #212529;
        margin-bottom: 4px;
        line-height: 1.3;
    }

    .event-subtitle {
        font-size: 12px;
        color: #6c757d;
    }

    .event-date {
        font-size: 14px;
        font-weight: 700;
        color: #212529;
    }

    .event-time {
        font-size: 12px;
        color: #6c757d;
        margin-top: 3px;
    }

    .badge-status {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        padding: 7px 14px;
        border-radius: 999px;
        font-size: 11px;
        font-weight: 700;
        letter-spacing: .4px;
    }

    .badge-active {
        background: rgba(25,135,84,.12);
        color: #198754;
    }

    .badge-inactive {
        background: rgba(220,53,69,.12);
        color: #dc3545;
    }

    .action-column {
        width: 140px;
        min-width: 140px;
        text-align: center;
        white-space: nowrap;
    }

    .btn-edit {
        display: inline-flex !important;
        align-items: center;
        justify-content: center;
        gap: 6px;

        width: 100px;
        height: 40px;

        border-radius: 10px !important;

        font-size: 12px !important;
        font-weight: 700 !important;

        white-space: nowrap !important;
        word-break: keep-all !important;

        box-shadow: 0 4px 10px rgba(255,193,7,.18);
    }

    .summary {
        padding: 14px 18px 0;
        font-size: 12px;
        color: #6c757d;
    }

    .pagination {
        padding: 14px 18px;
        margin: 0;
    }

    .pagination li a,
    .pagination li span {
        border-radius: 10px !important;
        margin: 0 2px;
        border: 1px solid #dee2e6;
        color: #495057;
        font-size: 12px;
        min-width: 34px;
        text-align: center;
    }

    .empty {
        padding: 60px 20px !important;
        text-align: center;
        color: #6c757d;
        font-size: 14px;
    }

    .empty-icon {
        font-size: 44px;
        margin-bottom: 10px;
    }

    @media (max-width: 768px) {

        .event-card {
            flex-direction: column;
            align-items: flex-start;
        }

        .event-thumb {
            width: 100%;
            height: 180px;
        }

        .btn-edit {
            width: 100%;
        }

    }
</style>

<div class="container mt-3">

    <?php if (Yii::app()->user->hasFlash('success')): ?>
        <div class="alert alert-success">
            <?php echo Yii::app()->user->getFlash('success'); ?>
        </div>
    <?php endif; ?>

    <!-- HEADER -->
    <div class="events-header">

        <h4>
            Kelola Events Website
        </h4>

        <p>
            Buat, edit, dan kelola event website.
        </p>

    </div>

    <!-- TOOLBAR -->
    <div class="events-toolbar">

        <div class="events-total">
            Total Event:
            <strong>
                <?= $model->search()->totalItemCount ?>
            </strong>
        </div>

        <?php if (AuthHelper::can('WEBSITE|EVENTS|CREATE')): ?>

            <a href="<?php echo $this->createUrl('create'); ?>"
               class="btn btn-primary btn-create">

                <i class="bi bi-plus-circle"></i>
                Create Event

            </a>

        <?php endif; ?>

    </div>

    <!-- GRID -->
    <div class="events-grid-wrapper">

        <?php $this->widget('zii.widgets.grid.CGridView', [

            'id' => 'events-grid',

            'dataProvider' => $model->search(),

            'filter' => $model,

            'itemsCssClass' => 'table align-middle',

            'summaryCssClass' => 'summary',

            'pagerCssClass' => 'pagination justify-content-end',

            'emptyText' => '
                <div class="empty">
                    <div class="empty-icon">🎉</div>
                    Belum ada event yang dibuat
                </div>
            ',

            'columns' => [

                /* EVENT */
                [
                    'header' => 'Event',

                    'type' => 'raw',

                    'value' => '
            "<div class=\"event-card\">

                <div class=\"event-thumb\">"

                    .

                    (
                        $data->image_url
                        ? CHtml::image(
                            Yii::app()->params["websiteImageUrl"]
                            . str_replace("/images","",$data->image_url)
                          )
                        : "<span class=\"text-muted small\">No Image</span>"
                    )

                    .

                "</div>

                <div>

                    <div class=\"event-title\">"
                        . CHtml::encode($data->title_ind ?: $data->title)
                    . "</div>

                    <div class=\"event-subtitle\">
                        ID Event #".$data->id."
                    </div>

                </div>

            </div>"
        ',

                    'htmlOptions' => [
                        'style' => 'min-width:320px'
                    ],
                ],

                /* DESCRIPTION ID */
                [
                    'header' => 'Description (ID)',

                    'type' => 'raw',

                    'value' => '
            "<div style=\"max-width:260px;\">

                <div style=\"
                    font-size:13px;
                    color:#212529;
                    line-height:1.5;
                \">

                    "

                    .

                    CHtml::encode(
                        mb_strlen(strip_tags($data->description_ind)) > 120
                        ? mb_substr(strip_tags($data->description_ind), 0, 120) . "..."
                        : strip_tags($data->description_ind)
                    )

                    .

                "</div>

            </div>"
        ',

                    'filter' => false,

                    'htmlOptions' => [
                        'style' => 'min-width:280px'
                    ],
                ],

                /* DESCRIPTION EN */
                [
                    'header' => 'Description (EN)',

                    'type' => 'raw',

                    'value' => '
            "<div style=\"max-width:260px;\">

                <div style=\"
                    font-size:13px;
                    color:#212529;
                    line-height:1.5;
                \">

                    "

                    .

                    CHtml::encode(
                        mb_strlen(strip_tags($data->description)) > 120
                        ? mb_substr(strip_tags($data->description), 0, 120) . "..."
                        : strip_tags($data->description)
                    )

                    .

                "</div>

            </div>"
        ',

                    'filter' => false,

                    'htmlOptions' => [
                        'style' => 'min-width:280px'
                    ],
                ],

                /* DATE */
                [
                    'name' => 'event_date',

                    'type' => 'raw',

                    'value' => '
            "<div class=\"event-date\">"
                . date("d M Y", strtotime($data->event_date))
            . "</div>

            <div class=\"event-time\">"

                .

                (
                    $data->event_time
                    ? date("H:i", strtotime($data->event_time)) . " WIB"
                    : "-"
                )

                .

            "</div>"
        ',

                    'htmlOptions' => [
                        'style' => 'width:180px'
                    ],
                ],

                /* STATUS */
                [
                    'name' => 'is_active',

                    'type' => 'raw',

                    'value' => '
            $data->is_active
            ? "<span class=\"badge-status badge-active\">
                ACTIVE
               </span>"
            : "<span class=\"badge-status badge-inactive\">
                INACTIVE
               </span>"
        ',

                    'filter' => [
                        1 => 'ACTIVE',
                        0 => 'INACTIVE'
                    ],

                    'htmlOptions' => [
                        'style' => 'width:150px;text-align:center;'
                    ],
                ],

                /* ACTION */
                [
                    'class' => 'CButtonColumn',

                    'header' => 'Action',

                    'template' => '{update}',

                    'htmlOptions' => [
                        'class' => 'action-column'
                    ],

                    'headerHtmlOptions' => [
                        'class' => 'action-column'
                    ],

                    'buttons' => [

                        'update' => [

                            'label' => '
                    <i class="bi bi-pencil-square"></i>
                    <span>Edit</span>
                ',

                            'imageUrl' => false,

                            'url' => 'Yii::app()->createUrl(
                    "website/events/update",
                    ["id"=>$data->id]
                )',

                            'visible' => 'AuthHelper::can("WEBSITE|EVENTS|UPDATE")',

                            'options' => [
                                'class' => 'btn btn-warning btn-sm btn-edit',
                                'title' => 'Edit Event',
                            ],
                        ],

                    ],
                ],

            ],
        ]); ?>

    </div>

</div>