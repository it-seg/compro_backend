<h3><?= $model->isNewRecord ? 'Create Menu' : 'Edit Menu'; ?></h3>
<hr>

<?php $form = $this->beginWidget('CActiveForm'); ?>

<div class="card p-3">
    <!-- ROW 1 : SLUG | FOLDER | ACTIVE | SORT -->
    <div class="row mb-3">

        <!-- SLUG -->
        <div class="col-md-3">
            <?= $form->labelEx($model,'slug'); ?>
            <?= $form->textField($model,'slug',['class'=>'form-control']); ?>
            <?= $form->error($model,'slug'); ?>
        </div>

        <!-- FOLDER IMAGES -->
        <div class="col-md-3">
            <label>Folder Images</label>
            <input type="text"
                   name="folder_name"
                   class="form-control"
                   placeholder="contoh: food"
                   value="<?= $model->isNewRecord ? '' : basename($model->images_folder_url) ?>"
                <?= !$model->isNewRecord ? 'readonly' : '' ?>
                   pattern="[A-Za-z]+"
                   title="Hanya boleh 1 kata alfabet (a-z)"
                   oninput="this.value=this.value.replace(/[^a-zA-Z]/g,'')">

            <small class="text-muted d-block">
                1 kata (a–z)
            </small>
        </div>

        <!-- ACTIVE -->
        <div class="col-md-3">
            <?= $form->labelEx($model,'is_active'); ?>
            <?= $form->dropDownList(
                $model,
                'is_active',
                $is_active,
                ['class'=>'form-control']
            ); ?>
            <?= $form->error($model,'is_active'); ?>
        </div>

        <!-- SORT -->
        <div class="col-md-3">
            <?= $form->labelEx($model,'sort_order'); ?>
            <?= $form->numberField($model,'sort_order',['class'=>'form-control']); ?>
            <?= $form->error($model,'sort_order'); ?>
        </div>

    </div>

    <!-- ROW 2 : ENGLISH | INDONESIA -->
    <div class="row mb-3">

        <!-- NAME EN -->
        <div class="col-md-6">
            <?= $form->labelEx($model,'name'); ?>
            <?= $form->textField($model,'name',['class'=>'form-control']); ?>
            <?= $form->error($model,'name'); ?>
        </div>

        <!-- NAME ID -->
        <div class="col-md-6">
            <?= $form->labelEx($model,'name_ind'); ?>
            <?= $form->textField($model,'name_ind',['class'=>'form-control']); ?>
            <?= $form->error($model,'name_ind'); ?>
        </div>

    </div>


    <!-- SAVE -->
    <button class="btn btn-success">
        <i class="bi bi-save"></i> Save
    </button>

</div>

<?php if ($model->isNewRecord): ?>
    <div class="alert alert-info mt-3">
        💡 Images bisa diupload setelah data disimpan.
    </div>
<?php endif; ?>

<!-- IMAGES (EDIT ONLY) -->
<?php if (!$model->isNewRecord): ?>
    <hr>

    <div class="row align-items-center mb-3">
        <div class="col-md-6">
            <h5 class="mb-1">Images</h5>
            <small class="text-muted">
                Folder: <?= CHtml::encode($model->images_folder_url) ?>
            </small>
        </div>
        <div class="col-md-6 text-end">
            <input type="file" id="imageInput" accept="image/*" hidden>
            <button type="button" id="uploadBtn" class="btn btn-sm btn-primary">
                + Upload Image
            </button>
        </div>
    </div>

    <?php if (!empty($images)): ?>
        <div class="row g-3 mb-4">
            <?php foreach ($images as $img): ?>
                <div class="col-xl-2 col-lg-3 col-md-4 col-6">
                    <div class="position-relative text-center">
                        <img src="<?= CHtml::encode($img['url']) ?>"
                             class="img-fluid rounded"
                             style="height:130px; object-fit:cover;">

                        <?php if (preg_match('/^cover\./i',$img['name'])): ?>
                            <span class="badge bg-success position-absolute top-0 start-0 m-1">
                            COVER
                        </span>
                        <?php else: ?>
                            <button type="button"
                                    class="btn btn-warning btn-sm position-absolute bottom-0 start-50 translate-middle-x set-cover"
                                    data-file="<?= CHtml::encode($img['name']) ?>"
                                    data-folder="<?= CHtml::encode($model->images_folder_url) ?>">
                                Set as Cover
                            </button>
                        <?php endif; ?>

                        <button type="button"
                                class="btn btn-danger btn-sm position-absolute top-0 end-0 delete-image"
                                data-file="<?= CHtml::encode($img['name']) ?>"
                                data-folder="<?= CHtml::encode($model->images_folder_url) ?>">
                            ×
                        </button>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php else: ?>
        <p class="text-muted">No images found.</p>
    <?php endif; ?>
<?php endif; ?>

<?php $this->endWidget(); ?>

<!-- SCRIPT -->
<script>
    const CSRF_TOKEN = '<?= Yii::app()->request->csrfToken ?>';

    /* UPLOAD */
    document.getElementById('uploadBtn')?.addEventListener('click',()=>{
        document.getElementById('imageInput').click();
    });

    document.getElementById('imageInput')?.addEventListener('change',function(){
        if(!this.files.length) return;

        const fd = new FormData();
        fd.append('YII_CSRF_TOKEN', CSRF_TOKEN);
        fd.append('folder', '<?= CHtml::encode($model->images_folder_url) ?>');
        fd.append('image', this.files[0]);

        fetch('<?= Yii::app()->createUrl("website/menu/uploadImage") ?>',{
            method:'POST',
            body: fd
        }).then(()=>location.reload());
    });

    /* DELETE */
    document.querySelectorAll('.delete-image').forEach(btn=>{
        btn.onclick = ()=>{
            if(!confirm('Delete this image?')) return;

            fetch('<?= Yii::app()->createUrl("website/menu/deleteImage") ?>',{
                method:'POST',
                headers:{'Content-Type':'application/x-www-form-urlencoded'},
                body:new URLSearchParams({
                    YII_CSRF_TOKEN: CSRF_TOKEN,
                    folder: btn.dataset.folder,
                    file: btn.dataset.file
                })
            }).then(()=>location.reload());
        };
    });

    /* SET COVER */
    document.querySelectorAll('.set-cover').forEach(btn=>{
        btn.onclick = ()=>{
            if(!confirm('Set as cover image?')) return;

            fetch('<?= Yii::app()->createUrl("website/menu/setCover") ?>',{
                method:'POST',
                headers:{'Content-Type':'application/x-www-form-urlencoded'},
                body:new URLSearchParams({
                    YII_CSRF_TOKEN: CSRF_TOKEN,
                    folder: btn.dataset.folder,
                    file: btn.dataset.file
                })
            }).then(()=>location.reload());
        };
    });
</script>
