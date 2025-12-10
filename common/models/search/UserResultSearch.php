<?php

namespace common\models\search;

use yii\data\ActiveDataProvider;
use common\models\User;

class UserResultSearch extends User
{
    public $total_score;
    public $start_time;

    public function rules()
    {
        return [
            [['name'], 'safe'],
            [['id', 'total_score'], 'integer'],
            [['start_time'], 'safe'],
        ];
    }

    public function search($params)
    {
        $query = User::find()
            ->joinWith('userTests')
            ->joinWith('resultFile')
            ->groupBy('user.id')
            ->select([
                'user.*',
                'MIN(user_test.start_time) AS start_time',
                'MAX(user_test.end_time) AS end_time',
                'SUM(user_test.score) AS total_score',
            ]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'attributes' => [
                    'id',
                    'name',
                    'start_time',
                    'total_score',
                ],
            ],
        ]);

        $dataProvider->sort->defaultOrder = ['name' => SORT_ASC];

        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }

        // filtering
        $query->andFilterWhere(['like', 'user.id', $this->id]);
        $query->andFilterWhere(['like', 'user.name', $this->name]);

        if ($this->start_time) {
            $query->andHaving(['like', 'start_time', $this->start_time]);
        }

        if ($this->total_score) {
            $query->andHaving(['like', 'total_score', $this->total_score]);
        }

        return $dataProvider;
    }
}
