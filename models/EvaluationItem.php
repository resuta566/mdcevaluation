<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "evaluation_item".
 *
 * @property int $id
 * @property int $evaluation_id
 * @property int $item_id
 * @property int $score
 *
 * @property Evaluation $evaluation
 * @property Item $item
 */
class EvaluationItem extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'evaluation_item';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['evaluation_id', 'item_id', 'score'], 'required'],
            [['evaluation_id', 'item_id', 'score'], 'integer'],
            [['evaluation_id'], 'exist', 'skipOnError' => true, 'targetClass' => Evaluation::className(), 'targetAttribute' => ['evaluation_id' => 'id']],
            [['item_id'], 'exist', 'skipOnError' => true, 'targetClass' => Item::className(), 'targetAttribute' => ['item_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'evaluation_id' => 'Evaluation ID',
            'item_id' => 'Item ID',
            'score' => 'Score',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEvaluation()
    {
        return $this->hasOne(Evaluation::className(), ['id' => 'evaluation_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getItem()
    {
        return $this->hasOne(Item::className(), ['id' => 'item_id']);
    }
}
