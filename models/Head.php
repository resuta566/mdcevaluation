<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "head".
 *
 * @property int $id
 * @property string $lname
 * @property string $fname
 * @property string $mname
 * @property int $gender
 * @property int $user_id
 *
 * @property User $user
 */
class Head extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'head';
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
            'lname' => 'Lname',
            'fname' => 'Fname',
            'mname' => 'Mname',
            'gender' => 'Gender',
            'user_id' => 'User ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }
}
