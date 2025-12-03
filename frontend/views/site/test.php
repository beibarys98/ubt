<?php

/** @var yii\web\View $this */

use yii\helpers\Html;

$this->title = 'UBT';
?>
<div class="site-login container">
    <div class="row">
        <!-- Left Column (70%) -->
        <div class="col-md-8 col-12">
            <div class="p-3 card">
                <img id="question-img" src="<?= Yii::getAlias('@web/') . $question->img_path ?>" class="img-fluid" alt="Question">
            </div>
        </div>

        <!-- Right Column (30%) -->
        <div class="col-md-4 col-12"> 
            <div class="p-3 card">
                <?php foreach ($userTests as $userTest):
                    $test = $userTest->test;
                    if (!$test) continue;
                    $subjectTitle = $test->subject->title;
                    $questions = $test->questions;
                ?>
                    <!-- Subject title -->
                    <h5 class="mt-2 text-center"><?= Html::encode($subjectTitle) ?></h5>
                    <!-- Question links centered -->
                    <div class="d-flex flex-wrap justify-content-center gap-2 mb-3">
                        <?php foreach ($questions as $index => $q): ?>
                            <?= Html::a(
                                $index + 1, // Numbering starts at 1
                                ['test', 'id' => $q->id],
                                [
                                    'class' => 'btn mb-1 ' . ($q->id === $question->id ? 'btn-dark' : 'btn-outline-dark')
                                ]
                            ) ?>
                        <?php endforeach; ?>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</div>
