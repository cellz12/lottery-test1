<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%prizes}}`.
 */
class m210109_180747_create_prizes_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%prizes}}', [
            'id' => $this->primaryKey(),
            'type_id' => $this->integer(),
            'title' => $this->string()->notNull(),
            'description' => $this->string()->null(),
            'available_count' => $this->integer()->defaultValue(0),
            'data' => $this->text(),
            'created_at' => $this->timestamp()->notNull()->defaultExpression('CURRENT_TIMESTAMP'),
            'updated_at' => $this->timestamp()->defaultValue(null)->append('ON UPDATE CURRENT_TIMESTAMP'),
        ]);

        $this->createIndex(
            'idx-prizes-type_id',
            'prizes',
            'type_id'
        );

        $this->addForeignKey(
            'fk-prizes-type_id',
            'prizes',
            'type_id',
            'prize_type',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%prizes}}');
    }
}
