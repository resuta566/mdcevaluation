<?php

use yii\db\Migration;

/**
 * Handles the creation of table `evaluation_item`.
 */
class m180909_042229_create_evaluation_item_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('evaluation_item', [
            'id' => $this->primaryKey(),
            'evaluation_id' => $this->integer(),
            'item_id' => $this->integer(),
            'score' => $this->integer(1),
        ]);
        $this->createIndex(
            'idx-evaluation_item-evaluation_id',
            'evaluation_item','evaluation_id'
        );
        $this->addForeignKey(
            'fk-evaluation_item-evaluation',
            'evaluation_item','evaluation_id',
            'evaluation', 'id',
            'CASCADE'
        );
        $this->createIndex(
            'idx-evaluation_item-item_id',
            'evaluation_item','item_id'
        );
        $this->addForeignKey(
            'fk-evaluation_item-item',
            'evaluation_item','item_id',
            'item', 'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk-evaluation_item-evaluation', 'evaluation_item');
        $this->dropIndex('idx-evaluation_item-evaluation_id','evaluation_item');
        $this->dropForeignKey('fk-evaluation_item-item', 'evaluation_item');
        $this->dropIndex('idx-evaluation_item-item_id','evaluation_item');
        $this->dropTable('evaluation_item');
    }
}
