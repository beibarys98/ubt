<?php

namespace frontend\controllers;

use common\models\Admin;
use frontend\models\ResendVerificationEmailForm;
use frontend\models\VerifyEmailForm;
use Yii;
use yii\base\InvalidArgumentException;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\LoginForm;
use common\models\User;
use frontend\models\PasswordResetRequestForm;
use frontend\models\ResetPasswordForm;
use frontend\models\SignupForm;
use frontend\models\ContactForm;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

/**
 * Site controller
 */
class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'only' => ['logout', 'signup'],
                'rules' => [
                    [
                        'actions' => ['signup'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => \yii\web\ErrorAction::class,
            ],
            'captcha' => [
                'class' => \yii\captcha\CaptchaAction::class,
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    private function redirectGuest()
    {
        if (Yii::$app->user->isGuest) {
            Yii::$app->response->redirect(['site/login'])->send();
            Yii::$app->end();
        }
    }

    private function redirectAdmin()
    {
        if (Yii::$app->user->identity->username === 'admin') {
            Yii::$app->response->redirect(['user/index'])->send();
            Yii::$app->end();
        }
    }

    private function getCurrentUser()
    {
        return User::findOne(Yii::$app->user->id);
    }

    private function redirectByTestStatus($userId)
    {
        // Get latest test attempt
        $userTest = \common\models\UserTest::find()
            ->andWhere(['user_id' => $userId])
            ->orderBy(['id' => SORT_DESC])
            ->with('test.questions')
            ->one();

        // If user has no tests at all → send to first test
        if (!$userTest) {
            return true;
        }

        // If test is NOT completed (no end_time)
        if ($userTest->end_time === null) {

            // Get the first question ID
            $firstQuestionId = $userTest->test->questions[0]->id ?? null;

            return Yii::$app->response->redirect([
                'site/test',
                'id' => $firstQuestionId
            ])->send();
        }

        // Test IS completed → redirect to end page
        return Yii::$app->response->redirect(['site/end'])->send();
    }


    private function getSelectableSubjects()
    {
        return \common\models\Subject::find()
            ->select(['title', 'id'])
            ->andWhere(['not in', 'id', [4, 5, 6]])
            ->indexBy('id')
            ->column();
    }

    private function saveUserAndAssignTests($model)
    {
        $model->save(false);

        $defaultSubjectIds = [4, 5, 6];

        $selectedSubjectIds = array_filter([$model->subject_1, $model->subject_2]);
        $allSubjectIds = array_map('intval', array_merge($defaultSubjectIds, $selectedSubjectIds));
        \common\models\UserTest::deleteAll(['user_id' => $model->id]);

        foreach ($allSubjectIds as $subjectId) {

            $test = \common\models\Test::find()
                ->andWhere(['subject_id' => $subjectId, 'status' => 'public'])
                ->orderBy(new \yii\db\Expression('RAND()'))
                ->one();

            if (!$test) continue;

            $userTest = new \common\models\UserTest();
            $userTest->user_id = $model->id;
            $userTest->test_id = $test->id;
            $userTest->start_time = date('Y-m-d H:i:s');
            $userTest->save(false);
        }
    }

    private function redirectToFirstQuestion($userId)
    {
        $firstUserTest = \common\models\UserTest::find()
            ->andWhere(['user_id' => $userId])
            ->with('test.questions')
            ->orderBy('id ASC')
            ->one();

        $firstQuestionId = $firstUserTest->test->questions[0]->id ?? null;

        return $this->redirect(['test', 'id' => $firstQuestionId]);
    }

    /**
     * Displays homepage.
     *
     * @return mixed
     */
    public function actionIndex()
    {
        $this->redirectGuest();
        $this->redirectAdmin();

        $model = $this->getCurrentUser();
        $this->redirectByTestStatus($model->id);

        $subjects = $this->getSelectableSubjects();

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $this->saveUserAndAssignTests($model);
            return $this->redirectToFirstQuestion($model->id);
        }

        return $this->render('index', [
            'model' => $model,
            'subjects' => $subjects,
        ]);
    }

    private function getNextQuestionId($currentQuestionId, $userId)
    {
        $questionIds = \common\models\UserTest::find()
            ->andWhere(['user_id' => $userId])
            ->with('test.questions')
            ->all();

        $allQuestionIds = [];
        foreach ($questionIds as $ut) {
            foreach ($ut->test->questions as $q) {
                $allQuestionIds[] = $q->id;
            }
        }

        $currentIndex = array_search($currentQuestionId, $allQuestionIds);

        return $allQuestionIds[$currentIndex + 1] ?? $currentQuestionId;
    }

    private function getSavedAnswer($questionId)
    {
        return \common\models\UserQuestion::find()
            ->select('answer')
            ->andWhere([
                'user_id' => Yii::$app->user->id,
                'question_id' => $questionId
            ])
            ->scalar(); // returns string like "B" or "A-1 B-2"
    }

    private function getAnsweredIds($userId = null)
    {
        $userId = $userId ?? Yii::$app->user->id;

        return \common\models\UserQuestion::find()
            ->select('question_id')
            ->andWhere(['user_id' => $userId])
            ->column(); // returns array of question IDs
    }

    public function actionTest($id = null)
    {
        $this->redirectGuest();

        $request = Yii::$app->request;
        $userId  = Yii::$app->user->id;

        $question = \common\models\Question::findOne($id);
        if (!$question) {
            throw new \yii\web\NotFoundHttpException('Question not found.');
        }

        // ✅ HANDLE FORM SUBMISSION
        if ($request->isPost) {

            $postAnswer = Yii::$app->request->post('answer');

            // Check if user selected an answer
            if (!$postAnswer || (is_array($postAnswer) && empty($postAnswer))) {
                Yii::$app->session->setFlash('error', 'Жауап таңдаңыз!');
                return $this->refresh();
            }

            // Normalize answers
            if ($question->type === 'single') {
                $finalAnswer = $postAnswer; // string
            } else {
                // multiple & match → array → space-separated string
                $finalAnswer = implode(' ', $postAnswer);
            }

            // ✅ Remove old answers for this question (prevent duplicates)
            \common\models\UserQuestion::deleteAll([
                'user_id'     => $userId,
                'question_id'=> $question->id,
            ]);

            // ✅ Save ONE ROW ONLY
            $model = new \common\models\UserQuestion();
            $model->user_id = $userId;
            $model->question_id = $question->id;
            $model->answer = $finalAnswer;
            $model->save(false);

            // ✅ Go to next question automatically
            return $this->redirect(['site/test', 'id' => $this->getNextQuestionId($question->id, $userId)]);
        }

        $savedAnswer = $this->getSavedAnswer($question->id);

        // ✅ Fetch tests for navigation
        $userTests = \common\models\UserTest::find()
            ->andWhere(['user_id' => $userId])
            ->with('test.questions')
            ->all();

        $answeredIds = $this->getAnsweredIds($userId);

        return $this->render('test', [
            'question'  => $question,
            'savedAnswer' => $savedAnswer,
            'userTests' => $userTests,
            'answeredIds' => $answeredIds,
        ]);
    }

    private function exportTestResultsToExcel($activeTests)
    {
        $userId = Yii::$app->user->id;
        $user = Yii::$app->user->identity;

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();


        // --- 1. User name in A1 ---
        $sheet->setCellValue('A1', $user->name);

        // --- 2. Collect tests by subject ---
        $subjects = [];
        foreach ($activeTests as $userTest) {
            $subjectName = $userTest->test->subject->title ?? 'Unknown';
            $subjects[$subjectName][] = $userTest;
        }

        // --- 3. Write each subject in columns ---
        $startCol = 3; // C = column 3
        $subjectIndex = 0;

        foreach ($subjects as $subjectName => $tests) {

            $col = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($startCol + $subjectIndex * 5);
            $sheet->setCellValue("{$col}1", $subjectName); // Subject title in row 1


            $sheet->setCellValue(
                \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($startCol + $subjectIndex * 5) . "3",
                'Дұрыс Жауап'
            );
            $sheet->setCellValue(
                \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($startCol + $subjectIndex * 5 + 1) . "3",
                'Берілген жауап'
            );
            $sheet->setCellValue(
                \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($startCol + $subjectIndex * 5 + 2) . "3",
                'Нәтиже'
            );
            $row = 4; // start filling results from row 3

            foreach ($tests as $userTest) {
                foreach ($userTest->test->questions as $question) {

                    // Get user answer
                    $userAnswer = \common\models\UserQuestion::findOne([
                        'user_id' => $userId,
                        'question_id' => $question->id,
                    ]);
                    $userAnswerText = $userAnswer->answer ?? '';
                    $correctAnswer = $question->correct;

                    // Determine result
                    if ($question->type === 'single') {
                        $result = ($userAnswerText === $correctAnswer) ? '1' : '0';
                    } else {
                        $userArray = explode(' ', $userAnswerText);
                        $correctArray = explode(' ', $correctAnswer);
                        $matches = array_intersect($userArray, $correctArray);
                        if (count($matches) === count($correctArray)) {
                            $result = '+2';
                        } elseif (count($matches) > 0) {
                            $result = '+1';
                        } else {
                            $result = '0';
                        }
                    }

                    // Fill row: Columns: subjectCol = Question, +1 = user answer, +2 = result
                    $sheet->setCellValue("{$col}{$row}", $userAnswerText);
                    $sheet->setCellValue(\PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($startCol + $subjectIndex * 5 + 1) . $row, $correctAnswer);
                    $sheet->setCellValue(\PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($startCol + $subjectIndex * 5 + 2) . $row, $result);

                    // Optional: Apply colors to result
                    $color = null;
                    if ($result === '+2' or $result === '1') $color = 'FF00FF00';
                    elseif ($result === '+1') $color = 'FFFFA500';
                    elseif ($result === '0') $color = 'FFFF0000';
                    if ($color) {
                        $sheet->getStyle(\PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($startCol + $subjectIndex * 5 + 2) . $row)
                            ->getFill()
                            ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                            ->getStartColor()->setARGB($color);
                    }

                    $row++;
                }
            }

            $subjectIndex++;
        }

        // Output the file
        $filename = uniqid() . '.xlsx';

        // Absolute path where file will be saved
        $saveDir = Yii::getAlias('@frontend/web/excels/');
        if (!is_dir($saveDir)) {
            mkdir($saveDir, 0775, true);
        }

        $absolutePath = $saveDir . $filename;

        $writer = new Xlsx($spreadsheet);
        $writer->save($absolutePath);

        // Save in result_file table
        $resultFile = new \common\models\ResultFile();
        $resultFile->user_id = $userId;
        $resultFile->file_path = '/excels/' . $filename; // relative URL
        $resultFile->save(false);

        return true;
    }

    private function calculateUserTestScore($userTest)
    {
        $userId = Yii::$app->user->id;
        $score = 0;

        foreach ($userTest->test->questions as $question) {
            $userAnswer = \common\models\UserQuestion::findOne([
                'user_id' => $userId,
                'question_id' => $question->id
            ]);

            if (!$userAnswer) continue;

            $correctAnswer = $question->correct;

            // Compare answers (string comparison)
            if ($question->type === 'single') {
                // Single choice → 1 point if correct
                if ($userAnswer->answer === $correctAnswer) {
                    $score += 1;
                }
            } else {
                // multiple or match → split into arrays
                $userAnswersArray = explode(' ', $userAnswer->answer);
                $correctAnswersArray = explode(' ', $correctAnswer);

                $matches = array_intersect($userAnswersArray, $correctAnswersArray);

                if (count($matches) === count($correctAnswersArray)) {
                    // All correct → 2 points
                    $score += 2;
                } elseif (count($matches) > 0) {
                    // At least one correct → 1 point
                    $score += 1;
                }
                // else → 0 points
            }
        }

        $userTest->score = $score;
        $userTest->save(false);

        return $score;
    }



    public function actionEndTest()
    {
        $userId = Yii::$app->user->id;

        // 1️⃣ Get all active UserTests for this user
        $activeTests = \common\models\UserTest::find()
            ->andWhere(['user_id' => $userId])
            ->with('test.questions')
            ->all();

        // 2️⃣ Collect all question IDs from all tests
        $allQuestionIds = [];
        foreach ($activeTests as $ut) {
            $questions = $ut->test->questions;
            foreach ($questions as $q) {
                $allQuestionIds[] = $q->id;
            }
        }

        // 3️⃣ Get all answered question IDs for this user
        $answeredIds = $this->getAnsweredIds($userId);

        // 4️⃣ Check if user answered all questions
        $unansweredCount = count($allQuestionIds) - count($answeredIds);
        if ($unansweredCount > 0) {
            Yii::$app->session->setFlash('error', 'Сұрақтарға жауап беріңіз! Қалған сұрақтар: ' . $unansweredCount);
            // Optional: redirect to the first unanswered question
            $firstUnanswered = array_diff($allQuestionIds, $answeredIds);
            return $this->redirect(['site/test', 'id' => reset($firstUnanswered)]);
        }

        // 5️⃣ Mark as finished and calculate scores
        foreach ($activeTests as $ut) {
            $ut->end_time = date('Y-m-d H:i:s');
            $this->calculateUserTestScore($ut);
        }

        // Export Excel file
        $this->exportTestResultsToExcel($activeTests);

        // Delete all user answers for this test
        \common\models\UserQuestion::deleteAll([
            'user_id'   => $userId
        ]);

        return $this->redirect(['site/end']);
    }

    public function actionEnd()
    {
        $this->redirectGuest();
        $this->redirectAdmin();

        $userId = Yii::$app->user->id;

        $userTests = \common\models\UserTest::find()
            ->andWhere(['user_id' => $userId])
            ->with('test.subject')
            ->all();

        // Sum all scores using SQL
        $totalScore = \common\models\UserTest::find()
            ->andWhere(['user_id' => $userId])
            ->sum('score');

        return $this->render('end', [
            'userTests' => $userTests,
            'totalScore' => $totalScore,
        ]);
    }


    public function actionAdmin()
    {
        if (!Yii::$app->user->isGuest && Yii::$app->user->identity->username === 'admin') {

            return $this->redirect(['user/index']);
        }

        $model = new \yii\base\DynamicModel(['password']); // Temporary model for the form
        $model->addRule('password', 'required', ['message' => 'Толтырыңыз!']);

        if (Yii::$app->request->isPost) {
            $model->load(Yii::$app->request->post());

            $admin = User::findByUsername('admin');

            if ($admin && Yii::$app->security->validatePassword($model->password, $admin->password_hash)) {
                Yii::$app->user->login($admin, 3600 * 24 * 30);
                return $this->redirect(['user/index']);
            } else {
                $model->addError('password', 'Құпия сөз қате!');
            }
        }

        return $this->render('admin', [
            'model' => $model,
        ]);
    }


    /**
     * Logs in a user.
     *
     * @return mixed
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }

        return $this->render('login', [
            'model' => $model,
        ]);
    }

    /**
     * Logs out the current user.
     *
     * @return mixed
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Displays contact page.
     *
     * @return mixed
     */
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail(Yii::$app->params['adminEmail'])) {
                Yii::$app->session->setFlash('success', 'Thank you for contacting us. We will respond to you as soon as possible.');
            } else {
                Yii::$app->session->setFlash('error', 'There was an error sending your message.');
            }

            return $this->refresh();
        }

        return $this->render('contact', [
            'model' => $model,
        ]);
    }

    /**
     * Displays about page.
     *
     * @return mixed
     */
    public function actionAbout()
    {
        return $this->render('about');
    }

    /**
     * Signs user up.
     *
     * @return mixed
     */
    public function actionSignup()
    {
        $model = new SignupForm();
        if ($model->load(Yii::$app->request->post()) && $model->signup()) {
            Yii::$app->session->setFlash('success', 'Thank you for registration. Please check your inbox for verification email.');
            return $this->goHome();
        }

        return $this->render('signup', [
            'model' => $model,
        ]);
    }

    /**
     * Requests password reset.
     *
     * @return mixed
     */
    public function actionRequestPasswordReset()
    {
        $model = new PasswordResetRequestForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail()) {
                Yii::$app->session->setFlash('success', 'Check your email for further instructions.');

                return $this->goHome();
            }

            Yii::$app->session->setFlash('error', 'Sorry, we are unable to reset password for the provided email address.');
        }

        return $this->render('requestPasswordResetToken', [
            'model' => $model,
        ]);
    }

    /**
     * Resets password.
     *
     * @param string $token
     * @return mixed
     * @throws BadRequestHttpException
     */
    public function actionResetPassword($token)
    {
        try {
            $model = new ResetPasswordForm($token);
        } catch (InvalidArgumentException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }

        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->resetPassword()) {
            Yii::$app->session->setFlash('success', 'New password saved.');

            return $this->goHome();
        }

        return $this->render('resetPassword', [
            'model' => $model,
        ]);
    }

    /**
     * Verify email address
     *
     * @param string $token
     * @throws BadRequestHttpException
     * @return yii\web\Response
     */
    public function actionVerifyEmail($token)
    {
        try {
            $model = new VerifyEmailForm($token);
        } catch (InvalidArgumentException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }
        if ($model->verifyEmail()) {
            Yii::$app->session->setFlash('success', 'Your email has been confirmed!');
            return $this->goHome();
        }

        Yii::$app->session->setFlash('error', 'Sorry, we are unable to verify your account with provided token.');
        return $this->goHome();
    }

    /**
     * Resend verification email
     *
     * @return mixed
     */
    public function actionResendVerificationEmail()
    {
        $model = new ResendVerificationEmailForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail()) {
                Yii::$app->session->setFlash('success', 'Check your email for further instructions.');
                return $this->goHome();
            }
            Yii::$app->session->setFlash('error', 'Sorry, we are unable to resend verification email for the provided email address.');
        }

        return $this->render('resendVerificationEmail', [
            'model' => $model
        ]);
    }
}
