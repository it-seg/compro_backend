<link href="<?php echo Yii::app()->baseUrl; ?>/css/quill/quill.snow.css" rel="stylesheet">
<script src="<?php echo Yii::app()->baseUrl; ?>/js/quill/quill.js"></script>
<link rel="stylesheet" href="<?= Yii::app()->baseUrl ?>/css/quill/custom.css">

<?php
$isParagraph = in_array($model->key, [
    'about_value_p1',
    'about_value_p2',
]);

$settingLabels = [
    'address' => 'Address',
    'phone' => 'Phone Number',
    'email' => 'Email Address',
    'instagram' => 'Instagram',
    'facebook' => 'Facebook',
    'whatsapp' => 'WhatsApp Number',
    'map' => 'Google Maps',
];

$pageTitle = $settingLabels[$model->key] ?? ucfirst($model->key);
?>

<style>
    .cms-wrapper {
        max-width: 760px;
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

    .field-card {
        border: 1px solid #eee;
        border-radius: 14px;
        padding: 18px;
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

    .form-control {
        border-radius: 10px;
        min-height: 46px;
        border: 1px solid #dcdcdc;
        box-shadow: none !important;
        font-size: 14px;
    }

    .form-control:focus {
        border-color: #0d6efd;
    }

    .ql-toolbar {
        border-radius: 10px 10px 0 0;
    }

    .ql-container {
        border-radius: 0 0 10px 10px;
        font-size: 14px;
    }

    .action-area {
        border-top: 1px solid #eee;
        margin-top: 24px;
        padding-top: 18px;
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

    .map-preview {
        margin-top: 14px;
        border-radius: 12px;
        overflow: hidden;
        border: 1px solid #eee;
    }

    .map-preview iframe {
        width: 100%;
        height: 280px;
        border: 0;
    }

    .setting-icon {
        width: 48px;
        height: 48px;
        border-radius: 14px;
        background: rgba(255,255,255,.15);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 22px;
        margin-bottom: 10px;
    }
</style>

<div class="container py-4 cms-wrapper">

    <div class="card cms-card">

        <!-- HEADER -->
        <div class="cms-header">

            <div class="setting-icon">

                <?php
                switch ($model->key) {

                    case 'phone':
                        echo '📞';
                        break;

                    case 'email':
                        echo '✉️';
                        break;

                    case 'instagram':
                        echo '📷';
                        break;

                    case 'facebook':
                        echo '📘';
                        break;

                    case 'address':
                        echo '📍';
                        break;

                    case 'whatsapp':
                    case 'whatsapp_number':
                        echo '💬';
                        break;

                    case 'map':
                        echo '🗺️';
                        break;

                    default:
                        echo '⚙️';
                        break;
                }
                ?>

            </div>

            <h4>
                Edit <?= CHtml::encode($pageTitle) ?>
            </h4>

            <p>
                Perbarui informasi contact website agar selalu up to date.
            </p>

        </div>

        <!-- BODY -->
        <div class="cms-body">

            <?php $form = $this->beginWidget('CActiveForm'); ?>

            <div class="field-card">

                <div class="field-title">
                    Setting Value
                </div>

                <div class="field-desc">

                    <?php if ($model->key === 'map'): ?>

                        Masukkan embed URL Google Maps untuk preview lokasi.

                    <?php else: ?>

                        Masukkan informasi yang akan ditampilkan pada website.

                    <?php endif; ?>

                </div>

                <?php if ($isParagraph): ?>

                    <?php echo CHtml::hiddenField('Header[value]', $model->value, [
                        'id' => 'value-input'
                    ]); ?>

                    <div id="value-editor" style="height:220px;">
                        <?php echo $model->value; ?>
                    </div>

                <?php else: ?>

                    <?= $form->textField($model, 'value', [
                        'class' => 'form-control',
                        'placeholder' => 'Enter value...'
                    ]); ?>

                <?php endif; ?>

                <!-- MAP PREVIEW -->
                <?php if ($model->key === 'map' && !empty($model->value)): ?>

                    <div class="map-preview">

                        <iframe
                                src="<?= CHtml::encode($model->value) ?>"
                                allowfullscreen=""
                                loading="lazy"
                                referrerpolicy="no-referrer-when-downgrade">
                        </iframe>

                    </div>

                <?php endif; ?>

            </div>

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

            const quillID = new Quill('#value-editor', {
                theme: 'snow',
                modules: { toolbar }
            });

            const inputID = document.getElementById('value-input');

            // INIT EDIT MODE
            quillID.clipboard.dangerouslyPasteHTML(inputID.value || '');

            // SYNC BEFORE SUBMIT
            document.querySelector('form').addEventListener('submit', function () {
                inputID.value = quillID.root.innerHTML;
            });

        })();
    </script>

<?php endif; ?>