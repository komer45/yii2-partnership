<?php
use yii\helpers\Html;
use yii\helpers\Url;
use kartik\grid\GridView;

$this->title = 'Мои рефералы';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="partner-admin">

	<?php 
		echo GridView::widget([
			'dataProvider' => $dataProvider,
			'filterModel' => $searchModel,
			
			'columns' =>[
				
				[
					'format' => 'raw',
					'label' => 'Реферал', 
					'value' => function($model) {
						$userModel = Yii::$app->user->identity;			//Для идентифицирования пользователей системы
						$user = $userModel::findOne($model->user_id);	//находим пользователя по данному полю
						return $user->name;								//выводим имя пользователя
					}
				],
			
				'url_from',
				'url_to',
				'date',
				
				[
					'format' => 'raw',
					'label' => 'Статус', 
					'value' => function($model) {
						if($model->status == 0){								//!ВАЖНО: РЕФАКТОР СТАТУСА!
							return 'Неактивно';
						}else{
							return 'Активно';
						}
					}
				]
			]
		])
	?>
	
</div>