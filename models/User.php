<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;

class User extends ActiveRecord implements IdentityInterface
{
    public static function tableName()
    {
        return '{{%user}}';
    }

    public function rules()
    {
        return [
            [['name', 'email', 'password'], 'required'],
            ['email', 'email'],
            ['email', 'unique'],
            [['name', 'email', 'password'], 'string', 'max' => 255],
        ];
    }

    public static function findIdentity($id)
    {
        return static::findOne($id);
    }

    public static function findIdentityByAccessToken($token, $type = null)
    {
        return static::findOne(['access_token' => $token]);
    }

    public static function findByEmail($email)
    {
        return static::findOne(['email' => $email]);
    }

    public function getId()
    {
        return $this->id;
    }

    public function getAuthKey()
    {
        return $this->auth_key;
    }

    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }

    public function validatePassword($password)
    {
        // Проверка через хэш (или прямое сравнение, если пароли хранятся в открытом виде)
        if (password_verify($password, $this->password) || $this->password === $password) {
            return true;
        }
        return false;
    }

    // Метод создания пользователя (используется в SignupForm в методичке)
    public function create()
    {
        if (empty($this->auth_key)) {
            $this->auth_key = Yii::$app->security->generateRandomString();
        }
        // Хэшируем пароль перед сохранением
        $this->password = Yii::$app->security->generatePasswordHash($this->password);
        return $this->save();
    }
    /**
     * Геттер для совместимости: возвращает name или email при обращении к $user->username
     */
    public function getUsername()
    {
        if ($this->hasAttribute('username') && !empty($this->getAttribute('username'))) {
            return $this->getAttribute('username');
        }
        if ($this->hasAttribute('name') && !empty($this->getAttribute('name'))) {
            return $this->getAttribute('name');
        }
        if ($this->hasAttribute('email') && !empty($this->getAttribute('email'))) {
            return $this->getAttribute('email');
        }
        return 'Користувач #' . $this->id;
    }
}
