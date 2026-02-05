<?php
// Before rendering the form
$model->password = '';
$showPassword = true;

if(isset($_GET['action']) && $_GET['action'] == 'change-password')
    $changePassword = true;
else {
    $changePassword = false;
}
?>

<h3><?php
    if ($model->isNewRecord){
        echo 'Create User';
    }
    else {
        if (isset($_GET['action']) && $_GET['action'] == 'change-password')
            echo 'Change Password';
        else {
            $showPassword = false;
            echo 'Edit User';
        }
    }
    ?></h3>
<hr>

<div class="card p-3">
    <?php $form = $this->beginWidget('CActiveForm'); ?>

    <div class="mb-3">
        <?php echo $form->labelEx($model, 'fullname'); ?>
        <?php echo $form->textField($model, 'fullname', [
            'class' => 'form-control',
            'readonly' => $changePassword,
            'disabled' => $changePassword,
        ]); ?>
        <?php echo $form->error($model, 'fullname'); ?>
    </div>

    <div class="mb-3">
        <?php echo $form->labelEx($model, 'username'); ?>
        <?php echo $form->textField($model, 'username', [
            'class' => 'form-control',
            'readonly' => $changePassword,
            'disabled' => $changePassword,
        ]); ?>
        <?php echo $form->error($model, 'username'); ?>
    </div>

    <div class="mb-3">
        <?php echo $form->labelEx($model, 'role'); ?>
        <?php echo $form->dropDownList($model,'role_id', $roles, ['class'=>'form-control']); ?>
        <?php echo $form->error($model, 'role'); ?>
    </div>

    <?php if ($changePassword || $showPassword): ?>
        <div class="mb-3">
            <?php echo $form->labelEx($model, 'password'); ?>
            <?php echo $form->passwordField($model, 'password', [
//            'placeholder' => 'Enter new password',
                'class' => 'form-control',
            ]); ?>
            <?php echo $form->error($model, 'password'); ?>
        </div>

        <div class="mb-3">
            <?php echo $form->labelEx($model, 'retype password'); ?>
            <?php echo $form->passwordField($model, 'retypepassword', [
                'class' => 'form-control',
            ]); ?>
            <?php echo $form->error($model, 'retypepassword'); ?>
        </div>
    <?php endif; ?>

    <button type="submit" class="btn btn-success">
        <i class="bi bi-save"></i> Save
    </button>

    <?php $this->endWidget(); ?>
</div>
