<h4 class="mb-3">
    <?php echo $model->isNewRecord ? "Create Homepage Section" : "Edit Homepage Section"; ?>
</h4>

<?php $form = $this->beginWidget('CActiveForm'); ?>

<div class="card shadow-sm border-0">
    <div class="card-body">

        <!-- Section Key -->
        <div class="mb-4">
            <?php echo $form->labelEx($model, 'section_key', ['class'=>'form-label']); ?>
            <?php echo $form->textField($model, 'section_key', [
                'class' => 'form-control',
                'placeholder' => 'contoh: hero, about, gallery'
            ]); ?>
            <div class="form-text text-muted">
                Gunakan key unik untuk mapping section di homepage.
            </div>
            <?php echo $form->error($model, 'section_key'); ?>
        </div>

        <!-- Sort Order & Status -->
        <div class="row g-3 align-items-end">

            <div class="col-md-3">
                <?php echo $form->labelEx($model, 'sort_order', ['class'=>'form-label small text-muted']); ?>
                <?php echo $form->textField($model, 'sort_order', [
                    'class' => 'form-control form-control-sm',
                    'placeholder' => '0'
                ]); ?>
                <?php echo $form->error($model, 'sort_order'); ?>
            </div>

            <div class="col-md-9">
                <label class="form-label small text-muted mb-1">
                    Status Section
                </label>

                <?php
                if ($model->isNewRecord && $model->is_active === null) {
                    $model->is_active = 1;
                }
                ?>

                <div class="d-flex gap-4">
                    <?php echo $form->radioButtonList($model, 'is_active', [
                        1 => 'Aktif',
                        0 => 'Tidak Aktif',
                    ], [
                        'separator' => ' ',
                        'class' => 'form-check-input'
                    ]); ?>

                </div>

                <?php echo $form->error($model, 'is_active'); ?>
            </div>

        </div>

    </div>

    <!-- Footer -->
    <div class="card-footer bg-transparent border-0 d-flex justify-content-between">
        <a href="<?php echo $this->createUrl('index'); ?>" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left me-1"></i> Back
        </a>

        <button class="btn btn-success px-4">
            <i class="bi bi-save me-1"></i> Save
        </button>
    </div>
</div>

<?php $this->endWidget(); ?>
