<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "student_class".
 *
 * @property int $id
 * @property int $student_id
 * @property int $class_id
 * @property int $status
 *
 * @property Student $student
 * @property Classes $class
 */
class StudentClass extends \yii\db\ActiveRecord
{
    public static function getStatus() {
        return $status = [
            1 => 'Active',
            0 => 'Drop',
        ];
    }

    public function getStatusName() {
        return static::getStatus()[$this->status];
    }
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'student_class';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['student_id', 'class_id', 'status'], 'required'],
            [['student_id', 'class_id', 'status'], 'integer'],
            [['student_id', 'class_id'], 'unique', 'targetAttribute' => ['student_id', 'class_id']],
            [['student_id'], 'exist', 'skipOnError' => true, 'targetClass' => Student::className(), 'targetAttribute' => ['student_id' => 'id']],
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
            'student_id' => 'Student ID',
            'class_id' => 'Class ID',
            'status' => 'Status',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStudent()
    {
        return $this->hasOne(Student::className(), ['id' => 'student_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getClass()
    {
        return $this->hasOne(Classes::className(), ['id' => 'class_id']);
    }
}
