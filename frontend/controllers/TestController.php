<?php

namespace frontend\controllers;

use common\models\Test;
use common\models\Question;
use common\models\search\TestSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use Yii;

/**
 * TestController implements the CRUD actions for Test model.
 */
class TestController extends Controller
{
    /**
     * @inheritDoc
     */
    public function behaviors()
    {
        return array_merge(
            parent::behaviors(),
            [
                'verbs' => [
                    'class' => VerbFilter::className(),
                    'actions' => [
                        'delete' => ['POST'],
                    ],
                ],
            ]
        );
    }

    /**
     * Lists all Test models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new TestSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionCropper()
    {
        // Path to the file
        $file = Yii::getAlias('@webroot/MBcropper/MBcropper.exe');

        // Check if the file exists
        if (!file_exists($file)) {
            throw new \yii\web\NotFoundHttpException('The requested file does not exist.');
        }

        // Send the file as a download
        return Yii::$app->response->sendFile($file, 'MBcropper.exe');
    }


    /**
     * Displays a single Test model.
     * @param int $id ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    public function actionStatus($id, $status)
    {
        $model = Test::findOne($id);
        $model->status = $status;
        $model->save(false);

        return $this->redirect(Yii::$app->request->referrer);
    }

    private function parseAnswers($text)
    {
        return preg_split("/\r\n|\n|\r/", trim($text));
    }

    private function createQuestions($test, $images, $answers)
    {
        foreach ($images as $index => $file) {

            $filePath = $this->saveQuestionImage($file);

            $question = new Question();
            $question->test_id  = $test->id;
            $question->img_path = $filePath;

            $rawAnswer = $answers[$index] ?? null;

            [$type, $correct] = $this->detectTypeAndAnswer($rawAnswer);

            $question->type    = $type;
            $question->correct = $correct;

            $question->save(false);
        }
    }

    private function saveQuestionImage($file)
    {
        $uploadDir = Yii::getAlias('@webroot/uploads/questions');

        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0755, true);
        }

        $fileName = time() . '_' . $file->name;
        $filePath = $uploadDir . '/' . $fileName;

        $file->saveAs($filePath);

        return 'uploads/questions/' . $fileName;
    }

    private function detectTypeAndAnswer($line)
    {
        if (!$line) {
            return ['single', null];
        }

        // Remove leading number
        $answer = preg_replace('/^\d+[\.\)]?\s*/', '', trim($line));
        $answer = strtoupper($answer);

        // Cyrillic → Latin mapping
        $map = [
            'А' => 'A',
            'Б' => 'B',
            'В' => 'B',
            'С' => 'C',
            'Д' => 'D',
        ];
        $answer = strtr($answer, $map);

        // ✅ MATCH TYPE
        if (str_contains($answer, '-')) {
            $clean = preg_replace('/[^A-Z0-9\-\s,;:.]/i', '', $answer);
            $clean = preg_replace('/[,:;]/', ' ', $clean);
            $clean = preg_replace('/\s+/', ' ', trim($clean));

            return ['match', $clean];
        }

        // ✅ SINGLE / MULTIPLE
        $lettersOnly = preg_replace('/[^A-Z]/', '', $answer); // keep only letters
        $allLetters  = str_split($lettersOnly);              // keep duplicates for counting
        $unique      = array_unique($allLetters);            // for display
        $final       = implode(' ', $unique);

        // ✅ Determine single or multiple based on actual count (with duplicates)
        if (count($allLetters) === 1) {
            return ['single', $final];
        }

        if (count($allLetters) >= 2) {
            return ['multiple', $final];
        }

        return ['single', $final];
    }

    public function actionCreate()
    {
        $model = new Test();
        $subjects = \common\models\Subject::find()->all();

        if (!$this->request->isPost) {
            $model->loadDefaultValues();
            return $this->render('create', compact('model', 'subjects'));
        }

        if (!$model->load($this->request->post())) {
            return $this->render('create', compact('model', 'subjects'));
        }

        $model->images  = \yii\web\UploadedFile::getInstances($model, 'images');
        $answers        = $this->parseAnswers($model->answersText);

        if (!$model->save()) {
            return $this->render('create', compact('model', 'subjects'));
        }

        $this->createQuestions($model, $model->images, $answers);

        return $this->redirect(['view', 'id' => $model->id]);
    }


    /**
     * Updates an existing Test model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Test model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Test model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Test the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Test::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
