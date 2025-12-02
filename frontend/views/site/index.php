<?php

/** @var yii\web\View $this */
/** @var yii\bootstrap5\ActiveForm $form */
/** @var \common\models\User $model */

use yii\bootstrap5\Html;
use yii\bootstrap5\ActiveForm;

$this->title = 'UBT';
?>
<div class="site-login">

    <div class="card shadow p-3" style="margin: 0 auto; width: 300px;">
        <?php $form = ActiveForm::begin(['id' => 'login-form']); ?>

                <?= $form->field($model, 'name')->textInput(['placeholder' => 'Есіміңіз'])->label(false) ?>

                <?= $form->field($model, 'subjects[]')
                    ->checkboxList($subjects)
                    ->label(false) ?>

                <div class="form-group">
                    <?= Html::submitButton('Тестті бастау', ['class' => 'btn btn-primary w-100', 'name' => 'login-button']) ?>
                </div>

            <?php ActiveForm::end(); ?>
    </div>
</div>

<?php
$this->registerJs(<<<JS
const maxSubjects = 2;
const checkboxes = document.querySelectorAll('input[name="User[subjects][]"]');

function updateState() {
    let checkedCount = 0;

    checkboxes.forEach(cb => {
        if (cb.checked) checkedCount++;
    });

    checkboxes.forEach(cb => {
        if (!cb.checked) {
            cb.disabled = checkedCount >= maxSubjects;
        }
    });
}

checkboxes.forEach(cb => {
    cb.addEventListener('change', updateState);
});

updateState();
JS
);


