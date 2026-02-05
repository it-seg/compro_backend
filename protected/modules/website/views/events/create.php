<link href="<?= Yii::app()->baseUrl; ?>/css/quill/quill.snow.css" rel="stylesheet">
<script src="<?= Yii::app()->baseUrl; ?>/js/quill/quill.js"></script>
<link rel="stylesheet" href="<?= Yii::app()->baseUrl ?>/css/quill/custom.css">


<h3><?= $model->isNewRecord ? 'Create Event' : 'Edit Event'; ?></h3>
<hr>

<?php $form = $this->beginWidget('CActiveForm', [
    'htmlOptions' => ['enctype' => 'multipart/form-data']
]); ?>

<?php echo $form->errorSummary($model, null, null, [
    'class' => 'alert alert-danger'
]); ?>

<div class="card p-3">

    <!-- IMAGE -->
    <div class="mb-3">
        <?php echo $form->labelEx($model, 'image'); ?>

        <?php if (!$model->isNewRecord && $model->image_url): ?>
            <div class="mb-2">
                <input type="text" class="form-control"
                       value="<?= CHtml::encode($model->image_url); ?>" readonly>
            </div>
        <?php endif; ?>

        <div id="image-preview-wrapper" style="margin-top:10px;<?= $model->image_url ? '' : 'display:none;' ?>">
            <img id="image-preview"
                 src="<?= $model->image_url
                     ? Yii::app()->params['websiteImageUrl'] . str_replace('/images', '', $model->image_url)
                     : '' ?>"
                 style="max-width:300px;border:1px solid #ddd;padding:4px;">
        </div>

        <input type="file"
               id="event-image-file"
               name="event-image-file"
               class="form-control mt-2"
               accept="image/*">

        <?php if (!$model->isNewRecord && $model->image_url): ?>
            <button type="button" class="btn btn-outline-primary btn-sm mt-2"
                    id="btn-change-image">
                Change Image
            </button>
        <?php endif; ?>
    </div>
    <div class="row mb-3">
        <div class="col-md-4">
            <?php echo $form->labelEx($model, 'event_date'); ?>
            <?php echo $form->dateField($model, 'event_date', [
                'class' => 'form-control'
            ]); ?>
        </div>

        <div class="col-md-4">
            <?php echo $form->labelEx($model, 'event_time'); ?>
            <?php echo $form->timeField($model, 'event_time', [
                'class' => 'form-control'
            ]); ?>
        </div>

        <div class="col-md-4">
            <?php echo $form->labelEx($model, 'is_active'); ?>

            <div class="mt-2">
                <?php echo $form->radioButtonList(
                    $model,
                    'is_active',
                    [1 => 'Active', 0 => 'Inactive'],
                    [
                        'separator' => ' ',
                        'labelOptions' => ['class' => 'me-3'],
                        'template' => '{input} {label}',
                    ]
                ); ?>
            </div>
        </div>


    </div>
    <hr>

    <!-- CONTENT -->
    <div class="row">
        <div class="col-md-6">
            <h5>English Content</h5>

            <?php echo $form->labelEx($model, 'title'); ?>
            <?php echo $form->textField($model, 'title', ['class' => 'form-control']); ?>

            <?php echo $form->labelEx($model, 'description'); ?>
            <?php echo $form->hiddenField($model, 'description', ['id' => 'desc-en']); ?>

            <div id="desc-en-editor" style="height:250px;">
                <?= $model->description; ?>
            </div>
        </div>

        <div class="col-md-6">
            <h5>Indonesian Content</h5>

            <?php echo $form->labelEx($model, 'title_ind'); ?>
            <?php echo $form->textField($model, 'title_ind', ['class' => 'form-control']); ?>

            <?php echo $form->labelEx($model, 'description_ind'); ?>
            <?php echo $form->hiddenField($model, 'description_ind', ['id' => 'desc-id']); ?>

            <div id="desc-id-editor" style="height:250px;">
                <?= $model->description_ind; ?>
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
            ['bold', 'italic', 'underline'],
            [{list: 'ordered'}, {list: 'bullet'}],
            [{align: []}],
            ['link', 'clean']
        ];

        const qEN = new Quill('#desc-en-editor', {
            theme: 'snow', modules: {toolbar}
        });
        const qID = new Quill('#desc-id-editor', {
            theme: 'snow', modules: {toolbar}
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
        const btn = document.getElementById('btn-change-image');

        if (btn) btn.onclick = () => input.click();

        input.addEventListener('change', () => {
            const f = input.files[0];
            if (!f) return;
            const r = new FileReader();
            r.onload = e => {
                img.src = e.target.result;
                wrap.style.display = 'block';
            };
            r.readAsDataURL(f);
        });
    })();
</script>
