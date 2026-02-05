<h3><?php echo $model->isNewRecord ? 'Create Setting' : 'Edit Setting'; ?></h3>

<hr>
<?php $form = $this->beginWidget('CActiveForm'); ?>

<div class="mb-3">
    <?php echo $form->labelEx($model,'key'); ?>
    <?php echo $form->textField($model,'key',[
        'class'=>'form-control',
        'id'=>'settingKey'
    ]); ?>
    <?php echo $form->error($model,'key'); ?>
</div>

<div class="mb-3">
    <?php echo $form->labelEx($model,'value'); ?>
    <?php echo $form->textField($model,'value',['class'=>'form-control']); ?>
    <?php echo $form->error($model,'value'); ?>

    <small id="logoHint" class="text-muted" style="display:none">
        Get path from Website Image. Example: images/logo.jpg
    </small>
</div>

<button class="btn btn-success">
    <i class="bi bi-save"></i> Save
</button>

<?php $this->endWidget(); ?>
