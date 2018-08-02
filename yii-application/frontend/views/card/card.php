<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\helpers\HtmlPurifier;

/* @var $this yii\web\View */
/* @var $model common\models\Card */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Cards', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="card-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <div class="card-img">
		<img src="<?php echo $model->image ? "/images/".$model->image : '/css/images/no-image.jpg'; ?>" alt="">
	</div>
	<div class="card-data">
	<p><?= HtmlPurifier::process($model->description) ?></p>
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            //'title',
            //'description',
            'views',
			//'image',
        ],
    ]) ?>
	</div>

</div>
