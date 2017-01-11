<?php
use yii\helpers\Html;
use yii\helpers\Url;
use kartik\grid\GridView;
$this->title = 'Заказ: '.$order->id;
$this->params['breadcrumbs'][] = ['label' => 'Вознаграждения', 'url' => ["/partnership/partner/view?id=$partnerId"]];

?>
<div class="partner-admin">
Showing <b>1-1</b> of <b>1</b> items.
<table cellpadding=10 border=1 class="table table-bordered">
	<tr>
		<td><b>Id заказа</td>
		<td><b>Клиент</td>
		<td><b>Промокод</td>
		<td><b>Дата</td>
		<td><b>Статус</td>
		<td><b>Товар</td>
		<td><b>Стоимость Товара</td>
		<td><b>Количество</td>
		<td><b>Сумма заказа</td>
	</tr>
	<tr>
		<td><?=$order->id;?></td>
		<td><?=$order->client_name;?></td>
		<td><?=$order->promocode;?></td>
		<td><?=$order->date;?></td>
		<td><?=$order->status;?></td>
		<td><?=$orderElement->item_id;?></td>
		<td><?=$orderElement->price;?></td>
		<td><?=$orderElement->count;?></td>
		<td><?=$order->cost;?></td>
	</tr>
</table>
</div>