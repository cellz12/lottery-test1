<?php


namespace app\commands;


use Yii;
use yii\db\Exception;
use yii\helpers\Console;
use yii\console\Controller;
use app\models\{PrizeType, Prize};

/**
 * Class SeedController
*/
class SeedController extends Controller
{
    /**
     * @throws Exception
     */
    public function actionIndex()
    {
        $prize_types = [
            [
                'title' => 'Реальные деньги',
                'type' => PrizeType::TYPE_REAL,
                'coefficient' => 300,
                'interval' => 30
            ], [
                'title' => 'Вирутальные деньги',
                'type' => PrizeType::TYPE_VIRTUAL,
                'coefficient' => 0,
                'interval' => 200
            ], [
                'title' => 'Физический предмет',
                'type' => PrizeType::TYPE_ITEM,
                'coefficient' => 0,
                'interval' => 1
            ]
        ];

        Yii::$app->db->createCommand()->batchInsert(
            PrizeType::tableName(),
            ['title', 'type', 'coefficient', 'interval'],
            $prize_types
        )->execute();

        $this->seedStdout(PrizeType::tableName());

        $prizes = [
            [
                'type_id' => 1,
                'title' => 'Реальные деньги',
                'description' => 'Реальный деньги',
                'available_count' => 1000,
                'data' => []
            ], [
                'type_id' => 2,
                'title' => 'Вирутальные деньги',
                'description' => 'Виртуальные деньги',
                'available_count' => -1,
                'data' => []
            ], [
                'type_id' => 3,
                'title' => 'Кофеварка',
                'description' => 'Delonghi EC9335.M La Specialista',
                'available_count' => 6,
                'data' => [
                    'photo' => 'https://domkofe.com.ua/wp-content/uploads/2019/09/DeLonghi-La-Specialista-Main-New.jpg',
                    'weight' => 400
                ]
            ], [
                'type_id' => 3,
                'title' => 'Телевизор',
                'description' => 'Sony',
                'available_count' => 2,
                'data' => [
                    'photo' => 'https://i1.foxtrot.com.ua/product/MediumImages/6295797_0.jpg',
                    'weight' => 300
                ]
            ]
        ];

        $prizes = array_map(function($prize){
            $prize['data'] = json_encode($prize['data'], JSON_UNESCAPED_UNICODE);
            return $prize;
        }, $prizes);

        Yii::$app->db->createCommand()->batchInsert(
            Prize::tableName(),
            ['type_id', 'title', 'description', 'available_count', 'data'],
            $prizes
        )->execute();

        $this->seedStdout(Prize::tableName());
    }

    private function seedStdout(string $table_name): void
    {
        $this->stdout("`{$table_name}`", Console::FG_GREEN);
        $this->stdout(' - was inserted' . PHP_EOL);
    }
}