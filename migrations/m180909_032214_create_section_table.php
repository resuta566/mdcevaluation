<?php

use yii\db\Migration;

/**
 * Handles the creation of table `section`.
 */
class m180909_032214_create_section_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('section', [
            'id' => $this->primaryKey(),
            'instrument_id' => $this->integer(),
            'name' => $this->string(100)->notNull(),
            'description' => $this->text()->notNull()
        ]);
        $this->createIndex(
            'idx-section-instrument_id',
            'section','instrument_id'
        );

        $this->addForeignKey(
            'fk-section-instrument',
            'section','instrument_id',
            'instrument', 'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk-section-instrument', 'section');
        $this->dropIndex('idx-section-instrument_id','section');
        $this->dropTable('section');
    }
}
