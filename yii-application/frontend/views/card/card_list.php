<?php
use yii\helpers\Html;
use yii\helpers\HtmlPurifier;
?>
<div class="post">
    <h2><?= Html::a(Html::encode($model->title), ['view', 'id' => $model->id]) ?></h2>
    <p><?= HtmlPurifier::process($model->description) ?></p>
    <p>ID: <?= Html::encode($model->id) ?></p>
    <p>Count Views: <?= Html::encode($model->views) ?></p>
</div>