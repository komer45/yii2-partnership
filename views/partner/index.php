<?php
use yii\helpers\Html;
use yii\helpers\Url;
use kartik\grid\GridView;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use yii\data\Sort;

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
					'header' => $sortReferal->link('user_id'),
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
					'name' => 'SearchFollow[user_id]',
					'data'  => ArrayHelper::map($users, 'id', 'username'),
					'options' => ['placeholder' => 'Choose a user ...'],
					'pluginOptions' => [
						'tags' => true,
						'tokenSeparators' => [',', ' '],
						'maximumInputLength' => 10
					],
				])
				],
			
				'url_from',
				'url_to',
				'date',
				
				[
					'format' => 'raw',
					'header' => $sortStatus->link('status'),
					'value' => function($model) {
						if($model->status == 0){
							return 'Неактивно';
						}else{
							return 'Активно';
						}
					},
					'filter' =>  Select2::widget([
						'name' => 'SearchFollow[status]',
						'data'  => ['0' => 'Неактивно', '1' => 'Активно'],
						'options' => ['placeholder' => 'Статус...'],
						'pluginOptions' => [
							'tags' => true,
							'tokenSeparators' => [',', ' '],
							'maximumInputLength' => 10
						],
					])
				]
			]
		])
	?>
</div>