<?php

use yii\db\Migration;

/**
 * Handles the creation of table `evaluation_section`.
 */
class m181020_111553_create_evaluation_section_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('evaluation_section', [
            'id' => $this->primaryKey(),
            'evaluation_id' => $this->integer(),
            'section_id' => $this->integer(),
            'comment' => $this->string(100),
        ]);
        $this->createIndex(
            'idx-evaluation_section-evaluation_id',
            'evaluation_section','evaluation_id'
        );
        $this->addForeignKey(
            'fk-evaluation_section-evaluation',
            'evaluation_section','evaluation_id',
            'evaluation', 'id',
            'SET NULL'
        );
        $this->createIndex(
            'idx-evaluation_section-section_id',
            'evaluation_section','section_id'
        );
        $this->addForeignKey(
            'fk-evaluation_section-section',
            'evaluation_section','section_id',
            'section', 'id',
            'SET NULL'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk-evaluation_section-evaluation', 'evaluation_section');
        $this->dropIndex('idx-evaluation_section-evaluation_id','evaluation_section');
        $this->dropForeignKey('fk-evaluation_section-section_id', 'evaluation_section');
        $this->dropIndex('idx-evaluation_section-section','evaluation_section');
        $this->dropTable('evaluation_section');
    }
}