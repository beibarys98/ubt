<?php

use common\models\UserTest;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
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
        <?= Html::a('Create User Test', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

<?= GridView::widget([
    'dataProvider' => $dataProvider,
    'filterModel'  => $searchModel,
    'columns' => [
        [
            'attribute' => 'name',
            'label' => 'User',
        ],
        [
            'attribute' => 'start_time',
            'label' => 'Start Time',
        ],
        [
            'attribute' => 'end_time',
            'label' => 'End Time',
        ],
        [
            'attribute' => 'total_score',
            'label' => 'Total Score',
        ],
        [
            'label' => 'File',
            'format' => 'raw',
            'value' => function ($user) {
                return $user->resultFile && $user->resultFile->file_path
                    ? Html::a('Download', [$user->resultFile->file_path], ['target' => '_blank'])
                    : 'No File';
            }
        ],
    ],
]); ?>




</div>
