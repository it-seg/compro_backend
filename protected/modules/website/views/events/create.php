<link href="<?= Yii::app()->baseUrl; ?>/css/quill/quill.snow.css" rel="stylesheet">
<script src="<?= Yii::app()->baseUrl; ?>/js/quill/quill.js"></script>
<link rel="stylesheet" href="<?= Yii::app()->baseUrl ?>/css/quill/custom.css">

<style>
    .event-form-wrapper {
        max-width: 1280px;
        margin: auto;
    }

    .event-form-card {
        border: 0;
        border-radius: 18px;
        overflow: hidden;
        box-shadow: 0 6px 24px rgba(0,0,0,0.05);
        background: #fff;
    }

    .event-header {
        background: linear-gradient(135deg, #dc3545, #b02a37);
        color: #fff;
        padding: 18px 24px;
        position: relative;
        overflow: hidden;
    }

    .event-header::after {
        content: '';
        position: absolute;
        right: -60px;
        top: -60px;
        width: 200px;
        height: 200px;
        background: rgba(255,255,255,.07);
        border-radius: 50%;
    }

    .event-header h3 {
        margin: 0;
        font-size: 24px;
        font-weight: 700;
        position: relative;
        z-index: 2;
    }

    .event-header p {
        margin: 4px 0 0;
        font-size: 12px;
        opacity: .92;
        position: relative;
        z-index: 2;
    }

    .event-body {
        padding: 20px;
    }

    .section-card {
        border: 1px solid #eee;
        border-radius: 14px;
        padding: 16px;
        background: #fff;
        margin-bottom: 18px;
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
        margin-bottom: 12px;
    }

    .form-label {
        font-size: 12px;
        font-weight: 700;
        margin-bottom: 5px;
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
        border-color: #dc3545;
    }

    .ql-toolbar {
        border-radius: 10px 10px 0 0;
    }

    .ql-container {
        border-radius: 0 0 10px 10px;
        font-size: 13px;
    }

    .upload-box {
        border: 2px dashed #d7dce1;
        border-radius: 14px;
        padding: 14px;
        background: #fafafa;
        transition: .2s;
    }

    .upload-box:hover {
        border-color: #dc3545;
        background: #fff5f5;
    }

    .upload-top {
        display: flex;
        align-items: center;
        gap: 12px;
        margin-bottom: 12px;
    }

    .upload-icon {
        width: 48px;
        height: 48px;
        border-radius: 12px;
        background: #fff;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 24px;
        border: 1px solid #eee;
        flex-shrink: 0;
    }

    .upload-title {
        font-size: 14px;
        font-weight: 700;
        margin-bottom: 2px;
    }

    .upload-subtitle {
        font-size: 11px;
        color: #6c757d;
    }

    .preview-wrapper {
        margin-top: 12px;
    }

    .preview-wrapper img {
        width: 100%;
        max-width: 260px;
        height: 160px;
        object-fit: cover;
        border-radius: 12px;
        border: 1px solid #eee;
        display: block;
    }

    .status-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit,minmax(180px,1fr));
        gap: 10px;
    }

    .status-option {
        border: 1px solid #eee;
        border-radius: 12px;
        padding: 12px;
        transition: .2s;
        cursor: pointer;
        background: #fff;
    }

    .status-option:hover {
        border-color: #dc3545;
        background: #fff8f8;
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

    .action-area {
        border-top: 1px solid #eee;
        padding-top: 18px;
        margin-top: 6px;
    }

    .btn-save {
        min-width: 140px;
        height: 42px;
        border-radius: 10px;
        font-weight: 700;
        font-size: 12px;
    }

    .btn-cancel {
        min-width: 110px;
        height: 42px;
        border-radius: 10px;
        font-size: 12px;
        font-weight: 600;
    }

    .alert-danger {
        border-radius: 12px;
    }

    .current-image-name {
        font-size: 11px;
        color: #6c757d;
        margin-top: 8px;
        word-break: break-word;
    }
</style>

<div class="container py-3 event-form-wrapper">

    <div class="event-form-card">

        <!-- HEADER -->
        <div class="event-header">

            <h3>
                <?= $model->isNewRecord ? 'Create Event' : 'Edit Event'; ?>
            </h3>

            <p>
                Kelola informasi event website dengan tampilan modern dan ringkas.
            </p>

        </div>

        <!-- BODY -->
        <div class="event-body">

            <?php $form = $this->beginWidget('CActiveForm', [
                'htmlOptions' => ['enctype' => 'multipart/form-data']
            ]); ?>

            <?php echo $form->errorSummary($model, null, null, [
                'class' => 'alert alert-danger'
            ]); ?>

            <!-- IMAGE + EVENT INFO -->
            <div class="row g-3">

                <!-- IMAGE -->
                <div class="col-md-5">

                    <div class="section-card h-100">

                        <div class="section-title">
                            Event Image
                        </div>

                        <div class="section-desc">
                            Thumbnail utama event website.
                        </div>

                        <div class="upload-box">

                            <div class="upload-top">

                                <div class="upload-icon">
                                    🎉
                                </div>

                                <div>

                                    <div class="upload-title">
                                        Upload Event Image
                                    </div>

                                    <div class="upload-subtitle">
                                        JPG, PNG, WEBP • 1200×800 px
                                    </div>

                                </div>

                            </div>

                            <input type="file"
                                   id="event-image-file"
                                   name="event-image-file"
                                   class="form-control"
                                   accept="image/*">

                            <!-- PREVIEW -->
                            <div class="preview-wrapper"
                                 id="image-preview-wrapper"
                                 style="<?= $model->image_url ? 'display:block;' : 'display:none;' ?>">

                                <img id="image-preview"
                                     src="<?= $model->image_url
                                         ? Yii::app()->params['websiteImageUrl']
                                         . str_replace('%2F','/', rawurlencode($model->image_url))
                                         . '?v=' . time()
                                         : '' ?>">

                                <?php if (!$model->isNewRecord && $model->image_url): ?>

                                    <div class="current-image-name">

                                        <?= CHtml::encode(
                                            basename($model->image_url)
                                        ) ?>

                                    </div>

                                <?php endif; ?>

                            </div>

                        </div>

                    </div>

                </div>

                <!-- EVENT INFO -->
                <div class="col-md-7">

                    <div class="section-card h-100">

                        <div class="section-title">
                            Event Information
                        </div>

                        <div class="section-desc">
                            Tanggal, waktu, dan status event.
                        </div>

                        <div class="row g-3">

                            <div class="col-md-4">

                                <?php echo $form->labelEx($model, 'event_date', [
                                    'class' => 'form-label'
                                ]); ?>

                                <?php echo $form->dateField($model, 'event_date', [
                                    'class' => 'form-control'
                                ]); ?>

                            </div>

                            <div class="col-md-4">

                                <?php echo $form->labelEx($model, 'event_time', [
                                    'class' => 'form-label'
                                ]); ?>

                                <?php echo $form->timeField($model, 'event_time', [
                                    'class' => 'form-control'
                                ]); ?>

                            </div>

                            <div class="col-md-4">

                                <label class="form-label">
                                    Event Status
                                </label>

                                <div class="status-grid">

                                    <label class="status-option">

                                        <input type="radio"
                                               name="Events[is_active]"
                                               value="1"
                                            <?= $model->is_active == 1 ? 'checked' : '' ?>>

                                        <span class="status-title text-success">
                                            Active
                                        </span>

                                        <div class="status-desc">
                                            Tampil di website
                                        </div>

                                    </label>

                                    <label class="status-option">

                                        <input type="radio"
                                               name="Events[is_active]"
                                               value="0"
                                            <?= $model->is_active == 0 ? 'checked' : '' ?>>

                                        <span class="status-title text-danger">
                                            Inactive
                                        </span>

                                        <div class="status-desc">
                                            Disembunyikan
                                        </div>

                                    </label>

                                </div>

                            </div>

                        </div>

                    </div>

                </div>

            </div>

            <!-- CONTENT -->
            <div class="row g-3">

                <!-- ENGLISH -->
                <div class="col-md-6">

                    <div class="section-card h-100">

                        <div class="section-title">
                            🇺🇸 English Content
                        </div>

                        <div class="section-desc">
                            Konten bahasa Inggris.
                        </div>

                        <?php echo $form->labelEx($model, 'title', [
                            'class' => 'form-label'
                        ]); ?>

                        <?php echo $form->textField($model, 'title', [
                            'class' => 'form-control',
                            'placeholder' => 'Enter English title...'
                        ]); ?>

                        <div class="mt-3">

                            <?php echo $form->labelEx($model, 'description', [
                                'class' => 'form-label'
                            ]); ?>

                            <?php echo $form->hiddenField($model, 'description', [
                                'id' => 'desc-en'
                            ]); ?>

                            <div id="desc-en-editor" style="height:220px;">
                                <?= $model->description; ?>
                            </div>

                        </div>

                    </div>

                </div>

                <!-- INDONESIA -->
                <div class="col-md-6">

                    <div class="section-card h-100">

                        <div class="section-title">
                            🇮🇩 Indonesian Content
                        </div>

                        <div class="section-desc">
                            Konten bahasa Indonesia.
                        </div>

                        <?php echo $form->labelEx($model, 'title_ind', [
                            'class' => 'form-label'
                        ]); ?>

                        <?php echo $form->textField($model, 'title_ind', [
                            'class' => 'form-control',
                            'placeholder' => 'Masukkan judul Indonesia...'
                        ]); ?>

                        <div class="mt-3">

                            <?php echo $form->labelEx($model, 'description_ind', [
                                'class' => 'form-label'
                            ]); ?>

                            <?php echo $form->hiddenField($model, 'description_ind', [
                                'id' => 'desc-id'
                            ]); ?>

                            <div id="desc-id-editor" style="height:220px;">
                                <?= $model->description_ind; ?>
                            </div>

                        </div>

                    </div>

                </div>

            </div>

            <!-- ACTION -->
            <div class="action-area d-flex gap-2">

                <button class="btn btn-success btn-save">

                    <i class="bi bi-save"></i>
                    Save Event

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

<script>
    (function () {

        const toolbar = [
            ['bold', 'italic', 'underline'],
            [{ list: 'ordered' }, { list: 'bullet' }],
            [{ align: [] }],
            ['link', 'clean']
        ];

        const qEN = new Quill('#desc-en-editor', {
            theme: 'snow',
            modules: { toolbar }
        });

        const qID = new Quill('#desc-id-editor', {
            theme: 'snow',
            modules: { toolbar }
        });

        const inEN = document.getElementById('desc-en');
        const inID = document.getElementById('desc-id');

        qEN.clipboard.dangerouslyPasteHTML(inEN.value || '');
        qID.clipboard.dangerouslyPasteHTML(inID.value || '');

        document.querySelector('form').addEventListener('submit', () => {

            inEN.value = qEN.root.innerHTML;
            inID.value = qID.root.innerHTML;

        });

    })();

    (function () {

        const input = document.getElementById('event-image-file');
        const img = document.getElementById('image-preview');
        const wrap = document.getElementById('image-preview-wrapper');

        input.addEventListener('change', () => {

            const file = input.files[0];

            if (!file) return;

            const reader = new FileReader();

            reader.onload = e => {

                img.src = e.target.result;
                wrap.style.display = 'block';

            };

            reader.readAsDataURL(file);

        });

    })();
</script>