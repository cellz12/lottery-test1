<?php

namespace app\components;

use app\models\{UserPrize, User};

/**
 * Class PlayerComponent
 */
class PlayerComponent
{
    /**
     * @param User $user
     * @param UserPrize $userPrize
     *
     * @return bool
     */
    public function convertRealToVirtual(User $user, UserPrize $userPrize)
    {
        $user->balance -= $userPrize->quantity;
        $user->virtual_balance += $this->calculateVirtualBalance($userPrize->prize->type->coefficient, $userPrize->quantity);

        return $user->save();
    }

    /**
     * @param int $coefficient
     * @param int $quantity
     *
     * @return int
     */
    public function calculateVirtualBalance(int $coefficient, int $quantity): int
    {
        if($quantity <= 0) {
            $quantity = 1;
        }

        if($coefficient <= 0) {
            $coefficient = 1;
        }

        return $coefficient * $quantity;
    }
}