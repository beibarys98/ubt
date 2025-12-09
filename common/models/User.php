<?php

namespace common\models;

use Yii;
use yii\base\NotSupportedException;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;

class User extends ActiveRecord implements IdentityInterface
{
    public $subject_1;
    public $subject_2;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            ['subject_1', 'required', 'message' => 'Пәнді таңдаңыз!'],
            ['subject_2', 'required', 'message' => 'Пәнді таңдаңыз!'],
            ['subject_2', 'compare', 'compareAttribute' => 'subject_1', 'operator' => '!=', 'message' => 'Пәндер бірдей!'],
            ['subject_1', 'compare', 'compareAttribute' => 'subject_2', 'operator' => '!=', 'message' => 'Пәндер бірдей!'],

            [['password_hash'], 'default', 'value' => null],
            [['auth_key'], 'required'],
            [['password_hash'], 'string', 'max' => 255],
            [['auth_key'], 'string', 'max' => 32],

            [['username'], 'required', 'message' => 'Толтырыңыз!'],
            ['username', 'match', 'pattern' => '/^\d{12}$/', 'message' => 'ЖСН қате!'],
            [['username'], 'unique'],
            
            // Updated name rules
            ['name', 'required', 'message' => 'Толтырыңыз!'],
            ['name', 'string', 'max' => 255, 'tooLong' => 'Тым ұзын!'],
            ['name', 'match', 
                'pattern' => '/^[А-Яа-яЁёӘәІіҢңҒғҮүҰұҚқӨөҺһ-]+(?:\s[А-Яа-яЁёӘәІіҢңҒғҮүҰұҚқӨөҺһ-]+)+$/u', 
                'message' => 'Мысалы: Мухаммедьяров Бейбарыс'
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'username' => 'Username',
            'auth_key' => 'Auth Key',
            'password_hash' => 'Password Hash',
        ];
    }

    /**
     * {@inheritdoc}
     * @return \common\models\query\UserQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \common\models\query\UserQuery(get_called_class());
    }

        /**
     * {@inheritdoc}
     */
    public static function findIdentity($id)
    {
        return static::findOne(['id' => $id]);
    }

    /**
     * {@inheritdoc}
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        throw new NotSupportedException('"findIdentityByAccessToken" is not implemented.');
    }

    /**
     * Finds user by username
     *
     * @param string $username
     * @return static|null
     */
    public static function findByUsername($username)
    {
        return static::findOne(['username' => $username]);
    }

    /**
     * {@inheritdoc}
     */
    public function getId()
    {
        return $this->getPrimaryKey();
    }

    /**
     * {@inheritdoc}
     */
    public function getAuthKey()
    {
        return $this->auth_key;
    }

    /**
     * {@inheritdoc}
     */
    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return bool if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return Yii::$app->security->validatePassword($password, $this->password_hash);
    }

    /**
     * Generates password hash from password and sets it to the model
     *
     * @param string $password
     */
    public function setPassword($password)
    {
        $this->password_hash = Yii::$app->security->generatePasswordHash($password);
    }

    /**
     * Generates "remember me" authentication key
     */
    public function generateAuthKey()
    {
        $this->auth_key = Yii::$app->security->generateRandomString();
    }

    public function getUserTests()
    {
        return $this->hasMany(\common\models\UserTest::class, ['user_id' => 'id']);
    }

    public function getResultFile()
    {
        return $this->hasOne(\common\models\ResultFile::class, ['user_id' => 'id']);
    }
}