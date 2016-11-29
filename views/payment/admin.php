<?php
use komer45\partnership\models\PspaymentHistory;
use komer45\partnership\components\PayWidget;
use komer45\partnership\models\PsPayment;
use komer45\partnership\models\PsPartner;
use pistol88\order\models\Order;
?>
<?php
$pid = Yii::$app->user->id;	
print'<pre>';
//var_dump(Yii::$app->user->identity->attributes);
//var_dump(Yii::$app->authManager->getRole(Yii::$app->user->id));	
if ($partner = PsPartner::find()->where(['partner_id' => $pid])->one())  //идентифицируем пользователя
{
	$payments = PsPayment::find()->where(['partner_id' => $partner->id])->all();
	
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
			echo '<td>'.$payment->id.'</td>';
			echo '<td>'.$payment->sum.'</td>';
			echo '<td>'.$payment->date.'</td>';
			echo '<td>'.PsPartner::find()->where(['partner_id' => $payment->partner_id])->one()->code.'</td>';
			if ($payment->status == 0)			//партнер сделал запрос на получение выплаты
			{
				echo "<form action='/partnership/payment/create'>";
					echo '<td>Ожидание</td>';
					Yii::$app->session['use'] = '2';
					Yii::$app->session['pay'] = $payment->id;
					Yii::$app->session['par'] = $payment->partner_id;
					echo '<td><input type=submit value=выплатить></td>';//REPLACE THIS
				echo '</form>';
			}
			else 								//выплата была подтверждена админом
				echo '<td>Выплачено</td>';
			echo '</tr>';
		}
	} echo '</table>';
}