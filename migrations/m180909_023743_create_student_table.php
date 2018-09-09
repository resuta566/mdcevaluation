<?php

use yii\db\Migration;

/**
 * Handles the creation of table `student`.
 */
class m180909_023743_create_student_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('student', [
            'id' => $this->primaryKey(),
            'lname' => $this->string(50)->notNull(),
            'fname' => $this->string(50)->notNull(),
            'mname' => $this->string(50)->notNull(),
            'gender' => $this->integer(1)->notNull(),
            'user_id' => $this->integer(11),

        ]);
        $this->createIndex(
            'idx-student-user_id',
            'student','user_id'
        );

        $this->addForeignKey(
            'fk-student-user',
            'student','user_id',
            'user', 'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk-student-user', 'student');
        $this->dropIndex('idx-student-user_id','student');
        $this->dropTable('student');
    }
}
