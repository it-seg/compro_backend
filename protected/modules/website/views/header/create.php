<h3><?php echo $model->isNewRecord ? 'Create Header' : 'Edit Header'; ?></h3>

<hr>
<?php $form = $this->beginWidget('CActiveForm'); ?>

<div class="card p-3">

    <div class="mb-3">
        <?php echo $form->labelEx($model,'content_english'); ?>
        <?php echo $form->textArea($model,'content_english',['class'=>'form-control','rows'=>6]); ?>
        <?php echo $form->error($model,'content_english'); ?>
    </div>
    <div class="mb-3">
        <?php echo $form->labelEx($model,'content'); ?>
        <?php echo $form->textArea($model,'content',['class'=>'form-control','rows'=>6]); ?>
        <?php echo $form->error($model,'content'); ?>
    </div>

    <button class="btn btn-success"><i class="bi bi-save"></i> Save</button>
</div>

<?php $this->endWidget(); ?>
