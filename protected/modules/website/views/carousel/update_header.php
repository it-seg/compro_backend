<link href="<?php echo Yii::app()->baseUrl; ?>/css/quill/quill.snow.css" rel="stylesheet">
<script src="<?php echo Yii::app()->baseUrl; ?>/js/quill/quill.js"></script>
<link rel="stylesheet" href="<?= Yii::app()->baseUrl ?>/css/quill/custom.css">

<?php
$isParagraph = in_array($model->type, [
    'about_value_p1',
    'about_value_p2',
]);
?>


<h4>Edit About Title</h4>
<hr>

<?php $form = $this->beginWidget('CActiveForm'); ?>

<div class="mb-3">
    <label class="form-label">Content (ID)</label>

    <?php if ($isParagraph): ?>

        <?php echo CHtml::hiddenField('Header[content]', $model->content, [
            'id' => 'content-input'
        ]); ?>

        <div id="content-editor" style="height:200px;">
            <?php echo $model->content; ?>
        </div>

    <?php else: ?>

        <?= $form->textField($model, 'content', ['class'=>'form-control']); ?>

    <?php endif; ?>
</div>


<div class="mb-3">
    <label class="form-label">Content (EN)</label>

    <?php if ($isParagraph): ?>

        <?php echo CHtml::hiddenField('Header[content_english]', $model->content_english, [
            'id' => 'content-en-input'
        ]); ?>

        <div id="content-en-editor" style="height:200px;">
            <?php echo $model->content_english; ?>
        </div>

    <?php else: ?>

        <?= $form->textField($model, 'content_english', ['class'=>'form-control']); ?>

    <?php endif; ?>
</div>


<button class="btn btn-primary">Simpan</button>
<a href="<?= $this->createUrl('index') ?>" class="btn btn-secondary">Batal</a>

<?php $this->endWidget(); ?>

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

