<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $model komer45\partnership\models\Setting */
/* @var $form yii\bootstrap\ActiveForm */
?>

<div class="setting-form">
	
    <?php $form = ActiveForm::begin(); ?>

    <?php echo $form->errorSummary($model); ?>
	<div class="row">
		<div class="col-sm-4 col-md-4">
			<?php echo $form->field($model, 'sum')->textInput(['placeholder' => 'с какой суммы'])->label(false) ?>
		</div>
		<div class="col-sm-4 col-md-3">
			<?php echo $form->field($model, 'percent')->textInput(['placeholder' => 'процент'])->label(false) ?>
		</div>
		<div class="col-sm-4">
		<?php echo Html::submitButton('Сохранить', ['class' =>'btn btn-success']) ?>
		</div>
	</div>

    <?php ActiveForm::end(); ?>

</div>
