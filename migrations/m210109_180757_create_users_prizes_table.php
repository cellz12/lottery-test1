<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%users_prizes}}`.
 */
class m210109_180757_create_users_prizes_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%users_prizes}}', [
            'id' => $this->primaryKey(),
            'prize_id' => $this->integer(),
            'user_id' => $this->integer(),
            'quantity' => $this->integer(),
            'status' => $this->string(10)->null(),
            'created_at' => $this->timestamp()->notNull()->defaultExpression('CURRENT_TIMESTAMP'),
        ]);

        $this->createIndex(
            'idx-users_prizes-prize_id',
            'users_prizes',
            'prize_id'
        );

        $this->addForeignKey(
            'fk-users_prizes-prize_id',
            'users_prizes',
            'prize_id',
            'prizes',
            'id',
            'CASCADE'
        );

        $this->createIndex(
            'idx-users_prizes-user_id',
            'users_prizes',
            'user_id'
        );

        $this->addForeignKey(
            'fk-users_prizes-user_id',
            'users_prizes',
            'user_id',
            'users',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%users_prizes}}');
    }
}
