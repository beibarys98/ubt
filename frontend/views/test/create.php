<?php

use yii\helpers\Html;
use yii\bootstrap5\ActiveForm;

/** @var yii\web\View $this */
/** @var common\models\Test $model */

$this->title = 'Create Test';
$this->params['breadcrumbs'][] = ['label' => 'Tests', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="test-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'subject_id')->dropDownList(
        \yii\helpers\ArrayHelper::map($subjects, 'id', 'title'),
        ['prompt' => 'Select Subject']
    ) ?>

    <?= $form->field($model, 'version')->input('number', ['min' => 1]) ?>

    <?= $form->field($model, 'images[]')->fileInput([
        'multiple' => true,
        'webkitdirectory' => true, // allows folder upload in Chrome/Edge
    ]) ?>

    <?= $form->field($model, 'answersText')->textarea([
        'rows' => 10
    ]) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

<?php ActiveForm::end(); ?>

</div>
