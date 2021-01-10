<?php
/* @var $this yii\web\View */
/* @var $prize app\models\Prize */
/* @var $user_prize app\models\UserPrize */

use app\models\PrizeType;
use yii\helpers\Html;

$this->title = 'Great!!!';

?>
<div class="prize-index">
    <div class="row">
        <div class="col-lg-offset-3 col-sm-6">
            <div class="panel panel-default">
                <div class="panel-heading"><?= Html::encode($this->title) ?></div>
                <div class="panel-body">
                    <h3>Your prize: <?=$prize->title?> x<?= $prize->quantity?></h3>
                </div>
                <div class="panel-footer">
                    <?=Html::a('Cancel', ['/prize/cancel', 'user_prize_id' => $user_prize->id], ['class' => 'btn btn-warning']);?>
                    <?=Html::a('Get next', ['/prize/approval', 'user_prize_id' => $user_prize->id], ['class' => 'btn btn-success']);?>
                    <?php if($prize->type->type === PrizeType::TYPE_REAL){?>
                        <?=Html::a(
                                'Convert to virtual',
                                ['/prize/convert', 'user_prize_id' => $user_prize->id, 'to' => 'virtual'], ['class' => 'btn btn-default']
                        );?>
                        <?=Html::a(
                            'Send to card',
                            ['/prize/convert', 'user_prize_id' => $user_prize->id, 'to' => 'card'], ['class' => 'btn btn-default']
                        );?>
                    <?php }?>
                </div>
            </div>
        </div>
    </div>
</div>
