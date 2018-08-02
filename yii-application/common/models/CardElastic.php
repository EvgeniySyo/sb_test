<?php

namespace common\models;

use Yii;

/**
 * класс для работы с карточками с помощью elastic
 *
 * card
 * @property int $id
 * @property string $title
 * @property string $description
 * @property string $image
 * @property int $views
 */
class CardElastic extends \yii\elasticsearch\ActiveRecord
{
    public static function index() 
    {  
        return 'elastic'; 
    } 
    
    public static function type() 
    {  
        return 'card'; 
    } 

    public function attributes()
    {
        return [
            "id",
            "title",
            "description",
			"image",
            "views"
        ];
    }

    public function rules() 
    {
        return [
            [$this->attributes(), 'safe'] //'safe'  
        ];
    }
}
