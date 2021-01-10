<?php

namespace tests\unit;

use Yii;
use Codeception\Test\Unit;

class PlayerTest extends Unit
{
    public function testCalculateVirtualBalance()
    {
        $this->assertEquals(200, Yii::$app->player->calculateVirtualBalance(10, 20));
        $this->assertEquals(10, Yii::$app->player->calculateVirtualBalance(10, -3));
        $this->assertEquals(10, Yii::$app->player->calculateVirtualBalance(-300, 10));
    }
}