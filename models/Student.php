<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "student".
 *
 * @property int $id
 * @property string $lname
 * @property string $fname
 * @property string $mname
 * @property int $gender
 * @property int $user_id
 *
 * @property User $user
 * @property StudentClass[] $studentClasses
 * @property Classes[] $classes
 */
class Student extends \yii\db\ActiveRecord
{
    const GENDER_MALE = 1;
    const GENDER_FEMALE = 2;


    public static function getGender() {
        return $gender = [
            1 => 'MALE',
            2 => 'FEMALE',
        ];
    }

    public function getGenderName() {
        return static::getGender()[$this->gender];
    }
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'student';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['lname', 'fname', 'mname', 'gender'], 'required'],
            [['gender', 'user_id'], 'integer'],
            [['lname', 'fname', 'mname'], 'string', 'max' => 50],
            [['user_id'], 'unique'],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'lname' => 'Last Name',
            'fname' => 'First Name',
            'mname' => 'Middle Name',
            'genderName' => 'Gender',
            'gender' => 'Gender',
            'user_id' => 'User ID',
            'evalDone' => 'Evaluation Status'
        ];
    }

    public function getFullName()
    {
        return $this->lname . ", " . $this->fname;
    }
    public function getStudentUser()
    {
        $we = Yii::$app->formatter->asText($this->id);
        return $we;
    }
    public function getStudentPass()
    {
        return $this->id . "" . $this->lname;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStudentClasses()
    {
        return $this->hasMany(StudentClass::className(), ['student_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getClasses()
    {
        return $this->hasMany(Classes::className(), ['id' => 'class_id'])->viaTable('student_class', ['student_id' => 'id']);
    }

    public function getEvalDone()
    {
        if(!Evaluation::find()->andWhere(['eval_by' => $this->user->id])->all()){
            return 'NO EVALUATION';
        }else{
            if(Evaluation::find()->where(['status' => 1])->andWhere(['eval_by' => $this->user->id])->all() ==  Evaluation::find()->where(['eval_by' => $this->user->id])->all()){
                return 'DONE';
            }else{
                return 'NOT YET';
            }
        }
    }
}
