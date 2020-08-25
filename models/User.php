<?php

namespace app\models;

class User extends \yii\base\BaseObject implements \yii\web\IdentityInterface
{
    public $id;

    public static function findIdentity($id)
    {
        $user = new self();
        $user->id = rand(1, 1000);

        return $user;
    }

    public function getId(): int
    {
        return $this->id;
    }

    /**
     * This function is not used, but required for IdentityInterface
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        return null;
    }

    /**
     * This function is not used, but required for IdentityInterface
     */
    public function getAuthKey()
    {
        return null;
    }

    /**
     * This function is not used, but required for IdentityInterface
     */
    public function validateAuthKey($authKey): bool
    {
        return false;
    }
}
