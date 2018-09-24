<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "classes".
 *
 * @property int $id
 * @property string $name
 * @property string $description
 * @property string $day
 * @property string $time
 * @property int $teacher_id
 * @property int $eval_status
 *
 * @property Teacher $teacher
 * @property Evaluation[] $evaluations
 * @property StudentClass[] $studentClasses
 * @property Student[] $students
 */
class Classes extends \yii\db\ActiveRecord
{

    public static function getEstatus() {
        return $estatus = [
            1 => 'Active',
            0 => 'Inactive',
        ];
    }

    public function getEstatusName() {
        return static::getEstatus()[$this->estatus];
    }
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'classes';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'description', 'day', 'time', 'teacher_id'], 'required'],
            [['description'], 'string'],
            [['teacher_id', 'estatus'], 'integer'],
            [['name', 'day', 'time'], 'string', 'max' => 100],
            [['teacher_id'], 'exist', 'skipOnError' => true, 'targetClass' => Teacher::className(), 'targetAttribute' => ['teacher_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'description' => 'Description',
            'day' => 'Day',
            'time' => 'Time',
            'teacher_id' => 'Teacher ID',
            'estatusName' => 'Evaluation Status',
            'estatus' => 'Evaluation Status',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTeacher()
    {
        return $this->hasOne(Teacher::className(), ['id' => 'teacher_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEvaluations()
    {
        return $this->hasMany(Evaluation::className(), ['class_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStudentClasses()
    {
        return $this->hasMany(StudentClass::className(), ['class_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStudents()
    {
        return $this->hasMany(Student::className(), ['id' => 'student_id'])->viaTable('student_class', ['class_id' => 'id']);
    }
}
