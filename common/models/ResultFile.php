<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "result_file".
 *
 * @property int $id
 * @property int $user_id
 * @property string $file_path
 *
 * @property User $user
 */
class ResultFile extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'result_file';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'file_path'], 'required'],
            [['user_id'], 'integer'],
            [['file_path'], 'string', 'max' => 255],
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
            'file_path' => 'File Path',
        ];
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
     * @return \common\models\query\ResultFileQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \common\models\query\ResultFileQuery(get_called_class());
    }

}
