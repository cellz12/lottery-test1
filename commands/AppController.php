<?php

namespace app\commands;

use Yii;
use yii\base\InvalidRouteException;
use yii\console\{Controller, Exception};

/**
 * Class AppController
*/
class AppController extends Controller
{
    /**
     * @throws InvalidRouteException
     * @throws Exception
     * @return void
     */
    public function actionSetup(): void
    {
        Yii::$app->runAction('migrate/up', ['interactive' => false]);
        Yii::$app->runAction('seed/index');
    }
}