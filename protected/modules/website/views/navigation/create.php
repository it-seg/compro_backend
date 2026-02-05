<h3><?php echo $model->isNewRecord ? "Create Navigation":"Edit Navigation"; ?></h3>
<hr>
<?php $form = $this->beginWidget('CActiveForm'); ?>

<div class="card p-3">
    <div class="mb-3">
        <?php echo $form->labelEx($model,'label'); ?>
        <?php echo $form->textField($model,'label',['class'=>'form-control']); ?>
        <?php echo $form->error($model,'label'); ?>
    </div>

    <div class="mb-3">
        <?php echo $form->labelEx($model,'label_ind'); ?>
        <?php echo $form->textField($model,'label_ind',['class'=>'form-control']); ?>
        <?php echo $form->error($model,'label_ind'); ?>
    </div>

    <div class="mb-3">
        <?php echo $form->labelEx($model,'sort_order'); ?>
        <?php echo $form->textField($model,'sort_order',['class'=>'form-control']); ?>
        <?php echo $form->error($model,'sort_order'); ?>
    </div>

    <button class="btn btn-success"><i class="bi bi-save"></i> Save</button>
</div>

<?php $this->endWidget(); ?>
