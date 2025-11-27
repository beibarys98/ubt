<?php

/** @var yii\web\View $this */
/** @var yii\bootstrap5\ActiveForm $form */
/** @var \common\models\LoginForm $model */

use yii\bootstrap5\Html;
use yii\bootstrap5\ActiveForm;

$this->title = 'UBT';
?>
<div class="site-login">

    <div class="card shadow p-3" style="margin: 0 auto; width: 300px;">
        <?php $form = ActiveForm::begin(['id' => 'login-form']); ?>

                <?= $form->field($model, 'name')->textInput(['placeholder' => 'Есіміңіз'])->label(false) ?>

                <?= $form->field($model, 'subjects')->checkboxList($subjects, ['itemOptions' => ['class' => 'subject-checkbox']])->label(false) ?>

                <div class="form-group">
                    <?= Html::submitButton('Тестті бастау', ['class' => 'btn btn-primary w-100', 'name' => 'login-button']) ?>
                </div>

            <?php ActiveForm::end(); ?>
    </div>
</div>

<?php
$this->registerJs("
    const boxes = document.querySelectorAll('#loginform-subjects input[type=\"checkbox\"]');

    boxes.forEach(box => {
        box.addEventListener('change', function () {
            const checked = document.querySelectorAll('#loginform-subjects input[type=\"checkbox\"]:checked');

            if (checked.length > 2) {
                this.checked = false;
                alert('You can only select up to 2 subjects!');
            }
        });
    });
");
?>


