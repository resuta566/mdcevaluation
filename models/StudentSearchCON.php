<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Student;

class StudentSearchCON extends Student
{
    public $teacherSearch;
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id','gender', 'user_id'], 'integer'],
            [['lname', 'fname', 'mname','teacherSearch'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = Teacher::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        $query->joinWith(['user'],true, 'LEFT JOIN');

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        // $query->andFilterWhere([
        //     'id' => $this->id,
        //     'gender' => $this->gender,
        //     'user_id' => $this->user_id,
        // ]);

        $query->orFilterWhere(['like', 'teacher.id', $this->teacherSearch])
            ->orFilterWhere(['like', 'fname', $this->teacherSearch])
            ->orFilterWhere(['like', 'lname', $this->teacherSearch])
            ->orFilterWhere(['like', 'mname', $this->teacherSearch])
            ->andWhere(['user.role' => 20])
            ->andWhere(['user.department' => 5]);

        return $dataProvider;
    }
}
