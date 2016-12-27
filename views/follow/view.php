<?
use yii\helpers\Html;
use yii\helpers\Url;
use kartik\grid\GridView;

use komer45\partnership\widgets\PartnerWidget;

echo PartnerWidget::widget();

$this->title = 'Партнер: '.$model->id;
echo '<pre>';
//die(var_dump(Yii::$app->user->identity));
//die(var_dump($model));
//die(var_dump($DataProvider));
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
					'label' => 'Реферал', 
					'value' => function($model) {
						$userModel = Yii::$app->user->identity;			//Для идентифицирования пользователей системы
						$user = $userModel::findOne($model->user_id);	//находим пользователя по данному полю
						return $user->name;								//выводим имя пользователя
					}
				],
				[
					'format' => 'raw',
					'label' => 'Статус', 
					'value' => function($model) {
						if($model->status == 1){	//!ВАЖНО: РЕФАКТОР СТАТУСОВ!
							return 'Активно';
						}else {
							return 'Неактивно';
						}
					}
				],
				[
					'format' => 'raw',
					'label' => 'Активность',
					'value' => function($model){
						if($model->status ==  0){		//!ВАЖНО: РЕФАКТОР СТАТУСОВ!
							return Html::a('Активировать', Url::to(['/partnership/follow/activate', 'followId' => $model->id]));
						}else {
							return Html::a('Деактивировать', Url::to(['/partnership/follow/deactivate', 'followId' => $model->id]));
						}
					}
				]
			],

			
	]);
?>

	 </div>

</div>

</div>
