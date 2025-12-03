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

    /**
     * Displays homepage.
     *
     * @return mixed
     */
    public function actionIndex()
    {
        // Guest user redirection
        if(Yii::$app->user->isGuest){
            return $this->redirect(['site/login']);
        }

        // Admin user redirection
        if(Yii::$app->user->identity->username === 'admin'){
            return $this->redirect(['user/index']);
        }
        
        // Regular user logic
        $model = User::findOne(Yii::$app->user->id);

        // Check how many tests the user has taken
        $userTestCount = \common\models\UserTest::find()
            ->andWhere(['user_id' => $model->id])
            ->count();
        if ($userTestCount == 5) {
            $firstUserTest = \common\models\UserTest::find()
                ->andWhere(['user_id' => $model->id])
                ->with('test.questions')
                ->orderBy('id ASC') // take the first inserted
                ->one();

            $firstQuestionId = $firstUserTest->test->questions[0]->id ?? null;
            return $this->redirect(['test', 'id' => $firstQuestionId]); // All tests completed
        }

        // Fetch subjects excluding the default ones
        $subjects = \common\models\Subject::find()
            ->select(['title', 'id'])
            ->andWhere(['not in', 'id', [4, 5, 6]]) // Exclude default subjects
            ->indexBy('id')
            ->column();

        // Handle form submission
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {

            $model->save(false);

            // Prepare the list of subjects for test assignment
            $defaultSubjectIds = \common\models\Subject::find()
                ->select('id')
                ->andWhere(['id' => [4, 5, 6]]) // IDs of default subjects
                ->column();
            $selectedSubjectIds = array_filter([$model->subject_1, $model->subject_2]);
            $allSubjectIds = array_merge($defaultSubjectIds, $selectedSubjectIds);
            \common\models\UserTest::deleteAll(['user_id' => $model->id]);

            // Assign tests to the user
            foreach ($allSubjectIds as $subjectId) {
                $test = \common\models\Test::find()
                    ->andWhere(['subject_id' => $subjectId])
                    ->andWhere(['status' => 'public'])
                    ->orderBy(new \yii\db\Expression('RAND()')) // MySQL
                    ->one();
                
                if (!$test) continue;

                $userTest = new \common\models\UserTest();
                $userTest->user_id = $model->id;
                $userTest->test_id = $test->id;
                $userTest->start_time = date('Y-m-d H:i:s');
                $userTest->save(false);
            }

            // Redirect to the first question of the first assigned test
            $firstUserTest = \common\models\UserTest::find()
                ->andWhere(['user_id' => $model->id])
                ->with('test.questions')
                ->orderBy('id ASC') // take the first inserted
                ->one();

            $firstQuestionId = $firstUserTest->test->questions[0]->id ?? null;

            return $this->redirect(['test', 'id' => $firstQuestionId]);
        }

        return $this->render('index', [
            'model' => $model,
            'subjects' => $subjects,
        ]);
    }

    public function actionTest($id = null)
    {
        if(Yii::$app->user->isGuest){
            return $this->redirect(['site/login']);
        }

        $question = \common\models\Question::findOne($id);

        $userId = Yii::$app->user->id;
        $userTests = \common\models\UserTest::find()
            ->andWhere(['user_id' => $userId])
            ->with('test.questions') // eager load questions
            ->all();

        return $this->render('test', [
            'question' => $question,
            'userTests' => $userTests,
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
