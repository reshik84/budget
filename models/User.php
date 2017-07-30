<?php

namespace app\models;

use yii\base\Security;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;

class User extends ActiveRecord implements \yii\web\IdentityInterface
{

    public $password;

    public function behaviors()
    {
        return [
            'timestump' => [
                'class' => TimestampBehavior::className()
            ]
        ];
    }


    /**
     * @inheritdoc
     */
    public static function findIdentity($id)
    {
        return self::findOne($id);
    }

    /**
     * @inheritdoc
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        foreach (self::$users as $user) {
            if ($user['accessToken'] === $token) {
                return new static($user);
            }
        }

        return null;
    }

    /**
     * Finds user by username
     *
     * @param string $username
     * @return static|null
     */
    public static function findByUsername($username)
    {
        foreach (self::$users as $user) {
            if (strcasecmp($user['username'], $username) === 0) {
                return new static($user);
            }
        }

        return null;
    }

    /**
     * @inheritdoc
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @inheritdoc
     */
    public function getAuthKey()
    {
        return $this->auth_key;
    }

    /**
     * @inheritdoc
     */
    public function validateAuthKey($authKey)
    {
        return $this->authKey === $authKey;
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return bool if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return $this->password === $password;
    }

    public function generateAuthKey(){
        $this->auth_key = \Yii::$app->security->generateRandomString();
    }

    public function generatePasswordResetToken(){
        $this->password_reset_token = \Yii::$app->security->generateRandomString();
    }

    public function beforeSave($insert)
    {
        if(parent::beforeSave($insert)){
            $this->password_hash = \Yii::$app->security->generatePasswordHash($this->password);
            return true;
        }
        return false;
    }

}
