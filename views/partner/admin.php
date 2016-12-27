<?php
use yii\helpers\Html;
use yii\helpers\Url;
use kartik\grid\GridView;
$this->title = "Партнеры";
?>
<div class="partner-admin">


    <?php echo GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
			'user_id',
			'code',
			'status',
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
			]
            //['class' => 'yii\grid\ActionColumn', 'template' => '{update} {delete}',  'buttonOptions' => ['class' => 'btn btn-default'], 'options' => ['style' => 'width: 65px;']]
        ],
    ]); ?>
	
	
	
</div>