<?php

namespace app\models;

use Yii;
use yii\base\Exception;
use yii\web\IdentityInterface;
use yii\db\{ActiveRecord, ActiveQuery};

/**
 * Class User
 * @property integer id
 * @property string email
 * @property string password
 * @property integer card_number
 * @property string username
 * @property int|null balance
 * @property float|null virtual_balance
 */
class User extends ActiveRecord implements IdentityInterface
{
    /**
     * @var string
     */
    public $authKey;

    /**
     * @var string
     */
    public $accessToken;

    /**
     * @return string
    */
    public static function tableName(): string
    {
        return 'users';
    }

    /**
     * {@inheritdoc}
     */
    public static function findIdentity($id): ?self
    {
        return static::findOne($id);
    }

    /**
     * {@inheritdoc}
     */
    public static function findIdentityByAccessToken($token, $type = null): ?IdentityInterface
    {
        return null;
    }

    /**
     * Finds user by email
     *
     * @param string $email
     * @return static|null
     */
    public static function findByEmail(string $email): ?self
    {
        return self::findOne(['email' => $email]);
    }

    /**
     * {@inheritdoc}
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * {@inheritdoc}
     */
    public function getAuthKey(): ?string
    {
        return $this->authKey;
    }

    /**
     * @param string $password
     * @throws Exception
     * @return void
     */
    public function setPasswordHash(string $password): void
    {
        $this->password = Yii::$app->getSecurity()->generatePasswordHash($password);
    }

    /**
     * {@inheritdoc}
     */
    public function validateAuthKey($authKey): bool
    {
        return $this->authKey === $authKey;
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return bool if password provided is valid for current user
     */
    public function validatePassword(string $password): bool
    {
        return Yii::$app->getSecurity()->validatePassword($password, $this->password);
    }

    /**
     * Gets query for [[UsersPrizes]].
     *
     * @return ActiveQuery
     */
    public function getPrizes(): ActiveQuery
    {
        return $this->hasMany(UserPrize::class, ['user_id' => 'id']);
    }

    /**
     *
     * @param bool $runValidation
     * @return bool
     */
    public function login(bool $runValidation = true): bool
    {
        if (!$runValidation || $this->validate()) {
            return Yii::$app->user->login($this, 3600*24*30);
        }

        return false;
    }
}
