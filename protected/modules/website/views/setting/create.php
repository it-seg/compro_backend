<?php
$isBg1 = (!$model->isNewRecord && preg_match('/_bg_1$/', $model->key));
$pair = null;

if ($isBg1) {
    $pairKey = str_replace('_bg_1', '_bg_2', $model->key);
    $pair = Setting::model()->findByAttributes(['key'=>$pairKey]);
}
?>

<h3 class="mb-4">
    <?= $isBg1
        ? 'Edit Background – ' . strtoupper(str_replace('_bg_1','', $model->key)) . ' Page'
        : 'Edit Setting'
    ?>
</h3>

<?php if (Yii::app()->user->hasFlash('success')): ?>
    <div class="alert alert-success">
        <?= Yii::app()->user->getFlash('success'); ?>
    </div>
<?php endif; ?>

<?php $form = $this->beginWidget('CActiveForm'); ?>

<div class="card shadow-sm">
    <div class="card-body">

        <?php if ($isBg1 && $pair): ?>

            <!-- GRADIENT PREVIEW -->
            <div id="preview" style="
                    width:100%;
                    aspect-ratio: 210 / 297;
                    max-width: 340px;
                    margin: 0 auto 32px;
                    border-radius:14px;
                    background:linear-gradient(180deg, <?= $model->value ?>, <?= $pair->value ?>);
                    border:1px solid #ddd;
                    "></div>


            <!-- COLOR 1 -->
            <div class="mb-4">
                <label class="form-label fw-bold">Primary Color</label>
                <div class="d-flex gap-3 align-items-center">
                    <input type="color" id="c1" value="<?= $model->value ?>" style="width:64px;height:44px">
                    <?php echo $form->textField($model,'value',[
                        'class'=>'form-control',
                        'id'=>'v1',
                        'style'=>'max-width:160px'
                    ]); ?>
                </div>
            </div>

            <!-- COLOR 2 -->
            <div class="mb-4">
                <label class="form-label fw-bold">Secondary Color</label>
                <div class="d-flex gap-3 align-items-center">
                    <input type="color" id="c2" value="<?= $pair->value ?>" style="width:64px;height:44px">
                    <input type="text" name="Pair[value]" id="v2"
                           value="<?= $pair->value ?>"
                           class="form-control"
                           style="max-width:160px">
                </div>
            </div>

            <div class="d-flex justify-content-end gap-2 mt-4">
                <a href="<?= $this->createUrl('index') ?>"
                   class="btn btn-warning">
                    <i class="bi bi-arrow-left"></i> Back
                </a>

                <button class="btn btn-success px-4">
                    <i class="bi bi-save"></i> Save Background
                </button>
            </div>



        <?php else: ?>

            <!-- FALLBACK NORMAL SETTING -->
            <div class="mb-3">
                <?php echo $form->labelEx($model,'key'); ?>
                <?php echo $form->textField($model,'key',['class'=>'form-control']); ?>
            </div>

            <div class="mb-3">
                <?php echo $form->labelEx($model,'value'); ?>
                <?php echo $form->textField($model,'value',['class'=>'form-control']); ?>
            </div>

            <div class="text-end">
                <button class="btn btn-success px-4">
                    <i class="bi bi-save"></i> Save
                </button>
            </div>

        <?php endif; ?>

    </div>
</div>

<?php $this->endWidget(); ?>

<script>
    (function () {
        const c1 = document.getElementById('c1');
        const c2 = document.getElementById('c2');
        const v1 = document.getElementById('v1');
        const v2 = document.getElementById('v2');
        const preview = document.getElementById('preview');

        function update() {
            preview.style.background =
                `linear-gradient(180deg, ${v1.value}, ${v2.value})`;
        }

        c1.oninput = () => { v1.value = c1.value; update(); };
        c2.oninput = () => { v2.value = c2.value; update(); };
        v1.oninput = () => { c1.value = v1.value; update(); };
        v2.oninput = () => { c2.value = v2.value; update(); };
    })();
</script>
