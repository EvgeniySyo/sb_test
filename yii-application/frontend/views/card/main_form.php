<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Card */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="card-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'description')->textarea(['rows' => '6', 'maxlength' => true]) ?>
	
	<?= $form->field($model, 'image')->fileInput() ?>
	
    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>
	<?php if($model->image){ ?>
		<div class="card-old_img">
			<p>Текущее изображение(при загрузке нового - оно будет заменено):</p>
			<img src="<?php echo "/images/".$model->image; ?>" alt="">
		</div>
	<?php } ?>
    <?php ActiveForm::end(); ?>

</div>
