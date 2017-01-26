<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\DetailView;
use nex\datepicker\DatePicker;
use kartik\select2\Select2;
use yii\bootstrap\ActiveForm;
use yii\web\JsExpression;
use yii\bootstrap\Modal;
use yii\helpers\ArrayHelper;
use yii\data\Sort;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $model komer45\partnership\models\Setting */

if($dateStart = yii::$app->request->get('date_start')) {
    $dateStart = date('d.m.Y', strtotime($dateStart));
}

if($dateStop = yii::$app->request->get('date_stop')) {
    $dateStop = date('d.m.Y', strtotime($dateStop));
}

$this->title = 'Партнер: '.$model->code;
$this->params['breadcrumbs'][] = ['label' => 'Партнеры', 'url' => ['/partnership/partner/admin']];
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
				<input type="hidden" name="id" value="<?=$model->id?>" />
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
                    <a class="btn btn-default" href="<?= Url::to(["/partnership/partner/view?id=$model->id"]) ?>" />Cбросить все фильтры</a>
                </div>
            </form>
        </div>
    </div>  
  
<div class="setting-view">
	<ul class="nav nav-tabs">
	  <li class="active"><a data-toggle="tab" href="#payment">Выплаты</a></li>
	  <li><a data-toggle="tab" href="#profit">Начисления</a></li>
	</ul>
	<div class="tab-content">
	  <div id="payment" class="tab-pane fade in active">

			<?php echo GridView::widget([
			'dataProvider' => $paymentDataProvider,
			'filterModel' => $paymentSearchModel,
			'columns' => [
				['class' => 'yii\grid\SerialColumn'],
				
				'date',
				'sum',
				[
					'format' => 'raw',
					'header' => $sortStatus->link('status'),
					
					'filter' =>  Select2::widget([
						'name' => 'SearchPayment[status]',
						'data'  => [0 => 'Не выплачено', 1 => 'Выплачено'],
						'options' => ['placeholder' => 'Статус...'],
						'pluginOptions' => [
							'tags' => true,
							'tokenSeparators' => [',', ' '],
							'maximumInputLength' => 10
						],
					]),
					
					'value' => function($model) {
						if($model->status == 0){
							return Html::a('Выплатить', Url::to(['/partnership/partner/make-payment', 'paymentId' => $model->id]));
						}else {
							return 'Выплачено';
						}
					},
				]
			],
		]); ?>  
		  
	  </div>
	  <div id="profit" class="tab-pane fade">
		
			<?php 
			echo GridView::widget([
			'dataProvider' => $profitDataProvider,
			'filterModel' => $profitSearchModel,
			'columns' => [
				['class' => 'yii\grid\SerialColumn'],
				
				[
					'format' => 'raw',
					'header' => $sortOrder->link('order_id'), 
					'value' => function($model) {
						return Html::a("$model->order_id", Url::to(['/partnership/partner/order-view', 'orderId' => $model->order_id]));
					},
					'filter' =>  Select2::widget([
						'name' => 'SearchOrderHistory[order_id]',
						'data'  => ArrayHelper::map($orders, 'order_id', 'order_id'),
						'options' => ['placeholder' => 'Заказа №...'],
						'pluginOptions' => [
							'tags' => true,
							'tokenSeparators' => [',', ' '],
							'maximumInputLength' => 10
						],
					])
				],
				'date',
				'recoil',
				[
					'format' => 'raw',
					'header' => $sort->link('user_id'),
					'value' => function($model) {
						$userModel = Yii::$app->user->identity;			//Для идентифицирования пользователей системы
						$user = $userModel::findOne($model->user_id);	//находим пользователя по данному полю
						if(!$user){
							return false;
						}elseif(!($user->username)){
							return 'Гость';
						}
						return $user->username;								//выводим имя пользователя
					},

					'filter' =>  Select2::widget([
						'name' => 'SearchOrderHistory[user_id]',
						'data'  => ArrayHelper::map($users, 'id', 'username'),
						'options' => ['placeholder' => 'Choose a user ...'],
						'pluginOptions' => [
							'tags' => true,
							'tokenSeparators' => [',', ' '],
							'maximumInputLength' => 10
						],
					])
				],
			],
		]); 
		?>
	  </div>
	</div>
</div>
