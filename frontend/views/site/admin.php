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
        <?php $form = ActiveForm::begin(); ?>
            <?= $form->field($model, 'password')->passwordInput(['autofocus' => 'true', 'placeholder' => 'Құпия сөз'])->label(false) ?>
            <?= Html::submitButton('Кіру', ['class' => 'btn btn-primary w-100']) ?>
        <?php ActiveForm::end(); ?>
    </div>
</div>
