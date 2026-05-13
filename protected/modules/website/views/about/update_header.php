<link href="<?= Yii::app()->baseUrl; ?>/css/quill/quill.snow.css" rel="stylesheet">
<script src="<?= Yii::app()->baseUrl; ?>/js/quill/quill.js"></script>
<link rel="stylesheet" href="<?= Yii::app()->baseUrl ?>/css/quill/custom.css">

<?php

$isParagraph = in_array($model->type, [
    'about_value_p1',
    'about_value_p2',
]);

$labels = [
    'about_title'      => 'About Title',
    'about_sub_title'  => 'About Subtitle',
    'about_button'     => 'About Button',
    'about_value_p1'   => 'About Value Point 1',
    'about_value_p2'   => 'About Value Point 2',
];

$title = isset($labels[$model->type])
    ? $labels[$model->type]
    : ucfirst(str_replace('_', ' ', $model->type));

?>

<style>
    .about-edit-wrapper {
        max-width: 1280px;
        margin: auto;
    }

    .about-edit-card {
        border: 0;
        border-radius: 18px;
        overflow: hidden;
        background: #fff;
        box-shadow: 0 6px 24px rgba(0,0,0,.05);
    }

    .about-header {
        background: linear-gradient(135deg, #212529, #343a40);
        color: #fff;
        padding: 20px 24px;
        position: relative;
        overflow: hidden;
    }

    .about-header::after {
        content: '';
        position: absolute;
        right: -50px;
        top: -50px;
        width: 180px;
        height: 180px;
        background: rgba(255,255,255,.06);
        border-radius: 50%;
    }

    .about-header h3 {
        margin: 0;
        font-size: 24px;
        font-weight: 700;
        position: relative;
        z-index: 2;
    }

    .about-header p {
        margin: 4px 0 0;
        font-size: 12px;
        opacity: .92;
        position: relative;
        z-index: 2;
    }

    .mini-badge {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        background: rgba(255,255,255,.12);
        border: 1px solid rgba(255,255,255,.08);
        padding: 6px 12px;
        border-radius: 999px;
        font-size: 11px;
        margin-top: 10px;
        position: relative;
        z-index: 2;
    }

    .about-body {
        padding: 22px;
    }

    .info-note {
        background: #f8f9fa;
        border: 1px dashed #dee2e6;
        border-radius: 12px;
        padding: 12px;
        font-size: 11px;
        color: #6c757d;
        margin-bottom: 16px;
    }

    .section-card {
        border: 1px solid #eee;
        border-radius: 16px;
        padding: 18px;
        background: #fff;
        height: 100%;
    }

    .section-title {
        font-size: 15px;
        font-weight: 700;
        margin-bottom: 3px;
        color: #212529;
    }

    .section-desc {
        font-size: 11px;
        color: #6c757d;
        margin-bottom: 14px;
    }

    .form-label {
        font-size: 12px;
        font-weight: 700;
        margin-bottom: 6px;
        color: #495057;
    }

    .form-control {
        border-radius: 10px;
        min-height: 42px;
        border: 1px solid #dee2e6;
        box-shadow: none !important;
        font-size: 12px;
    }

    .form-control:focus {
        border-color: #212529;
    }

    .ql-toolbar {
        border-radius: 10px 10px 0 0;
    }

    .ql-container {
        border-radius: 0 0 10px 10px;
        font-size: 13px;
    }

    .action-area {
        border-top: 1px solid #eee;
        margin-top: 18px;
        padding-top: 18px;
    }

    .btn-save {
        min-width: 140px;
        height: 42px;
        border-radius: 10px;
        font-size: 12px;
        font-weight: 700;
    }

    .btn-cancel {
        min-width: 110px;
        height: 42px;
        border-radius: 10px;
        font-size: 12px;
        font-weight: 600;
    }

    .status-grid {
        display: flex;
        gap: 12px;
        margin-top: 10px;
    }

    .status-option {
        border: 1px solid #eee;
        border-radius: 12px;
        padding: 12px 14px;
        min-width: 180px;
        cursor: pointer;
        transition: .2s;
        background: #fff;
    }

    .status-option:hover {
        border-color: #212529;
        background: #fafafa;
    }

    .status-option input {
        margin-right: 6px;
    }

    .status-title {
        font-size: 13px;
        font-weight: 700;
    }

    .status-desc {
        font-size: 11px;
        color: #6c757d;
        margin-top: 2px;
    }

    .alert-danger {
        border-radius: 12px;
    }
</style>

<div class="container py-3 about-edit-wrapper">

    <div class="about-edit-card">

        <!-- HEADER -->
        <div class="about-header">

            <h3>
                Edit About Content
            </h3>

            <p>
                Kelola konten halaman About Website dengan tampilan modern dan profesional.
            </p>

            <div class="mini-badge">
                ✨ <?= CHtml::encode($title) ?>
            </div>

        </div>

        <!-- BODY -->
        <div class="about-body">

            <?php $form = $this->beginWidget('CActiveForm'); ?>

            <?php echo $form->errorSummary($model, null, null, [
                'class' => 'alert alert-danger'
            ]); ?>

            <div class="row g-3">

                <!-- INDONESIA -->
                <div class="col-md-6">

                    <div class="section-card h-100">

                        <div class="section-title">
                            🇮🇩 Bahasa Indonesia
                        </div>

                        <div class="section-desc">
                            Konten halaman About versi Indonesia.
                        </div>

                        <label class="form-label">
                            Content (ID)
                        </label>

                        <?php if ($isParagraph): ?>

                            <?= CHtml::hiddenField(
                                'Header[content]',
                                $model->content,
                                ['id' => 'content-input']
                            ); ?>

                            <div id="content-editor" style="height:240px;">
                                <?= $model->content; ?>
                            </div>

                        <?php else: ?>

                            <?= $form->textField($model, 'content', [
                                'class' => 'form-control',
                                'placeholder' => 'Masukkan content bahasa Indonesia...'
                            ]); ?>

                        <?php endif; ?>

                    </div>

                </div>

                <!-- ENGLISH -->
                <div class="col-md-6">

                    <div class="section-card h-100">

                        <div class="section-title">
                            🇺🇸 English Version
                        </div>

                        <div class="section-desc">
                            About page content in English.
                        </div>

                        <label class="form-label">
                            Content (EN)
                        </label>

                        <?php if ($isParagraph): ?>

                            <?= CHtml::hiddenField(
                                'Header[content_english]',
                                $model->content_english,
                                ['id' => 'content-en-input']
                            ); ?>

                            <div id="content-en-editor" style="height:240px;">
                                <?= $model->content_english; ?>
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

            <?php
            $hasIsActive = isset($model->is_active);
            $isActiveVal = $hasIsActive ? (int)$model->is_active : 1;
            ?>

            <?php if ($hasIsActive): ?>

                <div class="section-card mt-3">

                    <div class="section-title">
                        Component Status
                    </div>

                    <div class="section-desc">
                        Tentukan apakah item ini akan tampil di website atau tidak.
                    </div>

                    <div class="status-grid">

                        <!-- ACTIVE -->
                        <label class="status-option">

                            <input type="radio"
                                   name="Header[is_active]"
                                   value="1"
                                <?= $isActiveVal === 1 ? 'checked' : '' ?>>

                            <span class="status-title text-success">
                                Active
                            </span>

                            <div class="status-desc">
                                Konten tampil di website
                            </div>

                        </label>

                        <!-- NON ACTIVE -->
                        <label class="status-option">

                            <input type="radio"
                                   name="Header[is_active]"
                                   value="0"
                                <?= $isActiveVal === 0 ? 'checked' : '' ?>>

                            <span class="status-title text-danger">
                                Non Active
                            </span>

                            <div class="status-desc">
                                Konten disembunyikan
                            </div>

                        </label>

                    </div>

                </div>

            <?php endif; ?>

            <!-- ACTION -->
            <div class="action-area d-flex gap-2">

                <button class="btn btn-dark btn-save">

                    <i class="bi bi-save"></i>
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