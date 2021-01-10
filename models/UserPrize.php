<?php

namespace app\models;

use yii\db\{ActiveQuery, ActiveRecord};

/**
 * Class UserPrize
 *
 * @property int $id
 * @property int|null $prize_id
 * @property int|null $user_id
 * @property int|null $quantity
 * @property string $created_at
 * @property string $status
 *
 * @property Prize $prize
 * @property User $user
 */
class UserPrize extends ActiveRecord
{
    const APPROVAL_STATUS = 'approval';
    const CANCEL_STATUS = 'canceled';
    const RESERVED_STATUS = 'reserved';
    const ISSUED_STATUS = 'issued';
    /**
     * @return string
     */
    public static function tableName(): string
    {
        return 'users_prizes';
    }

    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            [['prize_id', 'user_id', 'quantity'], 'integer'],
            [['created_at'], 'safe'],
            [
                ['prize_id'],
                'exist',
                'skipOnError' => true,
                'targetClass' => Prize::class,
                'targetAttribute' => ['prize_id' => 'id']
            ], [
                ['user_id'],
                'exist',
                'skipOnError' => true,
                'targetClass' => User::class,
                'targetAttribute' => ['user_id' => 'id']
            ],
        ];
    }

    /**
     * @return array
     */
    public function attributeLabels(): array
    {
        return [
            'id' => 'ID',
            'prize_id' => 'Prize ID',
            'user_id' => 'User ID',
            'quantity' => 'Quantity',
            'created_at' => 'Created At',
        ];
    }

    /**
     * Gets query for [[Prize]].
     *
     * @return ActiveQuery
     */
    public function getPrize(): ActiveQuery
    {
        return $this->hasOne(Prize::class, ['id' => 'prize_id']);
    }

    /**
     * Gets query for [[User]].
     *
     * @return ActiveQuery
     */
    public function getUser(): ActiveQuery
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }
}
