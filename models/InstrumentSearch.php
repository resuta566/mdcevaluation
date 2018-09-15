<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Instrument;

/**
 * InstrumentSearch represents the model behind the search form of `app\models\Instrument`.
 */
class InstrumentSearch extends Instrument
{
    public $instrumentSearch;
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'description','id'], 'safe'],
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
        $query = Instrument::find();

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
        // $query->andFilterWhere([
        //     'id' => $this->id,
        // ]);

        $query->orFilterWhere(['like', 'id', $this->instrumentSearch])
            ->orFilterWhere(['like', 'name', $this->instrumentSearch])
            ->orFilterWhere(['like', 'description', $this->instrumentSearch]);

        return $dataProvider;
    }
}
