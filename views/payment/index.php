<?php
use komer45\partnership\models\PsOrderHistory;
use komer45\partnership\components\PayWidget;
use komer45\partnership\models\PsPayment;
use komer45\partnership\models\PsPartner;
use pistol88\order\models\Order;
use yii\bootstrap\Tabs;
?>
<?php
$pid = Yii::$app->user->id;												
Yii::$app->session['use'] = '1';
Yii::$app->session['par'] = PsPartner::find()->where(['partner_id' => Yii::$app->user->id])->one();
?>
<div id="exTab1" class="container">	
	<ul  class="nav nav-pills">
		<li class="active">
			<a  href="#1a" data-toggle="tab">Активные заказы</a>
		</li>
		<li>
			<a href="#2a" data-toggle="tab">Запрошенные выплаты</a>
		</li>
	</ul>

	<div class="tab-content clearfix">
		<div class="tab-pane active" id="1a">
		<?
			if ($partner = PsPartner::find()->where(['partner_id' => $pid])->one())  //идентифицируем пользователя
			{
				$orders = PsOrderHistory::find()->where(['partner_id' => $partner->id, 'status' => 0])->all();
				
				if ($orders)
				{
					echo '<table cellpadding=10>';
					echo '<tr>
							<td>№ Заказа</td>
							<td>Имя Клиента</td>
							<td>Почта Клиента</td>
							<td>Сумма Заказа</td>
							<td>Дата Заказа</td>
							<td>Сумма Отчислений</td>
					</tr>';
					foreach ($orders as $order)
					{
						echo '<tr>';
						echo '<td>'.$order->order_id.'</td>';
						echo '<td>'.Order::find()->where(['id' => $order->order_id])->one()->client_name.'</td>';
						echo '<td>'.Order::find()->where(['id' => $order->order_id])->one()->email.'</td>';
						echo '<td>'.$order->sum.'</td>';
						echo '<td>'.$order->date.'</td>';
						echo '<td>'.$order->recoil.'</td>';
						$recoils = $recoils+$order->recoil;
						echo '</tr>';
					}
				} elseif (($_GET["payment"] != 'payed') && (Yii::$app->user->id != NULL)) {
					echo 'У Вас нет активных заказов для выплат.';
				} else {
					echo 'Заявка на выплату отправлена';
				}

				if ($recoils>0)
					echo 'Общая сумма Ваших отчислений составляет: '.$recoils.'р.';
				if ($recoils>=Yii::$app->params['min'])
				{
					echo "<form action='/partnership/payment/create' method='POST'>";
						echo "<input type=submit name='button' value=Получить>";
						//echo "<input type=hidden name=recoils value=$recoils>";
						Yii::$app->params['recoils'] = $recoils;
					echo "</form>";	
				}
				elseif ($recoils != NULL) 
					echo 'У Вас недостаточно отчислений по заказам для совершения выплаты';
				echo '</table>';
			}
		?>
		</div>
		
		<div class="tab-pane" id="2a">
		<?
			echo '<table cellpadding=10><tr><td colspan=99>Заявки на выплаты: </td><tr>';
			echo '<tr>
			<td>№ Заявки</td>
			<td>Сумма</td>
			<td>Дата</td>
			';
			$payments = PsPayment::find()->where(['partner_id' => $partner->id])->all();
			foreach ($payments as $payment)
			{
				echo '<tr>';
				echo '<td>'.$payment->id.'</td>';
				echo '<td>'.$payment->sum.'</td>';
				echo '<td>'.$payment->date.'</td>';
				if ($payment->status == 0)
					echo '<td>Ожидает выплаты</td>';
				elseif ($payment->status == 1)
					echo '<td>Выплачено</td>';
				echo '</tr>';
			}		
			echo '</tr></table>';
		?>
		</div>
	</div>
</div>


<!-- Bootstrap core JavaScript
    ================================================== -->
	<!-- Placed at the end of the document so the pages load faster -->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
	<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>