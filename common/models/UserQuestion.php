<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "user_question".
 *
 * @property int $id
 * @property int $user_id
 * @property int $question_id
 * @property string|null $answer
 *
 * @property Question $question
 * @property User $user
 */
class UserQuestion extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user_question';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['answer'], 'default', 'value' => null],
            [['user_id', 'question_id'], 'required'],
            [['user_id', 'question_id'], 'integer'],
            [['answer'], 'string', 'max' => 255],
            [['user_id', 'question_id'], 'unique', 'targetAttribute' => ['user_id', 'question_id']],
            [['question_id'], 'exist', 'skipOnError' => true, 'targetClass' => Question::class, 'targetAttribute' => ['question_id' => 'id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'question_id' => 'Question ID',
            'answer' => 'Answer',
        ];
    }

    /**
     * Gets query for [[Question]].
     *
     * @return \yii\db\ActiveQuery|\common\models\query\QuestionQuery
     */
    public function getQuestion()
    {
        return $this->hasOne(Question::class, ['id' => 'question_id']);
    }

    /**
     * Gets query for [[User]].
     *
     * @return \yii\db\ActiveQuery|\common\models\query\UserQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }

    /**
     * {@inheritdoc}
     * @return \common\models\query\UserQuestionQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \common\models\query\UserQuestionQuery(get_called_class());
    }

}
