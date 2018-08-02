<?php

namespace common\models;

use yii\base\Model;
use yii\web\UploadedFile;

/**
 * CardSearch - класс представляет модель формы поиска   `common\models\Card`.
 */
class CardImageHelper extends Model{

	public $image;

	public function rules(){
		return[
		[['image'], 'file', 'extensions' => 'png, jpg, gif'],
		];
	}

	public function upload($id = ''){
		if($this->validate()){
			$fname = empty($id) ? $this->image->baseName : $id;
			$fname .= ".".strtolower($this->image->extension);
			$this->image->saveAs(\Yii::getAlias('@webroot')."/images/".$fname);
			return($fname);
		}else{
			return false;
		}
	}
	
	public function delete($fname){
		if(file_exists(\Yii::getAlias('@webroot')."/images/".$fname)){
			unlink(\Yii::getAlias('@webroot')."/images/".$fname);
		}else{
			return false;
		}
	}

}