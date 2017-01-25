<?php
use yii\helpers\Html;
use yii\helpers\Url;
use kartik\grid\GridView;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use komer45\partnership\widgets\PartnerWidget;

$this->title = 'Партнер: '.$model->id;
?>

	<?php echo GridView::widget([
			'dataProvider' => $DataProvider,
			'filterModel' => $SearchModel,
			'columns' => [
				['class' => 'yii\grid\SerialColumn'],
				'id',
				'ip',
				'url_from',
				'url_to',
				'date',

				[
					'format' => 'raw',
					'header' => $sortReferals->link('user_id'), 
					'value' => function($model) {
						$userModel = Yii::$app->user->identity;			//Для идентифицирования пользователей системы
						$user = $userModel::findOne($model->user_id);	//находим пользователя по данному полю
						if (!$user){
							return false;
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
				[
					'format' => 'raw',
					'header' => $sortStatus->link('status'), 
					'value' => function($model) {
						if($model->status == 1){
							return 'Активно';
						}else {
							return 'Неактивно';
						}
					},
					'filter' =>  Select2::widget([
					'name' => 'SearchFollow[status]',
					'data'  => [0 => 'Неактивно', 1 => 'Активно'],
					'options' => ['placeholder' => 'Статус...'],
					'pluginOptions' => [
						'tags' => true,
						'tokenSeparators' => [',', ' '],
						'maximumInputLength' => 10
					],
				])
				],
				[
					'format' => 'raw',
					'label' => 'Активность',
					'value' => function($model){
						if($model->status ==  0){
							return Html::a('Активировать', Url::to(['/partnership/follow/activate', 'followId' => $model->id]));
						}else {
							return Html::a('Деактивировать', Url::to(['/partnership/follow/deactivate', 'followId' => $model->id]));
						}
					}
				]
			],

			
	]);
?>