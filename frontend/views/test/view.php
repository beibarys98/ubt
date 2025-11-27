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

    <div class="my-5">
        <?php
        $statuses = ['new', 'ready', 'public', 'finished'];

        foreach ($statuses as $status) {
            echo Html::a(
                ucfirst($status), // Button label
                ['status', 'id' => $model->id, 'status' => $status],
                ['class' => 'btn ' . ($model->status === $status ? 'btn-success' : 'btn-outline-success')]
            ) . ' ';
        }
        ?>

    </div>

    <?php foreach ($model->questions as $question): ?>
        <div class="question-item mb-5">
            <?= Html::img(Url::to('@web/' . $question->img_path), ['style' => 'max-width: 80vw; max-height: 80vh; border: 1px solid black; border-radius: 19px;']) ?>
            <div style="font-size: 1.5rem;">
                <?= Html::a('Өзгерту', ['question/update', 'id' => $question->id], ['class' => 'btn btn-outline-dark me-5']); ?>
                <strong>Жауабы: <?= Html::encode($question->correct) ?></strong>
                
            </div>
        </div>
    <?php endforeach; ?>

</div>
