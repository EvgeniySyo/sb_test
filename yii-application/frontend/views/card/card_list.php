<?php
use yii\helpers\Html;
use yii\helpers\HtmlPurifier;
?>
<div class="card-list">
    <div class="card-list-img">
		<?= Html::a('<img src="'.($model->image ? "/images/".$model->image : '/css/images/no-image.jpg').'" alt="" class="img-responsive">', ['view', 'id' => $model->id]) ?>
	</div>
	<div class="card-list-data">
		<h2><?= Html::a(Html::encode($model->title), ['view', 'id' => $model->id]) ?></h2>
		<p><?= HtmlPurifier::process($model->description) ?></p>
		<p>ID: <?= Html::encode($model->id) ?></p>
		<p>Просмотры: <?= Html::encode($model->views) ?></p>
	</div>
	<p class="card-list-actions"><strong>Действия:</strong>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary btn-sm']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger btn-sm',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>
</div>