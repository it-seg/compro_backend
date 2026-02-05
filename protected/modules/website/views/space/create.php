<!-- QUILL -->
<link href="<?= Yii::app()->baseUrl; ?>/css/quill/quill.snow.css" rel="stylesheet">
<script src="<?= Yii::app()->baseUrl; ?>/js/quill/quill.js"></script>
<link rel="stylesheet" href="<?= Yii::app()->baseUrl ?>/css/quill/custom.css">

<h3><?= $model->isNewRecord ? 'Create Space' : 'Edit Space'; ?></h3>
<hr>

<?php $form = $this->beginWidget('CActiveForm', [
    'id' => 'spaceForm',
]); ?>

<div class="card p-3">

    <!-- TOP -->
    <div class="row mb-3">
        <div class="col-md-6">
            <?= $form->labelEx($model,'slug'); ?>
            <?= $form->textField($model,'slug',[
                'class'=>'form-control',
                'id'=>'slug-input',
                'readonly'=>true
            ]); ?>
            <?= $form->hiddenField($model,'slug'); ?>
            <?= $form->error($model,'slug'); ?>
        </div>

        <div class="col-md-3">
            <?= $form->labelEx($model,'is_active'); ?>
            <div class="pt-2">
                <?= $form->radioButtonList(
                    $model,'is_active',
                    [1=>'ACTIVE',0=>'INACTIVE'],
                    ['template'=>'<label class="me-3">{input} {label}</label>','separator'=>'']
                ); ?>
            </div>
        </div>

        <div class="col-md-3">
            <?= $form->labelEx($model,'sort_order'); ?>
            <?= $form->numberField($model,'sort_order',['class'=>'form-control']); ?>
        </div>
    </div>

    <!-- FOLDER -->
    <div class="row mt-3">
        <div class="col-md-6">
            <label>Folder Images</label>
            <input type="text"
                   name="folder_name"
                   class="form-control"
                   placeholder="contoh: resto"
                   value="<?= $model->isNewRecord ? '' : basename($model->images_folder_url) ?>"
                <?= !$model->isNewRecord ? 'readonly' : '' ?>
                   pattern="[A-Za-z]+"
                   title="Hanya boleh 1 kata dan alfabet (a-z)"
                   oninput="this.value = this.value.replace(/[^a-zA-Z]/g, '')">

            <small class="text-muted">
                *nama folder, 1 kata
            </small>
        </div>
    </div>

    <hr>

    <!-- CONTENT -->
    <div class="row">
        <div class="col-md-6">
            <h5>English Content</h5>
            <?= $form->labelEx($model,'title'); ?>
            <?= $form->textField($model,'title',['class'=>'form-control','id'=>'title-input']); ?>

            <?= $form->labelEx($model,'desc'); ?>
            <div id="editor-desc" style="height:250px;"></div>
            <?= CHtml::hiddenField('Space[desc]', $model->desc, ['id'=>'desc-input']); ?>
        </div>

        <div class="col-md-6">
            <h5>Indonesian Content</h5>
            <?= $form->labelEx($model,'title_ind'); ?>
            <?= $form->textField($model,'title_ind',['class'=>'form-control']); ?>

            <?= $form->labelEx($model,'desc_ind'); ?>
            <div id="editor-desc-ind" style="height:250px;"></div>
            <?= CHtml::hiddenField('Space[desc_ind]', $model->desc_ind, ['id'=>'desc-ind-input']); ?>
        </div>
    </div>

    <!-- INFO CREATE -->
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

                            <?php if (preg_match('/^cover\./i', $img['name'])): ?>
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
                                    data-folder="<?= CHtml::encode($model->images_folder_url) ?>"
                                    style="padding:2px 6px;">
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

    <?= $form->errorSummary($model); ?>

    <!-- SAVE -->
    <div class="mt-4">
        <button class="btn btn-success">
            <i class="bi bi-save"></i> Save
        </button>
    </div>

</div>

