<?php

use yii\db\Migration;

/**
 * Handles the creation of table `head`.
 */
class m180909_013742_create_head_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('head', [
            'id' => $this->primaryKey(),
            'lname' => $this->string(50)->notNull(),
            'fname' => $this->string(50)->notNull(),
            'mname' => $this->string(50)->notNull(),
            'gender' => $this->integer(1)->notNull(),
            'user_id' => $this->integer(11),

        ]);
        $this->createIndex(
            'idx-head-user_id',
            'head','user_id'
        );

        $this->addForeignKey(
            'fk-head-user',
            'head','user_id',
            'user', 'id',
            'SET NULL'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk-head-user', 'head');
        $this->dropIndex('idx-head-user_id','head');
        $this->dropTable('head');
    }
}
