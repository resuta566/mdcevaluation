<?php

use yii\db\Migration;

/**
 * Handles the creation of table `classes`.
 */
class m180909_030657_create_classes_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('classes', [
            'id' => $this->primaryKey(),
            'name' => $this->string(100)->notNull(),
            'description' => $this->text()->notNull(),
            'day' => $this->string(100)->notNull(),
            'time' => $this->string(100)->notNull(),
            'teacher_id' => $this->integer(),
            'estatus' => $this->integer(1)
        ]);
        $this->createIndex(
            'idx-classes-teacher_id',
            'classes','teacher_id'
        );

        $this->addForeignKey(
            'fk-classes-teacher',
            'classes','teacher_id',
            'teacher', 'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk-classes-teacher', 'classes');
        $this->dropIndex('idx-classes-teacher_id','classes');
        $this->dropTable('classes');
    }
}
