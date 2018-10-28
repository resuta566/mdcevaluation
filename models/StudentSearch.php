<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Student;

/**
 * StudentSearch represents the model behind the search form of `app\models\Student`.
 */
class StudentSearch extends Student
{
    public $studentSearch;
    public $studentRole;
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'gender', 'user_id'], 'integer'],
            [['lname', 'fname', 'mname','studentSearch','studentRole'], 'safe'],
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
        $query = Student::find();

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

        $query->orFilterWhere(['like', 'student.id', $this->studentSearch])
            ->orFilterWhere(['like', 'lname', $this->studentSearch])
            ->orFilterWhere(['like', 'fname', $this->studentSearch])
            ->orFilterWhere(['like', 'mname', $this->studentSearch])
            ->andFilterWhere(['user.department' => $this->studentRole])
            ->andWhere(['not', ['user_id' => null]]);

        return $dataProvider;
    }
}
