<?php

/** @var yii\web\View $this */
/** @var yii\bootstrap5\ActiveForm $form */
/** @var \common\models\User $model */

use yii\bootstrap5\Html;
use yii\bootstrap5\ActiveForm;
use kartik\select2\Select2;

$this->title = 'UBT';
?>
<div class="site-login">

    <div class="card shadow p-3" style="margin: 0 auto; width: 500px;">
        <?php $form = ActiveForm::begin(['id' => 'login-form']); ?>

                <?= $form->field($model, 'name')->textInput(['placeholder' => 'Есіміңіз'])->label(false) ?>

                <?= $form->field($model, 'subject_1')->dropDownList(
                    $subjects,
                    [
                        'prompt' => 'Бірінші пәнді таңдаңыз!',
                    ]
                )->label(false) ?>

                <?= $form->field($model, 'subject_2')->dropDownList(
                    $subjects,
                    [
                        'prompt' => 'Екінші пәнді таңдаңыз!',
                    ]
                )->label(false) ?>

                <div class="form-group">
                    <?= Html::submitButton('Тестті бастау', [
                        'class' => 'btn btn-primary w-100',
                        'name' => 'login-button',
                        'data' => [
                            'confirm' => 'Сенімдісіз бе?'
                        ]
                    ]) ?>
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


