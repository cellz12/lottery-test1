<?php


namespace app\commands;

use Yii;
use app\models\UserPrize;
use yii\console\Controller;

/**
 * Class PrizeController
*/
class PrizeController extends Controller
{
    /**
     * @return void
     */
    public function actionCheckReservedPrizes(): void
    {
        $query = UserPrize::find()
            ->where(['status' => UserPrize::RESERVED_STATUS])
            ->andWhere('DATE_ADD(created_at, INTERVAL 1 HOUR) < NOW()');

        foreach ($query->each(30) as $userPrize) {
            Yii::$app->lottery->cancelPrize($userPrize);
        }
    }
}