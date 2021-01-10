<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\{Controller, Response};
use app\models\{PrizeType, User, UserPrize};

/**
 * Class PrizeController
*/
class PrizeController extends Controller
{
    /**
     * @return array
     */
    public function behaviors(): array
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'only' => ['convert', 'approval', 'cancel', 'index'],
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['convert', 'approval', 'cancel', 'index'],
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    /**
     * @return string
     */
    public function actionIndex(): string
    {
        $prize = Yii::$app->prize->getRandom();

        if(is_null($prize)) {
            return $this->render('finish');
        }

        /**
         * @var User $user
         */
        $user = Yii::$app->user->identity;

        return $this->render('index', [
            'prize' => $prize,
            'user_prize' => Yii::$app->prize->saveResult($user, $prize)
        ]);
    }

    /**
     * @param int $user_prize_id
     * @param string $to
     * @return Response
     */
    public function actionConvert(int $user_prize_id, string $to)
    {
        $userPrize = $this->findUserPrize($user_prize_id);
        if(!is_null($userPrize) && $userPrize->prize->type->type === PrizeType::TYPE_REAL) {
            Yii::$app->prize->approval($userPrize);

            if($to === 'card') {
                Yii::$app->bank->sendMoneyToCard($userPrize->user, $userPrize->quantity);
            }elseif ($to === 'virtual') {
                Yii::$app->player->convertRealToVirtual($userPrize->user, $userPrize);
            }
        }

        return $this->goHome();
    }

    /**
     * @param int $user_prize_id
     * @return Response
     */
    public function actionApproval(int $user_prize_id): Response
    {
        $userPrize = $this->findUserPrize($user_prize_id);
        if(!is_null($userPrize)) {
            Yii::$app->prize->approval($userPrize);
        }

        return $this->goHome();
    }

    /**
     * @param $user_prize_id int
     * @return Response
     */
    public function actionCancel(int $user_prize_id): Response
    {
        $userPrize = $this->findUserPrize($user_prize_id);
        if(!is_null($userPrize)) {
            Yii::$app->prize->cancel($userPrize);
        }

        return $this->goHome();
    }

    /**
     * @param int $user_prize_id
     * @return UserPrize|null
     */
    private function findUserPrize(int $user_prize_id): ?UserPrize
    {
        return UserPrize::findOne([
            'id' => $user_prize_id,
            'user_id' => Yii::$app->user->getId(),
            'status' => UserPrize::RESERVED_STATUS
        ]);
    }
}
