<?php

namespace app\components;

use Yii;
use Throwable;
use yii\db\Expression;
use app\models\{Prize, PrizeType, User, UserPrize};

/**
 * Class PrizeComponent
*/
class PrizeComponent
{
    /**
     * @return Prize|null
     */
    public function getRandom(): ?Prize
    {
        /**
         * @var Prize $prize
         */
        $prize = Prize::find()->alias('p')->where(['!=', 'available_count', 0])
            ->orderBy(new Expression('rand()'))->one();

        if(is_null($prize)) {
            return null;
        }

        $prize->quantity = rand(1, $prize->type->interval);

        return $prize;
    }

    /**
     * Save prize result
     *
     * @param User $user
     * @param Prize $prize
     *
     * @return UserPrize
     */
    public function saveResult(User $user, Prize $prize): UserPrize
    {
        $transaction = Yii::$app->db->beginTransaction();
        $userPrize = new UserPrize();
        try{
            $userPrize->user_id = $user->id;
            $userPrize->prize_id = $prize->id;
            $userPrize->quantity = $prize->quantity;
            $userPrize->status = UserPrize::RESERVED_STATUS;

            $userPrize->save();

            if ($prize->type->type !== PrizeType::TYPE_VIRTUAL) {
                $userPrize->prize->updateCounters(['available_count' => -$userPrize->quantity]);
                $userPrize->prize->save();
            }

            $transaction->commit();
        } catch(Throwable $e) {
            $transaction->rollBack();
        }

        return $userPrize;
    }

    /**
     * @param UserPrize $userPrize
     */
    public function approval(UserPrize $userPrize): void
    {
        $transaction = Yii::$app->db->beginTransaction();
        try{
            $userPrize->status = UserPrize::APPROVAL_STATUS;
            $userPrize->update();

            if ($userPrize->prize->type->type === PrizeType::TYPE_REAL) {
                $userPrize->user->updateCounters(['balance' => $userPrize->quantity]);
            }

            if ($userPrize->prize->type->type === PrizeType::TYPE_VIRTUAL) {
                $userPrize->user->updateCounters(['virtual_balance' => $userPrize->quantity]);
            }

            $userPrize->user->save();

            $transaction->commit();
        } catch(Throwable $e) {
            $transaction->rollBack();
        }
    }

    /**
     * @param UserPrize $userPrize
     * @return void
     */
    public function cancel(UserPrize $userPrize): void
    {
        $transaction = Yii::$app->db->beginTransaction();
        try {
            if($userPrize->prize->type->type !== PrizeType::TYPE_VIRTUAL) {
                $userPrize->prize->updateCounters(['available_count' => $userPrize->quantity]);
            }

            $userPrize->status = UserPrize::CANCEL_STATUS;
            $userPrize->update();

            $transaction->commit();
        } catch(Throwable $e) {
            $transaction->rollBack();
        }
    }
}