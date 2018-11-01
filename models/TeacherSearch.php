<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Teacher;

/**
 * TeacherSearch represents the model behind the search form of `app\models\Teacher`.
 */
class TeacherSearch extends Teacher
{
    public $teacherSearch;
    public $teacherRole;
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id','gender', 'user_id'], 'integer'],
            [['lname', 'fname', 'mname','teacherSearch','teacherRole'], 'safe'],
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
        
        $query->joinWith('user');

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
            ->andFilterWhere(['user.department' => $this->teacherRole])
            ->andWhere(['not', ['user_id' => null]]);

        return $dataProvider;
    }
}
