<?php

namespace common\models;

use Yii;
use yii\base\Model;

/**
 * Login form
 */
class LoginForm extends Model
{
    public $username;
    public $check;
    public $password;

    private $_user;

    public function rules()
    {
        return [
            [['username', 'check'], 'required', 'message' => 'Толтырыңыз!'],
            ['username', 'match', 'pattern' => '/^\d{12}$/', 'message' => 'ЖСН қате!'],
            ['check', 'compare', 'compareAttribute' => 'username', 'message' => 'ЖСН қате!'],
        ];
    }

    public function login()
    {
        if (!$this->validate()) {
            return false;
        }

        // Get existing user OR create new one
        $user = $this->getUser();
        if ($user === null) {
            $user = new User();
            $user->username = $this->username;
            $user->generateAuthKey();

            $user->save(false);
        }

        return Yii::$app->user->login($user, 3600 * 24 * 30); // 30 days
    }

    protected function getUser()
    {
        if ($this->_user === null) {
            $this->_user = User::findByUsername($this->username);
        }

        return $this->_user;
    }
}
