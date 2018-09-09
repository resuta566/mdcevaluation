<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Classes;

/**
 * ClassesSearch represents the model behind the search form of `app\models\Classes`.
 */
class ClassesSearchT extends Classes
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', ], 'integer'],
            [['name', 'description', 'day','time','estatus'], 'safe'],
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
        $query = Classes::find()->where(['teacher_id'=> $params]);

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        // $query->where([
        //     'teacher_id' => $params,
        // ]);
        $query->andFilterWhere([
            'teacher_id' => $this->teacher_id,
            'estatus' => $this->estatus,
            'estatus' => 0,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'description', $this->description])
            ->andFilterWhere(['like', 'day', $this->day])
            // ->andFilterWhere(['like', 'estatusName', $this->estatus])
            ->andFilterWhere(['like', 'time', $this->time]);

        return $dataProvider;
    }
}
