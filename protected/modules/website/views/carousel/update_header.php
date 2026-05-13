<link href="<?php echo Yii::app()->baseUrl; ?>/css/quill/quill.snow.css" rel="stylesheet">
<script src="<?php echo Yii::app()->baseUrl; ?>/js/quill/quill.js"></script>
<link rel="stylesheet" href="<?= Yii::app()->baseUrl ?>/css/quill/custom.css">

<?php
$isParagraph = in_array($model->type, [
    'about_value_p1',
    'about_value_p2',
]);

$hasIsActive = isset($model->is_active);
$isActiveVal = $hasIsActive ? (int)$model->is_active : 1;

$typeLabels = [
    'header' => 'Header Title',
    'sub_header' => 'Sub Header',
    'view_menus' => 'Menu Button',
    'sub_view_menus' => 'Menu Button Subtitle',
    'hero_reservation' => 'Reservation Button',
    'sub_hero_reservation' => 'Reservation Button Subtitle',
    'running_text' => 'Running Text',
    'about_title' => 'About Title',
    'about_sub_title' => 'About Subtitle',
    'about_button' => 'About Button',
    'about_value_p1' => 'About Description 1',
    'about_value_p2' => 'About Description 2',
];

$pageTitle = $typeLabels[$model->type] ?? ucfirst($model->type);
?>

