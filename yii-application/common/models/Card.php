<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "card".
 *
 * @property int $id
 * @property string $title
 * @property string $description
 * @property string $image
 * @property int $views
 */
class Card extends \yii\db\ActiveRecord
{
    const CARD_CACHE_VIEWS = 'card_views_';
	
	/**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'card';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title', 'description'], 'required'],
            [['description'], 'string'],
            [['views'], 'integer'],
            [['title'], 'string', 'max' => 255],
			[['image'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Title',
            'description' => 'Description',
            'image' => 'Image',
            'views' => 'Views',
        ];
    }
	
	/**
     * Увеличение просмотров для карточки
     *
	 * Просмотры так же заносятся в кэш для актуальности при выборке из elastic
     * @return void
     */
    public function view_increase()
    {    
        $cache_key = self::CARD_CACHE_VIEWS . $this->id;
        $cur_count = \Yii::$app->cache->get($cache_key);
        $views = $cur_count ? $cur_count + 1 : 1;
        $this->views = $views; // обновляем просмотры в БД
        \Yii::$app->cache->set($cache_key, $views);
    }
}
