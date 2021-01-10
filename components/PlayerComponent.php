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
        $user->virtual_balance += $userPrize->prize->type->coefficient * $userPrize->quantity;

        return $user->save();
    }
}