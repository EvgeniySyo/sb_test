<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\elasticsearch\ActiveDataProvider;
use common\models\Card;
use common\models\CardElastic;

/**
 * Вспомогательный класс для поиска в elastic
 */
class CardElasticSearch extends CardElastic
{
    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Создает data provider экземпляр с примененным ES запросом
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = CardElastic::find();
		$provider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 6,
            ],
            'sort' => [
				'defaultOrder' => [
					'id' => SORT_DESC,
				]
            ],
        ]);
        $this->load($params);
		
        if (!$this->validate()) {
            return $provider;
        }
    
        if ($this->title) {
            $query->query(['match_phrase_prefix' => ['title' => $this->title]]);
        }
        
        $models = $provider->getModels();
        foreach ($models as $model) {
            $key = Card::CARD_CACHE_VIEWS . $model->id;
			
            $views = \Yii::$app->cache->get($key);
			/*if(!$views){
				$from_db = Card::findOne($model->id);
				$views = $from_db->views;
				\Yii::$app->cache->set($key, $views);
			}*/
            $model->views = $views ? $views : 0; 
        }    
        $provider->setModels($models);
    
        return $provider;
    }
}
