<?php
use komer45\partnership\models\PsOrderHistory;
use komer45\partnership\components\PayWidget;
use komer45\partnership\models\PsPayment;
use komer45\partnership\models\PsPartner;
use pistol88\order\models\Order;
?>
<?php
$pid = Yii::$app->user->id;												
if ($partner = PsPartner::find()->where(['partner_id' => $pid])->one())  //идентифицируем пользователя
{
	$orders = PsOrderHistory::find()->where(['partner_id' => $partner->id, 'status' => 0])->all();
	
	if ($orders){
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
		echo 'Выплата была перечисленна на ваш счет';
	}
	
	if ($recoils>0)
		echo 'Общая сумма Ваших отчислений составляет: '.$recoils.'р.';
	if ($recoils>=Yii::$app->params['min'])
	{
		echo "<form action='/partnership/payment/create' method='POST'>";
			echo "<input type=submit name='button' value=Получить>";
			echo "<input type=hidden name=recoils value=$recoils>";
		echo "</form>";	
	}
	elseif ($recoils != NULL) echo 'У Вас недостаточно отчислений по заказам для совершения выплаты';
	echo '</table>';
}