<!-- CONFIRM SET COVER MODAL -->
<div class="modal fade" id="confirmCoverModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Set Cover Image</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                Jadikan gambar ini sebagai <b>cover</b>?<br>
                <small class="text-muted">Cover lama tidak akan dihapus.</small>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-warning" id="confirmSetCoverBtn">
                    Ya, Set Cover
                </button>
            </div>
        </div>
    </div>
</div>

<?php $this->endWidget(); ?>

<script>
    const CSRF_TOKEN = '<?= Yii::app()->request->csrfToken ?>';

    /* SLUG AUTO */
    document.getElementById('title-input')?.addEventListener('input', e => {
        const slug = e.target.value
            .toLowerCase()
            .replace(/[^a-z0-9]+/g,'-')
            .replace(/^-|-$/g,'');

        document.getElementById('slug-input').value = slug;
        document.querySelector('input[type="hidden"][name="Space[slug]"]').value = slug;
    });

    /* QUILL */
    const toolbar = [
        [{ font: [] }],[{ size: [] }],
        ['bold','italic','underline'],
        [{ list:'ordered' },{ list:'bullet' }],
        [{ align: [] }],
        ['link','clean']
    ];

    const quillEn = new Quill('#editor-desc',{theme:'snow',modules:{toolbar}});
    const quillId = new Quill('#editor-desc-ind',{theme:'snow',modules:{toolbar}});

    quillEn.clipboard.dangerouslyPasteHTML(<?= json_encode($model->desc ?: '') ?>);
    quillId.clipboard.dangerouslyPasteHTML(<?= json_encode($model->desc_ind ?: '') ?>);

    document.getElementById('spaceForm').addEventListener('submit',()=>{
        document.getElementById('desc-input').value = quillEn.root.innerHTML;
        document.getElementById('desc-ind-input').value = quillId.root.innerHTML;
    });

    /* UPLOAD */
    document.getElementById('uploadBtn')?.addEventListener('click',()=>{
        document.getElementById('imageInput').click();
    });

    document.getElementById('imageInput')?.addEventListener('change',function(){
        if(!this.files.length) return;
        const fd = new FormData();
        fd.append('YII_CSRF_TOKEN',CSRF_TOKEN);
        fd.append('folder','<?= CHtml::encode($model->images_folder_url) ?>');
        fd.append('image',this.files[0]);

        fetch('<?= Yii::app()->createUrl("website/space/uploadImage") ?>',{
            method:'POST', body:fd
        }).then(()=>location.reload());
    });

    /* DELETE IMAGE */
    document.querySelectorAll('.delete-image').forEach(btn=>{
        btn.onclick=()=>{
            if(!confirm('Delete this image?')) return;
            fetch('<?= Yii::app()->createUrl("website/space/deleteImage") ?>',{
                method:'POST',
                headers:{'Content-Type':'application/x-www-form-urlencoded'},
                body:new URLSearchParams({
                    YII_CSRF_TOKEN:CSRF_TOKEN,
                    folder:btn.dataset.folder,
                    file:btn.dataset.file
                })
            }).then(()=>location.reload());
        };
    });

    /* SET COVER MODAL */
    let coverTarget = { file:null, folder:null };

    document.querySelectorAll('.set-cover').forEach(btn=>{
        btn.onclick = ()=>{
            coverTarget.file   = btn.dataset.file;
            coverTarget.folder = btn.dataset.folder;
            new bootstrap.Modal(
                document.getElementById('confirmCoverModal')
            ).show();
        };
    });

    document.getElementById('confirmSetCoverBtn')?.addEventListener('click', ()=>{
        fetch('<?= Yii::app()->createUrl("website/space/setCover") ?>',{
            method:'POST',
            headers:{'Content-Type':'application/x-www-form-urlencoded'},
            body:new URLSearchParams({
                YII_CSRF_TOKEN: CSRF_TOKEN,
                folder: coverTarget.folder,
                file: coverTarget.file
            })
        }).then(()=>location.reload());
    });
</script>
