<?php

/** @var yii\web\View $this */

use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = 'UBT';
?>
<div class="site-login container">
    <div class="row">
        <!-- Left Column (70%) -->
        <div class="col-md-8 col-12">
            <?php $form = ActiveForm::begin(); ?>
            <div class="p-3 card">
                <img id="question-img" src="<?= Yii::getAlias('@web/') . $question->img_path ?>" class="img-fluid" alt="Question">
            </div>
            <div class="p-3 card mt-3 mb-3">
                <?php if ($question->type === 'single'): ?>
                    <?php
                    $letters = ['A', 'B', 'C', 'D'];
                    ?>
                    <div class="row">
                        <?php for ($i = 0; $i < 4; $i++): ?>
                            <div class="col-3">
                                <div class="form-check">
                                    <input 
                                        class="form-check-input"
                                        type="radio"
                                        name="answer"
                                        id="single<?= $i ?>"
                                        value="<?= $letters[$i] ?>"
                                        <?= ($savedAnswer === $letters[$i]) ? 'checked' : '' ?>
                                    >
                                    <label class="form-check-label" for="single<?= $i ?>">
                                        <?= $letters[$i] ?>
                                    </label>
                                </div>
                            </div>
                        <?php endfor; ?>

                    </div>


                <?php elseif ($question->type === 'multiple'): ?>
                    <?php
                    $letters = ['A', 'B', 'C', 'D', 'E', 'F'];
                    ?>
                    <div class="row">
                        <?php
                        $savedAnswers = $savedAnswer ? explode(' ', $savedAnswer) : [];
                        ?>
                        <?php foreach ($letters as $i => $letter): ?>
                            <div class="col-2">
                                <div class="form-check">
                                    <input
                                        class="form-check-input"
                                        type="checkbox"
                                        name="answer[]"
                                        id="multiple<?= $i ?>"
                                        value="<?= $letter ?>"
                                        <?= in_array($letter, $savedAnswers) ? 'checked' : '' ?>
                                    >
                                    <label class="form-check-label" for="multiple<?= $i ?>">
                                        <?= $letter ?>
                                    </label>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php elseif ($question->type === 'match'): ?>
                    <?php
                        $rows = [
                            ['A-1', 'A-2', 'A-3', 'A-4'],
                            ['B-1', 'B-2', 'B-3', 'B-4']
                        ];
                        $savedAnswers = $savedAnswer ? explode(' ', $savedAnswer) : [];
                        foreach ($rows as $rowIndex => $row): ?>
                            <div class="row">
                                <?php foreach ($row as $i => $item): ?>
                                    <div class="col-3">
                                        <div class="form-check">
                                            <input
                                                class="form-check-input"
                                                type="checkbox"
                                                name="answer[]"
                                                id="match<?= $rowIndex ?><?= $i ?>"
                                                value="<?= $item ?>"
                                                <?= in_array($item, $savedAnswers) ? 'checked' : '' ?>
                                            >
                                            <label class="form-check-label" for="match<?= $rowIndex ?><?= $i ?>">
                                                <?= $item ?>
                                            </label>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        <?php endforeach; ?>
                <?php endif; ?>
            </div>
            <div class="mb-3">
                <?= Html::submitButton('Сақтау', ['class' => 'btn btn-primary w-100']) ?>
            </div>
            <?php ActiveForm::end(); ?>
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
                            <?php
                            $isAnswered = in_array($q->id, $answeredIds ?? []);
                            ?>
                            <?= Html::a(
                                $index + 1,
                                ['test', 'id' => $q->id],
                                [
                                    'class' => 'btn mb-1 ' . (
                                        $q->id === $question->id
                                            ? 'btn-primary'
                                            : ($isAnswered ? 'btn-success' : 'btn-outline-dark')
                                    )
                                ]
                            ) ?>
                        <?php endforeach; ?>
                    </div>
                <?php endforeach; ?>

                <div>
                    <?= Html::a('Тестті аяқтау', ['site/end-test'], ['class' => 'btn btn-danger w-100', 'data' => ['confirm' => 'Сенімдісіз бе?']]) ?>
                </div>
            </div>
        </div>
    </div>
</div>


