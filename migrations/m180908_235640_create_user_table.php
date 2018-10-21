<?php

use yii\db\Migration;

/**
 * Handles the creation of table `user`.
 */
class m180908_235640_create_user_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('user', [
            'id' => $this->primaryKey(),
            'username' => $this->string(10)->notNull(),
            'password' => $this->string(225)->notNull(),
            'authkey' => $this->string(225),
            'role' => $this->integer(1)->notNull(),
            'status' => $this->integer(1)->notNull(),
            'department' => $this->integer(1)->notNull(),

        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('user');
    }
}
