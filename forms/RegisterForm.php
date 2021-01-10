<?php

namespace app\forms;

use yii\base\Model;
use app\models\User;

/**
 * Class RegisterForm
 */
class RegisterForm extends Model
{
    /**
     * @var string $username
    */
    public $username;

    /**
     * @var string $email
     */
    public $email;

    /**
     * @var string $password
     */
    public $password;

    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            [['email', 'username', 'password'], 'required'],
            [['email', 'username', 'password'], 'trim'],
            ['username', 'unique', 'targetClass' => User::class],
            ['username', 'string', 'min' => 2, 'max' => 10],
            ['email', 'email'],
            ['email', 'unique', 'targetClass' => User::class],
            ['password', 'required'],
            ['password', 'string', 'min' => 4],
        ];
    }
}