<style>
    .cms-wrapper {
        max-width: 1100px;
        margin: auto;
    }

    .cms-card {
        border: 0;
        border-radius: 16px;
        overflow: hidden;
        box-shadow: 0 4px 16px rgba(0,0,0,0.06);
    }

    .cms-header {
        background: linear-gradient(135deg, #0d6efd, #0a58ca);
        color: #fff;
        padding: 18px 24px;
    }

    .cms-header h4 {
        margin: 0;
        font-size: 22px;
        font-weight: 700;
    }

    .cms-header p {
        margin: 6px 0 0;
        opacity: .9;
        font-size: 13px;
    }

    .cms-body {
        padding: 24px;
        background: #fff;
    }

    .form-label {
        font-weight: 600;
        margin-bottom: 8px;
        color: #212529;
    }

    .form-hint {
        font-size: 12px;
        color: #6c757d;
        margin-top: 6px;
    }

    .form-control {
        border-radius: 10px;
        min-height: 46px;
        border: 1px solid #dcdcdc;
        box-shadow: none !important;
    }

    .ql-container {
        border-radius: 0 0 10px 10px;
        font-size: 14px;
    }

    .ql-toolbar {
        border-radius: 10px 10px 0 0;
    }

    .status-box {
        border: 1px solid #e9ecef;
        border-radius: 12px;
        padding: 16px;
        background: #fafafa;
    }

    .status-option {
        border: 1px solid #dee2e6;
        border-radius: 10px;
        padding: 12px 16px;
        cursor: pointer;
        transition: .2s;
        width: 220px;
    }

    .status-option:hover {
        border-color: #0d6efd;
        background: #f8fbff;
    }

    .status-option input {
        margin-right: 8px;
    }

    .status-active {
        color: #198754;
        font-weight: 600;
    }

    .status-inactive {
        color: #dc3545;
        font-weight: 600;
    }

    .action-area {
        border-top: 1px solid #eee;
        margin-top: 28px;
        padding-top: 20px;
    }

    .btn-save {
        min-width: 130px;
        height: 44px;
        border-radius: 10px;
        font-weight: 600;
    }

    .btn-cancel {
        min-width: 110px;
        height: 44px;
        border-radius: 10px;
        font-weight: 500;
    }

    .field-card {
        border: 1px solid #eee;
        border-radius: 14px;
        padding: 18px;
        margin-bottom: 20px;
        background: #fff;
    }

    .field-title {
        font-size: 15px;
        font-weight: 700;
        margin-bottom: 4px;
    }

    .field-desc {
        font-size: 12px;
        color: #6c757d;
        margin-bottom: 14px;
    }
</style>

<div class="container py-4 cms-wrapper">

    <div class="card cms-card">

        <!-- HEADER -->
        <div class="cms-header">

            <h4>
                Edit <?= CHtml::encode($pageTitle) ?>
            </h4>

            <p>
                Kelola konten website dalam Bahasa Indonesia dan Bahasa Inggris,
                serta tentukan apakah komponen ini ditampilkan pada website.
            </p>

        </div>

        <!-- BODY -->
        <div class="cms-body">

            <?php $form = $this->beginWidget('CActiveForm'); ?>

            <div class="row">

                <!-- CONTENT ID -->
                <div class="col-md-6">

                    <div class="field-card h-100">

                        <div class="field-title">
                            Content (ID)
                        </div>

                        <div class="field-desc">
                            Isi konten yang akan ditampilkan dalam Bahasa Indonesia.
                        </div>

                        <?php if ($isParagraph): ?>

                            <?php echo CHtml::hiddenField('Header[content]', $model->content, [
                                'id' => 'content-input'
                            ]); ?>

                            <div id="content-editor" style="height:220px;">
                                <?php echo $model->content; ?>
                            </div>

                        <?php else: ?>

                            <?= $form->textField($model, 'content', [
                                'class' => 'form-control',
                                'placeholder' => 'Masukkan konten Bahasa Indonesia...'
                            ]); ?>

                        <?php endif; ?>

                    </div>

                </div>

                <!-- CONTENT EN -->
                <div class="col-md-6">

                    <div class="field-card h-100">

                        <div class="field-title">
                            Content (EN)
                        </div>

                        <div class="field-desc">
                            Isi konten yang akan ditampilkan dalam Bahasa Inggris.
                        </div>

                        <?php if ($isParagraph): ?>

                            <?php echo CHtml::hiddenField('Header[content_english]', $model->content_english, [
                                'id' => 'content-en-input'
                            ]); ?>

                            <div id="content-en-editor" style="height:220px;">
                                <?php echo $model->content_english; ?>
                            </div>

                        <?php else: ?>

                            <?= $form->textField($model, 'content_english', [
                                'class' => 'form-control',
                                'placeholder' => 'Enter English content...'
                            ]); ?>

                        <?php endif; ?>

                    </div>

                </div>

            </div>

            <!-- STATUS -->
            <?php if ($hasIsActive): ?>

                <div class="field-card">

                    <div class="field-title">
                        Component Status
                    </div>

                    <div class="field-desc">
                        Tentukan apakah komponen ini akan ditampilkan pada website.
                    </div>

                    <div class="d-flex gap-3 flex-wrap">

                        <!-- ACTIVE -->
                        <label class="status-option">

                            <input type="radio"
                                   name="Header[is_active]"
                                   value="1"
                                <?= $isActiveVal === 1 ? 'checked' : '' ?>>

                            <span class="status-active">
                                Active
                            </span>

                            <div class="small text-muted mt-1">
                                Komponen tampil di website.
                            </div>

                        </label>

                        <!-- NON ACTIVE -->
                        <label class="status-option">

                            <input type="radio"
                                   name="Header[is_active]"
                                   value="0"
                                <?= $isActiveVal === 0 ? 'checked' : '' ?>>

                            <span class="status-inactive">
                                Non Active
                            </span>

                            <div class="small text-muted mt-1">
                                Komponen disembunyikan dari website.
                            </div>

                        </label>

                    </div>

                </div>

            <?php endif; ?>

            <!-- ACTION -->
            <div class="action-area d-flex gap-2">

                <button class="btn btn-primary btn-save">
                    Save Changes
                </button>

                <a href="<?= $this->createUrl('index') ?>"
                   class="btn btn-light border btn-cancel">

                    Cancel

                </a>

            </div>

            <?php $this->endWidget(); ?>

        </div>

    </div>

</div>

<?php if ($isParagraph): ?>

    <script>
        (function () {

            const toolbar = [
                [{ font: [] }],
                [{ size: [] }],
                ['bold','italic','underline'],
                [{ list:'ordered' },{ list:'bullet' }],
                [{ align: [] }],
                ['link','clean']
            ];

            const quillID = new Quill('#content-editor', {
                theme: 'snow',
                modules: { toolbar }
            });

            const quillEN = new Quill('#content-en-editor', {
                theme: 'snow',
                modules: { toolbar }
            });

            const inputID = document.getElementById('content-input');
            const inputEN = document.getElementById('content-en-input');

            // INIT EDIT MODE
            quillID.clipboard.dangerouslyPasteHTML(inputID.value || '');
            quillEN.clipboard.dangerouslyPasteHTML(inputEN.value || '');

            // SYNC BEFORE SUBMIT
            document.querySelector('form').addEventListener('submit', function () {
                inputID.value = quillID.root.innerHTML;
                inputEN.value = quillEN.root.innerHTML;
            });

        })();
    </script>

<?php endif; ?>