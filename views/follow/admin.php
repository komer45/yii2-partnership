<?php
use yii\helpers\Html;
use yii\helpers\Url;
use kartik\grid\GridView;
$this->title = 'История Следований';

?>
	<?php echo GridView::widget([
			'dataProvider' => $dataProvider,
			'filterModel' => $searchModel,
			'columns' => [
				['class' => 'yii\grid\SerialColumn'],
				
				'ip',
				'url_from',
				'url_to',
				'date',

				[
					'format' => 'raw',
					'value' => function($model) {
						return Html::a('Вознаграждения', Url::to(['/partnership/partner/view', 'id' => $model->id]), ['class' => 'btn btn-default']);
					}
				]
				
			]
			
	]);