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

    <!-- Color Picker -->
    <input
            type="color"
            id="colorPicker"
            class="form-control form-control-color mb-2"
            style="width:80px;display:none"
            value="<?= CHtml::encode($model->value ?: '#000000') ?>"
    >

    <!-- Text input (fallback / manual) -->
    <?php echo $form->textField($model,'value',[
        'class'=>'form-control',
        'id'=>'valueInput'
    ]); ?>

    <?php echo $form->error($model,'value'); ?>

    <!-- Gradient preview -->
    <div id="gradientPreview" style="
        display:none;
        height:120px;
        margin-top:12px;
        border-radius:8px;
        border:1px solid #ccc;
    "></div>
</div>


<button class="btn btn-success">
    <i class="bi bi-save"></i> Save
</button>

<?php $this->endWidget(); ?>

<script>
    (function () {
        const keyInput   = document.getElementById('settingKey');
        const valueInput = document.getElementById('valueInput');
        const picker     = document.getElementById('colorPicker');
        const preview    = document.getElementById('gradientPreview');

        function isBgKey() {
            return keyInput.value.includes('_bg_');
        }

        function syncPicker() {
            if (valueInput.value.startsWith('#')) {
                picker.value = valueInput.value;
            }
        }

        function updatePreview() {
            if (!keyInput.value.endsWith('_bg_1')) return;

            const key2 = keyInput.value.replace('_bg_1', '_bg_2');

            fetch('<?= $this->createUrl("getBgPair") ?>?key=' + key2)
                .then(res => res.json())
                .then(data => {
                    if (!data.value) return;

                    preview.style.display = 'block';
                    preview.style.background =
                        `linear-gradient(180deg, ${valueInput.value}, ${data.value})`;
                });
        }

        // Init
        if (isBgKey()) {
            picker.style.display = 'block';
            syncPicker();
            updatePreview();
        }

        picker.addEventListener('input', () => {
            valueInput.value = picker.value;
            updatePreview();
        });

        valueInput.addEventListener('input', () => {
            syncPicker();
            updatePreview();
        });
    })();
</script>

