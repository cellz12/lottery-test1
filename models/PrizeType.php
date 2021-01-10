<?php

namespace app\models;

use yii\db\{ActiveQuery, ActiveRecord};

/**
 * Class PrizeType
 *
 * @property int $id
 * @property string $title
 * @property integer $interval
 * @property string $created_at
 * @property string|null $updated_at
 * @property integer $coefficient
 * @property string $type
 *
 * @property Prize[] $prizes
 */
class PrizeType extends ActiveRecord
{
    const TYPE_REAL = 'real';
    const TYPE_ITEM = 'item';
    const TYPE_VIRTUAL = 'virtual';

    /**
     * @return string
     */
    public static function tableName(): string
    {
        return 'prize_type';
    }

    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            [['title'], 'required'],
            [['created_at', 'updated_at'], 'safe'],
            [['title'], 'string', 'max' => 50],
            [['title'], 'unique'],
        ];
    }

    /**
     * @return array
     */
    public function attributeLabels(): array
    {
        return [
            'id' => 'ID',
            'title' => 'Title',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * Gets query for [[Prizes]].
     *
     * @return ActiveQuery
     */
    public function getPrizes(): ActiveQuery
    {
        return $this->hasMany(Prize::class, ['type_id' => 'id']);
    }
}
