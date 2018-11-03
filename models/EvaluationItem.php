<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "evaluation_item".
 *
 * @property int $id
 * @property int $evaluation_section_id
 * @property int $item_id
 * @property int $score
 *
 * @property EvaluationSection $evaluationSection
 * @property Item $item
 */
class EvaluationItem extends \yii\db\ActiveRecord
{
    const SCENARIO_UPDATE = 'update';
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
            [['score'], 'required','skipOnEmpty' => false],
            [['evaluation_section_id', 'item_id', 'score'], 'integer'],
            [['evaluation_section_id'], 'exist', 'skipOnError' => true, 'targetClass' => EvaluationSection::className(), 'targetAttribute' => ['evaluation_section_id' => 'id']],
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
            'evaluation_section_id' => 'Evaluation Section ID',
            'item_id' => 'Item ID',
            'score' => 'Score',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEvaluationSection()
    {
        return $this->hasOne(EvaluationSection::className(), ['id' => 'evaluation_section_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getItem()
    {
        return $this->hasOne(Item::className(), ['id' => 'item_id']);
    }
}
