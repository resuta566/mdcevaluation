<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "evaluation".
 *
 * @property int $id
 * @property int $eval_by
 * @property int $eval_for
 * @property int $instrument_id
 * @property int $class_id
 * @property string $date
 *
 * @property User $evalBy
 * @property User $evalFor
 * @property Instrument $instrument
 * @property Classes $class
 * @property EvaluationItem[] $evaluationItems
 */
class Evaluation extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'evaluation';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['eval_by', 'eval_for', 'instrument_id', 'class_id'], 'required'],
            [['eval_by', 'eval_for', 'instrument_id', 'class_id'], 'integer'],
            [['date'], 'safe'],
            [['eval_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['eval_by' => 'id']],
            [['eval_for'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['eval_for' => 'id']],
            [['instrument_id'], 'exist', 'skipOnError' => true, 'targetClass' => Instrument::className(), 'targetAttribute' => ['instrument_id' => 'id']],
            [['class_id'], 'exist', 'skipOnError' => true, 'targetClass' => Classes::className(), 'targetAttribute' => ['class_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'eval_by' => 'Eval By',
            'eval_for' => 'Eval For',
            'instrument_id' => 'Instrument ID',
            'class_id' => 'Class ID',
            'date' => 'Date',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEvalBy()
    {
        return $this->hasOne(User::className(), ['id' => 'eval_by']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEvalFor()
    {
        return $this->hasOne(User::className(), ['id' => 'eval_for']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getInstrument()
    {
        return $this->hasOne(Instrument::className(), ['id' => 'instrument_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getClass()
    {
        return $this->hasOne(Classes::className(), ['id' => 'class_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEvaluationItems()
    {
        return $this->hasMany(EvaluationItem::className(), ['evaluation_id' => 'id']);
    }
}
