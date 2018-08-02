<?php

use yii\helpers\Html;
use yii\widgets\ListView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\CardSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Cards';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="card-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php echo $this->render('search', ['model' => $model]); ?>

    <p>
        <?= Html::a('Create Card', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= ListView::widget([
        'dataProvider' => $provider,
        'itemView' => 'card_list'
    ]) ?>

</div>
