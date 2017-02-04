<?php
use yii\helpers\Html;
use yii\helpers\Url;
use kartik\grid\GridView;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use yii\data\Sort;

$this->title = "Партнеры";
//var_dump($payments);
?>
<div class="partner-admin">
    <?php echo GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
		
		'rowOptions' => function ($model) use ($payments){
				foreach($payments as $payment) {
					if($model->id == $payment){
						return ['style' => 'background-color:#FFFACD;'];
					} else {
						return ['style' => 'background-color:#F5FFFA;'];
					}
				}
			},

        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
			'user_id',
			[
				'format' => 'raw',
				'header' => $sortUser->link('user_id'),
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
			'code',
			[
			    'format' => 'raw',
				'header' => $sortStatus->link('status'),
				'value' => function($model) {
					if($model->status === 0){
						return 'Неактивен';
					}
					if($model->status === 1){
						return 'Активен';
					}
				},
				'filter' =>  Select2::widget([
						'name' => 'SearchPartner[status]',
						'data'  => [0 => 'Неактивен', 1 => 'Активен'],
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
				'value' => function($model) {
					if($model->status === 0){
						return Html::a('Активировать', Url::to(['/partnership/partner/activate', 'statusTo' => 1, 'partner' => $model->id]));
					}
					if($model->status === 1){
						return Html::a('Деактивировать', Url::to(['/partnership/partner/activate', 'statusTo' => 0, 'partner' => $model->id]));
					}
				}
			],
			[
				'format' => 'raw',
				'value' => function($model) {
					return Html::a('Вознаграждения', Url::to(['/partnership/partner/view', 'id' => $model->id]), ['class' => 'btn btn-default']);
				}
			],
			[
				'format' => 'raw',
				'value' => function($model) {
					return Html::a('Переходы',		 Url::to(['/partnership/follow/view', 'id' => $model->id, 'pCode' => $model->code]), ['class' => 'btn btn-default']);
				}
			],
            //['class' => 'yii\grid\ActionColumn', 'template' => '{update} {delete}',  'buttonOptions' => ['class' => 'btn btn-default'], 'options' => ['style' => 'width: 65px;']]
        ],
    ]);?>

</div>