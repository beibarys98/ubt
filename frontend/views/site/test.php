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
            <div class="p-3 card mt-3 mb-3">
                <?php if ($question->type === 'single'): ?>
                    <?php for ($i = 0; $i < 4; $i++): ?>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="answer" id="single<?= $i ?>" value="<?= $i ?>">
                            <label class="form-check-label" for="single<?= $i ?>">
                                Option <?= $i + 1 ?>
                            </label>
                        </div>
                    <?php endfor; ?>

                <?php elseif ($question->type === 'multiple'): ?>
                    <?php for ($i = 0; $i < 6; $i++): ?>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="answer[]" id="multiple<?= $i ?>" value="<?= $i ?>">
                            <label class="form-check-label" for="multiple<?= $i ?>">
                                Option <?= $i + 1 ?>
                            </label>
                        </div>
                    <?php endfor; ?>

                <?php elseif ($question->type === 'match'): ?>
                    <div class="row">
                        <?php for ($i = 0; $i < 8; $i++): ?>
                            <div class="col-6">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="answer[]" id="match<?= $i ?>" value="<?= $i ?>">
                                    <label class="form-check-label" for="match<?= $i ?>">
                                        Option <?= $i + 1 ?>
                                    </label>
                                </div>
                            </div>
                        <?php endfor; ?>
                    </div>
                <?php endif; ?>
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
