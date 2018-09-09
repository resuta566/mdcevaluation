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
 * @property int $user_id
 *
 * @property Classes $classes
 * @property User $user
 */
class Teacher extends \yii\db\ActiveRecord
{
    const GENDER_MALE = 1;
    const GENDER_FEMALE =2;


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
        return 'teacher';
    }
    public function getId()
    {
        return $this->id;
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

        ];
    }

    public function getFullName()
    {
        return $this->lname . ", " . $this->fname;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getClasses()
    {
        return $this->hasOne(Classes::className(), ['teacher_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
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
    
}
