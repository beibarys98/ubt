<?php

use yii\helpers\Html;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var common\models\search\UserTestSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'User Tests';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-test-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Download Results', ['results'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

<?= GridView::widget([
    'dataProvider' => $dataProvider,
    'filterModel'  => $searchModel,
    'columns' => [
        [
            'attribute' => 'id',
            'label' => 'ID',
            'contentOptions' => ['style' => 'width:5%; white-space:nowrap;'],
            'headerOptions'  => ['style' => 'width:5%;'],
        ],

        [
            'attribute' => 'name',
            'label' => 'User',
        ],
        [
            'attribute' => 'start_time',
            'label' => 'Start Time',
            'format' => 'raw',
            'value' => function ($model) {

                // Format values (handle null/empty)
                $start = $model->start_time ? date('H:i:s', strtotime($model->start_time)) : '---';
                $end   = $model->end_time   ? date('H:i:s', strtotime($model->end_time))   : '---';

                if ($start === '---' && $end === '---') {
                    return null;
                }

                return $start . '<br>' . $end;
            },
        ],

        [
            'attribute' => 'total_score',
            'label' => 'Total Score',
            'contentOptions' => ['style' => 'width:5%; white-space:nowrap;'],
            'headerOptions'  => ['style' => 'width:5%;'],
        ],
        [
            'label' => 'File',
            'format' => 'raw',
            'value' => function ($user) {
                return $user->resultFile && $user->resultFile->file_path
                    ? Html::a('Report', [$user->resultFile->file_path], ['target' => '_blank'])
                    : 'No File';
            }
        ],
    ],
]); ?>




</div>
