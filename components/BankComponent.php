<?php

namespace app\components;

use app\models\User;

/**
 * Class BankComponent
 */
class BankComponent
{
    /**
     * Send money to card
     *
     * @param User $user
     * @param float $amount
     *
     * @return bool
     */
    public function sendMoneyToCard(User $user, float $amount): bool
    {
        if ($amount <= 0) {
            return false;
        }

        // processing bank api...

        $user->updateCounters(['balance' => -$amount]);

        return true;
    }
}