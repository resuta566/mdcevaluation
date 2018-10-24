<?php

use yii\db\Migration;

/**
 * Handles the creation of table `student_class`.
 */
class m180909_031749_create_student_class_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('student_class', [
            'id' => $this->primaryKey(),
            'student_id' => $this->integer(),
            'class_id' => $this->integer(),
            'status' => $this->integer(1)->notNull()->defaultValue(1),
        ]);
        $this->createIndex(
            'idx-student_class-student_id',
            'student_class','student_id'
        );

        $this->addForeignKey(
            'fk-student_class-student',
            'student_class','student_id',
            'student', 'id',
            'SET NULL'
        );

        $this->createIndex(
            'idx-student_class-class_id',
            'student_class','class_id'
        );

        $this->addForeignKey(
            'fk-student_class-classes',
            'student_class','class_id',
            'classes', 'id',
            'SET NULL'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk-student_class-student', 'student_class');
        $this->dropIndex('idx-student_class-student_id','student_class');
        $this->dropForeignKey('fk-student_class-classes', 'student_class');
        $this->dropIndex('idx-student_class-class_id','student_class');
        $this->dropTable('student_class');
    }
}
