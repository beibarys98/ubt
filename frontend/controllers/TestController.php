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
                        $fileName = uniqid() . '_' . $file->name;
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
                        } else {
                            $correctAnswer = null;
                        }

                        $question->correct = $correctAnswer;


                        // Determine question type based on answer format
                        if (!$correctAnswer) {
                            $question->type = 'single'; // default
                        } elseif (preg_match('/^[A-Z]$/i', $correctAnswer)) {
                            $question->type = 'single';
                        } elseif (preg_match('/^[A-Z]{2,}$/i', $correctAnswer)) {
                            $question->type = 'multiple';
                        } elseif (preg_match('/^([A-Z]-\d\s?)+$/i', $correctAnswer)) {
                            $question->type = 'match';
                        } else {
                            $question->type = 'single'; // fallback
                        }

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
