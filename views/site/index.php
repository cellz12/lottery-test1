<?php
/* @var $this yii\web\View */
use yii\helpers\Html;

$this->title = 'Let`s play';
?>
<div class="site-index">
    <div class="row">
        <div class="col-lg-offset-3 col-sm-6">
            <div class="panel panel-default">
                <div class="panel-heading"><?= Html::encode($this->title) ?></div>
                <div class="panel-body">
                    <?=Html::a('Get prize', '/prize', ['class' => 'btn btn-success']);?>
                </div>
            </div>
        </div>
    </div>
</div>
