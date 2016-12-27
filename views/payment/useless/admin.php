<?php
use komer45\partnership\models\paymentHistory;
use komer45\partnership\components\PayWidget;
use komer45\partnership\models\Payment;
use komer45\partnership\models\Partner;
use pistol88\order\models\Order;
?>
<?php	
print'<pre>';
	if ($payments)
	{
		echo '<table cellpadding=10>';
		echo '<tr>
				<td>№ Выплаты</td>
				<td>Сумма Выплаты</td>
				<td>Дата</td>
				<td>№ Партнера</td>
				<td>Статус</td>
		</tr>';
		foreach ($payments as $payment)
		{
			echo '<tr>';
			echo '<td>'.$paymentId = $payment->id; echo '</td>';
			echo '<td>'.$payment->sum.'</td>';
			echo '<td>'.$payment->date.'</td>';
			echo '<td>'.Partner::find()->where(['user_id' => $payment->partner_id])->one()->code; echo '</td>';
			$partnerId = Partner::find()->where(['user_id' => $payment->partner_id])->one()->id;
			if ($payment->status == 0)			//партнер сделал запрос на получение выплаты
			{
				
					echo '<td>';
						print "<a href=/partnership/payment/done?paymentId=$paymentId&partnerId=$partnerId>Выплатить</a>";
					echo '</td>';
			}
			else 								//выплата была подтверждена админом
				echo '<td>Выплачено</td>';
			echo '</tr>';
		}
	} echo '</table>';