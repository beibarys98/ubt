<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "admin".
 *
 * @property int $id
 * @property string $password_hash
 */
class Admin extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'admin';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['password_hash'], 'required'],
            [['password_hash'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'password_hash' => 'Password Hash',
        ];
    }

    /**
     * {@inheritdoc}
     * @return \common\models\query\AdminQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \common\models\query\AdminQuery(get_called_class());
    }

}
