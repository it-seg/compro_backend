<h3><?php echo $model->isNewRecord ? "Create Sub Navigation":"Edit Sub Navigation"; ?></h3>
<hr>
<?php $form = $this->beginWidget('CActiveForm'); ?>

<div class="card p-3">
    <div class="mb-3">
        <?php echo $form->labelEx($model,'navigation_id'); ?>
        <?php echo $form->dropDownList($model,'navigation_id', $navs, ['class'=>'form-control']); ?>
        <?php echo $form->error($model,'navigation_id'); ?>
    </div>

    <div class="mb-3">
        <?php echo $form->labelEx($model,'label'); ?>
        <?php echo $form->textField($model,'label',['class'=>'form-control']); ?>
        <?php echo $form->error($model,'label'); ?>
    </div>

    <div class="mb-3">
        <?php echo $form->labelEx($model,'url'); ?>
        <?php echo $form->textField($model,'url',['class'=>'form-control']); ?>
        <?php echo $form->error($model,'url'); ?>
    </div>

    <div class="mb-3">
        <?php echo $form->labelEx($model,'sort_order'); ?>
        <?php echo $form->textField($model,'sort_order',['class'=>'form-control']); ?>
        <?php echo $form->error($model,'sort_order'); ?>
    </div>

    <button class="btn btn-success"><i class="bi bi-save"></i> Save</button>
</div>

<?php $this->endWidget(); ?>
