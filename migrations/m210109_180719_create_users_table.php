<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%users}}`.
 */
class m210109_180719_create_users_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%users}}', [
            'id' => $this->primaryKey(),
            'username' => $this->string(10)->notNull()->unique(),
            'balance' => $this->float(4)->defaultValue(0),
            'virtual_balance' => $this->float(4)->defaultValue(0),
            'email' => $this->string()->unique()->notNull(),
            'card_number' => $this->bigInteger()->unsigned()->null(),
            'password' => $this->string(60)->notNull(),
            'accessToken' => $this->string()->unique()->null(),
            'created_at' => $this->timestamp()->notNull()->defaultExpression('CURRENT_TIMESTAMP'),
            'updated_at' => $this->timestamp()->defaultValue(null)->append('ON UPDATE CURRENT_TIMESTAMP'),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%users}}');
    }
}
