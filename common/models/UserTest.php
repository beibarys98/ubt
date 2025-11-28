<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "user_test".
 *
 * @property int $id
 * @property int $user_id
 * @property int $test_id
 * @property string|null $start_time
 * @property string|null $end_time
 * @property float|null $score
 *
 * @property Test $test
 * @property User $user
 */
class UserTest extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user_test';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['start_time', 'end_time', 'score'], 'default', 'value' => null],
            [['user_id', 'test_id'], 'required'],
            [['user_id', 'test_id'], 'integer'],
            [['start_time', 'end_time'], 'safe'],
            [['score'], 'number'],
            [['test_id'], 'exist', 'skipOnError' => true, 'targetClass' => Test::class, 'targetAttribute' => ['test_id' => 'id']],
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
            'test_id' => 'Test ID',
            'start_time' => 'Start Time',
            'end_time' => 'End Time',
            'score' => 'Score',
        ];
    }

    /**
     * Gets query for [[Test]].
     *
     * @return \yii\db\ActiveQuery|\common\models\query\TestQuery
     */
    public function getTest()
    {
        return $this->hasOne(Test::class, ['id' => 'test_id']);
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
     * @return \common\models\query\UserTestQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \common\models\query\UserTestQuery(get_called_class());
    }

}
