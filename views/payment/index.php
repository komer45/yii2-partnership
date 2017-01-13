<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\DetailView;
use yii\helpers\ArrayHelper;
use kartik\select2\Select2;
use nex\datepicker\DatePicker;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $model komer45\partnership\models\Setting */

if($dateStart = yii::$app->request->get('date_start')) {
    $dateStart = date('d.m.Y', strtotime($dateStart));
}

if($dateStop = yii::$app->request->get('date_stop')) {
    $dateStop = date('d.m.Y', strtotime($dateStop));
}


$this->title = 'Мои вознаграждения';
$this->params['breadcrumbs'][] = $this->title;

?>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>


<div class="panel panel-primary">
	<div class="panel-heading">
		<h3 class="panel-title"><?=yii::t('order', 'Search');?></h3>
	</div>
	<div class="panel-body">
		<form action="" class="row search">
			<input type="hidden" name="id" value="" />
			<input type="hidden" name="OperationSearch[name]" value="" />

			<div class="col-md-4">
				<div class="row">
					<div class="col-md-6">
						<?= DatePicker::widget([
							'name' => 'date_start',
							'addon' => false,
							'value' => $dateStart,
							'size' => 'sm',
							'language' => 'ru',
							'placeholder' => yii::t('order', 'Date from'),
							'clientOptions' => [
								'format' => 'L',
								'minDate' => '2015-01-01',
								'maxDate' => date('Y-m-d'),
							],
							'dropdownItems' => [
								['label' => 'Yesterday', 'url' => '#', 'value' => \Yii::$app->formatter->asDate('-1 day')],
								['label' => 'Tomorrow', 'url' => '#', 'value' => \Yii::$app->formatter->asDate('+1 day')],
								['label' => 'Some value', 'url' => '#', 'value' => 'Special value'],
							],
						]);?>
					</div>
					<div class="col-md-6">
						<?= DatePicker::widget([
							'name' => 'date_stop',
							'addon' => false,
							'value' => $dateStop,
							'size' => 'sm',
							'placeholder' => yii::t('order', 'Date to'),
							'language' => 'ru',
							'clientOptions' => [
								'format' => 'L',
								'minDate' => '2015-01-01',
								'maxDate' => date('Y-m-d'),
							],
							'dropdownItems' => [
								['label' => yii::t('order', 'Yesterday'), 'url' => '#', 'value' => \Yii::$app->formatter->asDate('-1 day')],
								['label' => yii::t('order', 'Tomorrow'), 'url' => '#', 'value' => \Yii::$app->formatter->asDate('+1 day')],
								['label' => yii::t('order', 'Some value'), 'url' => '#', 'value' => 'Special value'],
							],
						]);?>
					</div>
				</div>
			</div>

			<div class="col-md-2">
				<input class="form-control btn-success" type="submit" value="<?=Yii::t('order', 'Search');?>" />
			</div>
			<div class="col-md-3">
				<a class="btn btn-default" href="<?= Url::to(["/partnership/payment"]) ?>" />Cбросить все фильтры</a>
			</div>
		</form>
	</div>
</div>
  
<div class="setting-view">
<ul class="nav nav-tabs">
  <li class="active"><a data-toggle="tab" href="#profit">Начисления</a></li>
  <li><a data-toggle="tab" href="#payment">Выплаты</a></li>
</ul>

	<div class="tab-content">

		<div id="profit" class="tab-pane fade in active">
			<?php echo  Html::tag('h3', Html::encode('Общая сумма моих отчислений: '.$partnerRecoils));
			//echo '<h3>Общая сумма моих отчислений: '.$partnerRecoils.' ';	
				if ($partnerRecoils >= 500){
					echo Html::a('Выплатить', url::to(['/partnership/payment/payment-request', 'recoils' => $partnerRecoils]), ['class' => 'btn btn-default']);	
				}
				//echo ' </h3>';
				//echo Html::a('Очистить все фильты', url::to(['/partnership/payment/']), ['class' => 'btn btn-default']);
			?>
			
			
			
			<?php echo GridView::widget([
				'dataProvider' => $orderHistoryDataProvider,
				'filterModel' => $orderHistorySearchModel,
				'columns' => [
					['class' => 'yii\grid\SerialColumn'],
					
					'date',
					'sum',
					'recoil',
					[
						'format' => 'raw',
						'header' => $sort->link('status'),
						'value' => function($model) {
							if ($model->status == 'new'){
								return 'Новый';
							}elseif ($model->status == 'process'){
								return 'В обработке';
							}elseif ($model->status == 'payed'){
								return 'Выплачен';
							}
						},
						'filter' =>  Select2::widget([
							'name' => 'SearchOrderHistory[status]',
							'data'  => ['new' => 'Новый', 'process' => 'В процессе', 'payed' => 'Выплачено'],
							'options' => ['placeholder' => 'Статус...'],
							'pluginOptions' => [
								'tags' => true,
								'tokenSeparators' => [',', ' '],
								'maximumInputLength' => 10
							],
						])	
					],
				],
			]); ?>  
		</div>


		<div id="payment" class="tab-pane fade">

			<?php echo GridView::widget([
				'dataProvider' => $paymentDataProvider,
				'filterModel' => $paymentSearchModel,
				'columns' => [
					['class' => 'yii\grid\SerialColumn'],
					
					'date',
					'sum',
					[
						'format' => 'raw',
						'header' => $sort->link('status'),
						'value' => function($model) {
							if($model->status == 0){
								return 'В ожидании';
							}else {
								return 'Выплачено';
							}
						},
						'filter' =>  Select2::widget([
							'name' => 'SearchPayment[status]',
							'data'  => ['0' => 'В ожидании', '1' => 'Выплачено'],
							'options' => ['placeholder' => 'Choose a user ...'],
							'pluginOptions' => [
								'tags' => true,
								'tokenSeparators' => [',', ' '],
								'maximumInputLength' => 10
							],
						])
					],
					
					
				],
			]); ?>  
		</div>
	</div>
</div>
