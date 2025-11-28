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

                <?= $form->field($model, 'username')->textInput(['autofocus' => true, 'placeholder' => 'ЖСН'])->label(false) ?>
                <?= $form->field($model, 'check')->textInput(['placeholder' => 'ЖСН қайтадан'])->label(false) ?>

                <div class="form-group">
                    <?= Html::submitButton('Кіру', ['class' => 'btn btn-primary w-100', 'name' => 'login-button']) ?>
                </div>

            <?php ActiveForm::end(); ?>
    </div>
</div>
