<h4 class="mb-3">
    <?php echo $model->isNewRecord ? "Create Navigation" : "Edit Navigation"; ?>
</h4>

<?php $form = $this->beginWidget('CActiveForm'); ?>

<div class="card shadow-sm border-0">
    <div class="card-body">

        <!-- Sort Order & Status -->
        <div class="row g-3 align-items-end mb-2">

            <div class="col-md-3">
                <?php echo $form->labelEx($model, 'sort_order', ['class'=>'form-label small text-muted']); ?>
                <?php echo $form->textField($model, 'sort_order', [
                    'class' => 'form-control form-control-sm',
                    'placeholder' => 'Urutan'
                ]); ?>
                <?php echo $form->error($model, 'sort_order'); ?>
            </div>

            <div class="col-md-9">
                <label class="form-label small text-muted mb-1">
                    Status Navigasi
                </label>

                <?php
                if ($model->isNewRecord && $model->is_active === null) {
                    $model->is_active = 1;
                }
                ?>

                <div class="d-flex gap-4">
                    <div class="form-check">
                        <?php echo $form->radioButton($model, 'is_active', [
                            'value' => 1,
                            'class' => 'form-check-input',
                            'id' => 'is_active_1'
                        ]); ?>
                        <label class="form-check-label fw-medium" for="is_active_1">
                            Aktif
                        </label>
                    </div>

                    <div class="form-check">
                        <?php echo $form->radioButton($model, 'is_active', [
                            'value' => 0,
                            'class' => 'form-check-input',
                            'id' => 'is_active_0'
                        ]); ?>
                        <label class="form-check-label fw-medium text-muted" for="is_active_0">
                            Tidak Aktif
                        </label>
                    </div>
                </div>

                <?php echo $form->error($model, 'is_active'); ?>
            </div>

        </div>

        <hr class="my-4">

        <!-- Labels -->
        <div class="row g-3">
            <div class="col-md-6">
                <?php echo $form->labelEx($model, 'label', ['class'=>'form-label']); ?>
                <?php echo $form->textField($model, 'label', [
                    'class' => 'form-control',
                    'placeholder' => 'Label (EN)'
                ]); ?>
                <?php echo $form->error($model, 'label'); ?>
            </div>

            <div class="col-md-6">
                <?php echo $form->labelEx($model, 'label_ind', ['class'=>'form-label']); ?>
                <?php echo $form->textField($model, 'label_ind', [
                    'class' => 'form-control',
                    'placeholder' => 'Label (ID)'
                ]); ?>
                <?php echo $form->error($model, 'label_ind'); ?>
            </div>
        </div>

    </div>

    <!-- Footer -->
    <div class="card-footer bg-transparent border-0 d-flex justify-content-between">
        <a href="<?php echo $this->createUrl('index'); ?>" class="btn btn-primary">
            <i class="bi bi-arrow-left me-1"></i> Back
        </a>

        <button class="btn btn-success px-4">
            <i class="bi bi-save me-1"></i> Save
        </button>
    </div>

</div>

<?php $this->endWidget(); ?>
