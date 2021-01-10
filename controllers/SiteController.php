<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\AccessControl;

/**
 * Class SiteController
*/
class SiteController extends Controller
{
    /**
     * @return array
     */
    public function behaviors(): array
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['index'],
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
        return $this->render('index');
    }

    /**
     * @return string
    */
    public function actionError(): string
    {
        return $this->render('error', [
            'message' => Yii::$app->errorHandler->exception->getMessage(),
            'code' => Yii::$app->errorHandler->exception->getCode()
        ]);
    }
}
