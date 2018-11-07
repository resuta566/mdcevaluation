<?php

use yii\db\Migration;

/**
 * Handles the creation of table `teacher`.
 */
class m180909_013720_create_teacher_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('teacher', [
            'id' => $this->primaryKey(),
            'lname' => $this->string(50)->notNull(),
            'fname' => $this->string(50)->notNull(),
            'mname' => $this->string(50)->notNull(),
            'gender' => $this->integer(1)->notNull(),
            'type' => $this->integer(1)->notNull(),
            'user_id' => $this->integer(11),

        ]);
        $this->createIndex(
            'idx-teacher-user_id',
            'teacher','user_id'
        );

        $this->addForeignKey(
            'fk-teacher-user',
            'teacher','user_id',
            'user', 'id',
            'SET NULL'
        );

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk-teacher-user', 'teacher');
        $this->dropIndex('idx-teacher-user_id','teacher');
        $this->dropTable('teacher');
    }
}
