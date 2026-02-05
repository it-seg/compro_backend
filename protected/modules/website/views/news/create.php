<link href="<?php echo Yii::app()->baseUrl; ?>/css/quill/quill.snow.css" rel="stylesheet">
<script src="<?php echo Yii::app()->baseUrl; ?>/js/quill/quill.js"></script>
<link rel="stylesheet" href="<?= Yii::app()->baseUrl ?>/css/quill/custom.css">


<h3><?php echo $model->isNewRecord ? 'Create News' : 'Edit News'; ?></h3>
<hr>

<?php $form = $this->beginWidget('CActiveForm', [
    'htmlOptions' => ['enctype' => 'multipart/form-data']
]); ?>

<?php echo $form->errorSummary($model, null, null, [
    'class' => 'alert alert-danger'
]); ?>

<div class="card p-3">

    <!-- ROW META -->
    <div class="row mb-3">
        <div class="col-md-6">
            <?php echo $form->labelEx($model, 'slug'); ?>
            <?php echo $form->textField($model, 'slug', [
                'class' => 'form-control',
                'id' => 'news-slug',
                'readonly' => true
            ]); ?>
            <?php echo $form->error($model, 'slug'); ?>
        </div>

        <div class="col-md-2">
            <?php echo $form->labelEx($model, 'publish_date'); ?>
            <?php echo $form->dateField($model, 'publish_date', ['class' => 'form-control']); ?>
            <?php echo $form->error($model, 'publish_date'); ?>
        </div>

        <div class="col-md-2">
            <?php echo $form->labelEx($model, 'is_main'); ?>
            <?php echo $form->dropDownList($model, 'is_main', [1=>'YES',0=>'NO'], ['class'=>'form-control']); ?>
            <?php echo $form->error($model, 'is_main'); ?>
        </div>

        <div class="col-md-2">
            <?php echo $form->labelEx($model, 'is_active'); ?>
            <?php echo $form->dropDownList($model, 'is_active', [1=>'ACTIVE',0=>'INACTIVE'], ['class'=>'form-control']); ?>
            <?php echo $form->error($model, 'is_active'); ?>
        </div>
    </div>

    <!-- IMAGE -->
    <div class="mb-3">
        <?php echo $form->labelEx($model, 'image'); ?>

        <?php if (!$model->isNewRecord && $model->image): ?>
            <div class="mb-2">
                <input type="text" class="form-control"
                       value="<?php echo CHtml::encode($model->image); ?>" readonly>
            </div>
        <?php endif; ?>

        <!-- PREVIEW (SELALU ADA) -->
        <div id="image-preview-wrapper" style="margin-top:10px;<?php echo $model->image?'':'display:none;'; ?>">
            <img id="image-preview"
                 src="<?php echo $model->image
                     ? Yii::app()->params['websiteImageUrl'].str_replace('/images','',$model->image)
                     : ''; ?>"
                 style="max-width:300px;border:1px solid #ddd;padding:4px;">
        </div>

        <!-- SINGLE FILE INPUT -->
        <input type="file"
               id="news-image-file"
               name="news-image-file"
               class="form-control mt-2"
               accept="image/*">

        <?php echo $form->error($model, 'image'); ?>

        <?php if (!$model->isNewRecord && $model->image): ?>
            <button type="button" class="btn btn-outline-primary btn-sm mt-2" id="btn-change-image">
                Change Image
            </button>
        <?php endif; ?>
    </div>

    <hr>

    <!-- CONTENT -->
    <div class="row">
        <div class="col-md-6">
            <h5>English Content</h5>

            <?php echo $form->labelEx($model, 'title'); ?>
            <?php echo $form->textField($model, 'title', [
                'class'=>'form-control','id'=>'news-title'
            ]); ?>
            <?php echo $form->error($model, 'title'); ?>

            <?php echo $form->labelEx($model, 'short_content'); ?>
            <?php echo $form->textArea($model, 'short_content', ['class'=>'form-control','rows'=>3]); ?>

            <?php echo $form->labelEx($model, 'content'); ?>
            <?php echo $form->hiddenField($model, 'content', ['id' => 'content-input']); ?>

            <div id="content-editor" style="height:300px;">
                <?php echo $model->content; ?>
            </div>

        </div>

        <div class="col-md-6">
            <h5>Indonesian Content</h5>

            <?php echo $form->labelEx($model, 'title_ind'); ?>
            <?php echo $form->textField($model, 'title_ind', ['class'=>'form-control']); ?>

            <?php echo $form->labelEx($model, 'short_content_ind'); ?>
            <?php echo $form->textArea($model, 'short_content_ind', ['class'=>'form-control','rows'=>3]); ?>

            <?php echo $form->labelEx($model, 'content_ind'); ?>
            <?php echo $form->hiddenField($model, 'content_ind', ['id' => 'content-ind-input']); ?>

            <div id="content-ind-editor" style="height:300px;">
                <?php echo $model->content_ind; ?>
            </div>

        </div>
    </div>

    <button class="btn btn-success mt-3">
        <i class="bi bi-save"></i> Save
    </button>
</div>

<?php $this->endWidget(); ?>

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

        const quillEN = new Quill('#content-editor', {
            theme: 'snow',
            modules: { toolbar }
        });

        const quillID = new Quill('#content-ind-editor', {
            theme: 'snow',
            modules: { toolbar }
        });

        const inputEN = document.getElementById('content-input');
        const inputID = document.getElementById('content-ind-input');

        // EDIT MODE INIT
        quillEN.clipboard.dangerouslyPasteHTML(inputEN.value || '');
        quillID.clipboard.dangerouslyPasteHTML(inputID.value || '');

        // SYNC BEFORE SUBMIT
        document.querySelector('form').addEventListener('submit', function () {
            inputEN.value = quillEN.root.innerHTML;
            inputID.value = quillID.root.innerHTML;
        });

    })();

    (function () {
        const fileInput = document.getElementById('news-image-file');
        const img = document.getElementById('image-preview');
        const wrapper = document.getElementById('image-preview-wrapper');
        const btn = document.getElementById('btn-change-image');

        if (btn) btn.onclick = () => fileInput.click();

        fileInput.addEventListener('change', function () {
            const file = this.files[0];
            if (!file) return;

            const reader = new FileReader();
            reader.onload = e => {
                img.src = e.target.result;
                wrapper.style.display = 'block';
            };
            reader.readAsDataURL(file);
        });
    })();
    (function () {
        const t=document.getElementById('news-title');
        const s=document.getElementById('news-slug');
        if(!t||!s)return;
        t.addEventListener('input',()=>s.value=t.value.toLowerCase().replace(/[^a-z0-9]+/g,'-').replace(/^-|-$/g,''));
    })();
</script>
