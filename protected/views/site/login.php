<div class="row justify-content-center">
  <div class="col-md-5">
    <div class="card shadow-sm">
      <div class="card-body">
        <h3 class="card-title mb-3">Login</h3>

          <?php if (Yii::app()->user->hasFlash('expired')): ?>
              <div class="alert alert-warning">
                  <?php echo Yii::app()->user->getFlash('expired'); ?>
              </div>
          <?php endif; ?>

        <?php $form=$this->beginWidget('CActiveForm', array(
            'id'=>'login-form',
            'enableClientValidation'=>true,
            'clientOptions'=>array('validateOnSubmit'=>true),
        )); ?>

        <div class="mb-3">
          <?php echo $form->labelEx($model,'username'); ?>
          <?php echo $form->textField($model,'username', array('class'=>'form-control')); ?>
          <?php echo $form->error($model,'username', array('class'=>'text-danger')); ?>
        </div>

        <div class="mb-3">
          <?php echo $form->labelEx($model,'password'); ?>
          <?php echo $form->passwordField($model,'password', array('class'=>'form-control')); ?>
          <?php echo $form->error($model,'password', array('class'=>'text-danger')); ?>
        </div>

        <div class="d-grid">
          <button type="submit" class="btn btn-primary">Login</button>
        </div>

        <?php $this->endWidget(); ?>

      </div>
    </div>
  </div>
</div>
