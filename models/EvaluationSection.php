<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "evaluation_section".
 *
 * @property int $id
 * @property int $evaluation_id
 * @property int $section_id
 * @property string $comment
 *
 * @property EvaluationItem[] $evaluationItems
 * @property Evaluation $evaluation
 * @property Section $section
 */
class EvaluationSection extends \yii\db\ActiveRecord
{
   
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'evaluation_section';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['evaluation_id', 'section_id'], 'integer'],
            [['comment'], 'required','skipOnEmpty' => false],
            [['comment'], 'string', 'max' => 100],
            [['evaluation_id'], 'exist', 'skipOnError' => true, 'targetClass' => Evaluation::className(), 'targetAttribute' => ['evaluation_id' => 'id']],
            [['section_id'], 'exist', 'skipOnError' => true, 'targetClass' => Section::className(), 'targetAttribute' => ['section_id' => 'id']],
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
            'section_id' => 'Section ID',
            'comment' => 'Comment',
        ];
    }

    public function attributes()
    {
        return array_merge(parent::attributes(), ['id', 'evaluation_id', 'section_id', 'comment']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEvaluationItems()
    {
        return $this->hasMany(EvaluationItem::className(), ['evaluation_section_id' => 'id']);
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
    public function getSection()
    {
        return $this->hasOne(Section::className(), ['id' => 'section_id']);
    }
}
