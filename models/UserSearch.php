<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\User;

/**
 * UserSearch represents the model behind the search form of `app\models\User`.
 */
class UserSearch extends User
{
    public $userSearch;
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'role', 'status', 'department'], 'integer'],
            [['username','userSearch', 'password','roleName','statusName', 'authkey'], 'safe'],
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
        $query = User::find();

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
        //     'role' => $this->role,
        //     'status' => $this->status,
        //     'department' => $this->department,
        // ]);

        $query->orFilterWhere(['like', 'username', $this->userSearch])
            // ->orFilterWhere(['like', 'password', $this->userSearch])
            // ->orFilterWhere(['like', 'authkey', $this->userSearch])
            ->orFilterWhere(['like', 'role', $this->userSearch])
            ->orFilterWhere(['like', 'status', $this->userSearch]);

        return $dataProvider;
    }
}
