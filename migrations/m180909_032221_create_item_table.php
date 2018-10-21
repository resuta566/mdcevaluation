<?php

use yii\db\Migration;

/**
 * Handles the creation of table `item`.
 */
class m180909_032221_create_item_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('item', [
            'id' => $this->primaryKey(),
            'section_id' => $this->integer(),
            'statement' => $this->text()->notNull()
        ]);
        $this->createIndex(
            'idx-item-section_id',
            'item','section_id'
        );

        $this->addForeignKey(
            'fk-item-section',
            'item','section_id',
            'section', 'id',
            'SET NULL'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk-item-section', 'item');
        $this->dropIndex('idx-item-section_id','item');
        $this->dropTable('item');
    }
}
