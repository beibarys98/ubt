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

                <?= $form->field($model, 'subjects')
                    ->checkboxList($subjects)
                    ->label(false)
                    ->error() ?>

                <div id="subjects-counter" style="margin-bottom:10px; font-weight:bold;">
                    0 / 2 таңдалды
                </div>

                <div class="form-group">
                    <?= Html::submitButton('Тестті бастау', ['class' => 'btn btn-primary w-100', 'name' => 'login-button']) ?>
                </div>

            <?php ActiveForm::end(); ?>
    </div>
</div>

<?php
$this->registerJs(<<<JS
const maxSubjects = 2;
const counter = document.getElementById('subjects-counter');
const checkboxes = document.querySelectorAll('input[name="User[subjects][]"]');

function updateCounter() {
    let checkedCount = 0;
    checkboxes.forEach(cb => { if(cb.checked) checkedCount++; });
    counter.textContent = checkedCount + ' / ' + maxSubjects + ' таңдалды';
}

// initial count
updateCounter();

checkboxes.forEach(cb => {
    cb.addEventListener('change', function(e) {
        let checkedCount = 0;
        checkboxes.forEach(cb => { if(cb.checked) checkedCount++; });

        if (checkedCount > maxSubjects) {
            e.target.checked = false;
            alert('Тек 2 пән ғана таңдауға болады!');
        }

        updateCounter();
    });
});
JS
);
?>
