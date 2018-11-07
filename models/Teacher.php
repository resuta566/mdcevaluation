<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "teacher".
 *
 * @property int $id
 * @property string $lname
 * @property string $fname
 * @property string $mname
 * @property int $gender
 * @property int $type 1 = Full Time , 0 = Part Time
 * @property int $user_id
 *
 * @property Classes[] $classes
 * @property User $user
 */
class Teacher extends \yii\db\ActiveRecord
{

    const GENDER_MALE = 1;
    const GENDER_FEMALE =2;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'teacher';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['lname', 'fname', 'mname', 'gender', 'type'], 'required'],
            [['gender', 'type', 'user_id'], 'integer'],
            [['lname', 'fname', 'mname'], 'string', 'max' => 50],
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
            'gender' => 'Gender',
            'type' => 'Type',
            'user_id' => 'User ID',
            'evalDone' => 'Evaluation Status',
            'typeName' => 'Type'
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getClasses()
    {
        return $this->hasMany(Classes::className(), ['teacher_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    public static function getGender() {
        return $gender = [
            1 => 'MALE',
            2 => 'FEMALE',
        ];
    }

    public function getGenderName() {
        return static::getGender()[$this->gender];
    }

    public static function getType() {
        return $type = [
            1 => 'FULL TIME',
            0 => 'PART TIME',
        ];
    }

    public function getTypeName() {
        return static::getType()[$this->type];
    }

    public function getId()
    {
        return $this->id;
    }

    public function getFullName()
    {
        return $this->lname . ", " . $this->fname;
    }

    public function getTeacherUser()
    {
        $we = Yii::$app->formatter->asText($this->id);
        return $we;
    }
    public function getTeacherPass()
    {
        return $this->id . "" . $this->lname;
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
