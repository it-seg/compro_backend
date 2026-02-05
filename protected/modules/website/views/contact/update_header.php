<link href="<?php echo Yii::app()->baseUrl; ?>/css/quill/quill.snow.css" rel="stylesheet">
<script src="<?php echo Yii::app()->baseUrl; ?>/js/quill/quill.js"></script>
<link rel="stylesheet" href="<?= Yii::app()->baseUrl ?>/css/quill/custom.css">

<?php
$isParagraph = in_array($model->key, [
    'about_value_p1',
    'about_value_p2',
]);
?>


<h4>Edit About Title</h4>
<hr>

<?php $form = $this->beginWidget('CActiveForm'); ?>

<div class="mb-3">
    <label class="form-label">Setting (ID)</label>

    <?php if ($isParagraph): ?>

        <?php echo CHtml::hiddenField('Header[value]', $model->value, [
            'id' => 'value-input'
        ]); ?>

        <div id="value-editor" style="height:200px;">
            <?php echo $model->value; ?>
        </div>

    <?php else: ?>

        <?= $form->textField($model, 'value', ['class'=>'form-control']); ?>

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

            const quillID = new Quill('#value-editor', {
                theme: 'snow',
                modules: { toolbar }
            });

            const quillEN = new Quill('#value-en-editor', {
                theme: 'snow',
                modules: { toolbar }
            });

            const inputID = document.getElementById('value-input');
            const inputEN = document.getElementById('value-en-input');

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

