<?php

namespace app\models;

use yii\db\{ActiveRecord, ActiveQuery};

/**
 * Class Prize
 *
 * @property int $id
 * @property int|null $type_id
 * @property string $title
 * @property string|null $description
 * @property int|null $available_count
 * @property string|null $data
 * @property string $created_at
 * @property string|null $updated_at
 *
 * @property PrizeType $type
 * @property UserPrize[] $usersPrizes
 */
class Prize extends ActiveRecord
{
    /**
     * @var integer $quantity
     */
    public $quantity;

    /**
     * @return string
     */
    public static function tableName(): string
    {
        return 'prizes';
    }

    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            [['type_id', 'available_count'], 'integer'],
            [['title'], 'required'],
            [['data'], 'string'],
            [['created_at', 'updated_at'], 'safe'],
            [['title', 'description'], 'string', 'max' => 255],
            [
                ['type_id'],
                'exist',
                'skipOnError' => true,
                'targetClass' => PrizeType::class,
                'targetAttribute' => ['type_id' => 'id']
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels(): array
    {
        return [
            'id' => 'ID',
            'type_id' => 'Type ID',
            'title' => 'Title',
            'description' => 'Description',
            'available_count' => 'Available Count',
            'data' => 'Data',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * Gets query for [[Type]].
     *
     * @return ActiveQuery
     */
    public function getType(): ActiveQuery
    {
        return $this->hasOne(PrizeType::class, ['id' => 'type_id']);
    }

    /**
     * Gets query for [[UsersPrizes]].
     *
     * @return ActiveQuery
     */
    public function getUsersPrizes(): ActiveQuery
    {
        return $this->hasMany(UserPrize::class, ['prize_id' => 'id']);
    }
}
