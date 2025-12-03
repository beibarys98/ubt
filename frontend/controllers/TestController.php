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


    /**
     * Creates a new Test model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new Test();

        $subjects = \common\models\Subject::find()->all();

        if ($this->request->isPost) {
            if ($model->load($this->request->post())) {

                $model->images = \yii\web\UploadedFile::getInstances($model, 'images');
                $answers = preg_split("/\r\n|\n|\r/", trim($model->answersText));

                if ($model->save() && $model->validate()) {
                    foreach ($model->images as $index => $file) {
                        // Save uploaded file
                        $uploadDir = Yii::getAlias('@webroot/uploads/questions');
                        if (!is_dir($uploadDir)) {
                            mkdir($uploadDir, 0755, true);
                        }
                        $fileName = time() . '_' . $file->name;
                        $filePath = $uploadDir . '/' . $fileName;
                        $file->saveAs($filePath);

                        // Create Question record
                        $question = new Question();
                        $question->test_id = $model->id;
                        $question->img_path = 'uploads/questions/' . $fileName;

                        // Determine correct answer from pasted text
                        $line = isset($answers[$index]) ? trim($answers[$index]) : null;

                        if ($line) {
                            // Remove leading number with OPTIONAL dot and OPTIONAL space
                            $correctAnswer = preg_replace('/^\d+[\.\)]?\s*/', '', $line);
                            $correctAnswer = strtoupper($correctAnswer);
                        } else {
                            $correctAnswer = null;
                        }

                        // Determine question type based on answer format
                        if ($correctAnswer) {
                            if (str_contains($correctAnswer, '-')) {
                                // Match question (any hyphen)
                                $question->type = 'match';
                                $correctAnswer = preg_replace('/[^A-Z0-9\-\s]/i', '', $correctAnswer);
                            } else {
                                // Keep only letters
                                $lettersOnly = preg_replace('/[^A-Z]/', '', $correctAnswer);

                                if (strlen($lettersOnly) === 1) {
                                    $question->type = 'single';
                                } elseif (strlen($lettersOnly) >= 2) {
                                    $question->type = 'multiple';
                                } else {
                                    $question->type = 'single'; // fallback
                                }

                                // Remove duplicate letters
                                $letters = str_split($lettersOnly);
                                $uniqueLetters = array_unique($letters);
                                $correctAnswer = implode('', $uniqueLetters);
                            }
                        } else {
                            $question->type = 'single';
                        }
                        $question->correct = $correctAnswer;
                        $question->save();
                    }

                    return $this->redirect(['view', 'id' => $model->id]);
                }

                return $this->redirect(['view', 'id' => $model->id]);
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
            'subjects' => $subjects,
        ]);
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
