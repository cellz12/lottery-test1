<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%prize_type}}`.
 */
class m210109_180730_create_prize_type_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%prize_type}}', [
            'id' => $this->primaryKey(),
            'title' => $this->string(50)->notNull(),
            'type' => $this->string(10)->notNull(),
            'coefficient' => $this->integer()->null(),
            'interval' => $this->integer()->unsigned()->notNull()->defaultValue(1),
            'created_at' => $this->timestamp()->notNull()->defaultExpression('CURRENT_TIMESTAMP'),
            'updated_at' => $this->timestamp()->defaultValue(null)->append('ON UPDATE CURRENT_TIMESTAMP'),
        ]);

        $this->createIndex(
            'idx-prize_type-type',
            'prize_type',
            'type'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%prize_type}}');
    }
}
