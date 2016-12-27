<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\DetailView;

use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $model komer45\partnership\models\Setting */

//var_dump($model); $model - модель партнера (объект)


$this->title = 'Партнер: '.$model->code;
$this->params['breadcrumbs'][] = ['label' => 'Партнеры', 'url' => ['/partnership/partner/admin']];
$this->params['breadcrumbs'][] = $this->title;
?>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>


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
				'value' => function($model) {
					if($model->status == 0){
						return Html::a('Выплатить', Url::to(['/partnership/partner/make-payment', 'paymentId' => $model->id]));
					}else {
						return 'Выплачено';
					}
				}
			]
			
		],
    ]); ?>  
	  
  </div>
  <div id="profit" class="tab-pane fade">
    
	    <?php echo GridView::widget([
        'dataProvider' => $profitDataProvider,
        'filterModel' => $profitSearchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
			
			[
			    'format' => 'raw',
				'label' => 'Заказ', 
				'value' => function($model) {
					return Html::a("$model->order_id", Url::to(['/partnership/partner/order-view', 'orderId' => $model->order_id]));
				}
			],
			'date',
			'recoil',
			[
			    'format' => 'raw',
				'label' => 'Реферал', 
				'value' => function($model) {
					return $model->user->name;
				}
			],
		],
    ]); ?>
	
	
  </div>

</div>




</div>
