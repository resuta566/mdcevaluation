<?php

namespace app\models;

class User extends \yii\base\BaseObject implements \yii\web\IdentityInterface
{
    const USER_STUDENT = 10;
    const USER_TEACHER = 20;
    const USER_HEAD = 30;
    const USER_SA = 50;
    const USER_GUIDANCE = 60;
    const USER_CASHIER = 70;
    const USER_REGISTRAR = 80;
    const USER_ADMIN = 100;

    public $id;
    public $username;
    public $password;
    public $role;
    public $authKey;
    public $accessToken;

    private static $users = [
        '100' => [
            'id' => '100',
            'username' => 'admin',
            'password' => 'admin',
            'role' => '100',
            'authKey' => 'test100key',
            'accessToken' => '100-token',
        ],
        '101' => [
            'id' => '101',
            'username' => 'demo',
            'password' => 'demo',
            'authKey' => 'test101key',
            'accessToken' => '101-token',
        ],
    ];

    public static function getRoles() {
        return $roles = [
            10 => 'Student',
            20 => 'Teacher',
            30 => 'Head',
            50 => 'Student Affairs',
            60 => 'Guidance Counselor',
            70 => 'Cashier',
            80 => 'Registrar',
            100 => 'System Administrator',
        ];
    }

    public function getRoleName() {
        return static::getRoles()[$this->role];
    }


    /**
     * {@inheritdoc}
     */
    public static function findIdentity($id)
    {
        return isset(self::$users[$id]) ? new static(self::$users[$id]) : null;
    }

    public static function findRole($role)
    {
        return isset(self::$users[$role]) ? new static(self::$users[$role]) : null;
    }   

    /**
     * {@inheritdoc}
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
     * {@inheritdoc}
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * {@inheritdoc}
     */
    public function getAuthKey()
    {
        return $this->authKey;
    }

    /**
     * {@inheritdoc}
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
}
