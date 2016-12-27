<?
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
				//'user_id',
				//'partner'
				//'status'
				
				[
					'format' => 'raw',
					'value' => function($model) {
						return Html::a('Вознаграждения', Url::to(['/partnership/partner/view', 'id' => $model->id]), ['class' => 'btn btn-default']);
					}
				]
				
			]
			
	]);
/*
echo '<table cellpadding=10>';
echo '<tr>
		<td>№ записи</td>
		<td>Ip пользователя</td>
		<td>Id юзера</td>
		<td>Id юзера(временный)</td>
		<td>Откуда</td>
		<td>Куда</td>
		<td>Партнер</td>
		<td>Дата</td>
	  </tr>';
	  
foreach ($model as $follow)
{
	echo '<tr>';
	echo '<td>'.$follow->id.'</td>';
	echo '<td>'.$follow->ip.'</td>';
	echo '<td>'.$follow->user_id.'</td>';
	echo '<td>'.$follow->tmp_user_id.'</td>';
	echo '<td>'.$follow->url_from.'</td>';
	echo '<td>'.$follow->url_to.'</td>';
	echo '<td>'.$follow->partner.'</td>';
	echo '<td>'.$follow->date.'</td>';
	$partner = $follow->partner;
	if ($follow->status == 1){
		echo '<td>Активно</td>';
		echo "<td><a href=/partnership/follow/activate?statusTo=0&partner=$partner>Деактивировать</a></td>";
	}elseif ($follow->status == 0){
		echo '<td>Деактивировано</td>';
		echo "<td><a href=/partnership/follow/activate?statusTo=1&partner=$partner>Активировать</a></td>";
	}
	echo '</tr>';
}
echo '</table>';*/