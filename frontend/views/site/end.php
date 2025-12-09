<?php
/** @var $this yii\web\View */
/** @var $userTests \common\models\UserTest[] */

$this->title = "Нәтиже";
?>

<table class="table table-bordered">

    <tbody>
        <?php foreach ($userTests as $ut): ?>
            <tr>
                <td><?= $ut->test->subject->title ?></td>
                <td><?= $ut->score ?></td>
            </tr>
            
        <?php endforeach; ?>
        <tr>
                <td><strong>Барлығы</strong></td>
                <td><strong><?= $totalScore ?></strong></td>
            </tr>
    </tbody>
</table>
