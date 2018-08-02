<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Card;

/**
 * CardSearch - класс представляет модель формы поиска   `common\models\Card`.
 */
class CardSearch extends Card
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'views'], 'integer'],
            [['title', 'description', 'image'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
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
        $query = Card::find();
        $provider = new ActiveDataProvider([
            'query' => $query,
        ]);
        $this->load($params);
        if (!$this->validate()) {
            return $provider;
        }
        $query->andFilterWhere([
            'id' => $this->id,
            'views' => $this->views,
        ])->andFilterWhere(['like', 'title', $this->title])
          ->andFilterWhere(['like', 'description', $this->description]);

        return $provider;
    }
}
