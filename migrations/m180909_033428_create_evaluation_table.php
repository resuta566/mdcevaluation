<?php

use yii\db\Migration;

/**
 * Handles the creation of table `evaluation`.
 */
class m180909_033428_create_evaluation_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('evaluation', [
            'id' => $this->primaryKey(),
            'eval_by' => $this->integer(),
            'eval_for' => $this->integer(),
            'instrument_id' => $this->integer(),
            'class_id' => $this->integer(),
            'date' => 'timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP'
        ]);
        $this->createIndex(
            'idx-evaluation-eval_by',
            'evaluation','eval_by'
        );
        $this->createIndex(
            'idx-evaluation-eval_for',
            'evaluation','eval_for'
        );
        $this->addForeignKey(
            'fk-evaluation-eval_by',
            'evaluation','eval_by',
            'user', 'id',
            'SET NULL'
        );
        $this->addForeignKey(
            'fk-evaluation-eval_for',
            'evaluation','eval_for',
            'user', 'id',
            'SET NULL'
        );
        $this->createIndex(
            'idx-evaluation-instrument_id',
            'evaluation','instrument_id'
        );
        $this->addForeignKey(
            'fk-evaluation-instrument',
            'evaluation','instrument_id',
            'instrument', 'id',
            'SET NULL'
        );
        $this->createIndex(
            'idx-evaluation-class_id',
            'evaluation','class_id'
        );
        $this->addForeignKey(
            'fk-evaluation-classes',
            'evaluation','class_id',
            'classes', 'id',
            'SET NULL'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk-evaluation-eval_by', 'evaluation');
        $this->dropIndex('idx-evaluation-eval_by','evaluation');
        $this->dropForeignKey('fk-evaluation-eval_for', 'evaluation');
        $this->dropIndex('idx-evaluation-eval_for','evaluation');
        $this->dropForeignKey('fk-evaluation-instrument', 'evaluation');
        $this->dropIndex('idx-evaluation-instrument_id','evaluation');
        $this->dropForeignKey('fk-evaluation-classes', 'evaluation');
        $this->dropIndex('idx-evaluation-class_id','evaluation');
        $this->dropTable('evaluation');
    }
}
