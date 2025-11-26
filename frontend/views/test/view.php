<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var common\models\Test $model */

$this->title = $model->subject->title . ' - Нұсқа ' . $model->version;
$this->params['breadcrumbs'][] = ['label' => 'Tests', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="test-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php foreach ($model->questions as $question): ?>
        <div class="question-item">
            <?= Html::img(Url::to('@web/' . $question->img_path)) ?>
        </div>
    <?php endforeach; ?>

</div>
