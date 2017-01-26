<?php

?>

<style type="text/css">
	td{
		padding:10px;
	}
</style>
<div class="partner-admin">
<table cellpadding=10 border=1 class="table table-bordered">
	<tr>
		<td><H2>Наименование(Таблица)</H2></td>
		<td><H2>Ссылка</H2></td>
		<td><H2>Описание</H2></td>
	</tr>
	<tr>
		<td><b>Партнеры</b>(<u>Partners</u>)</td>
		<td><nobr><a href=<?=Yii::$app->request->hostInfo.'/partnership/partner/admin'?>>/partnership/partner/admin</a></nobr></td>
		<td>Страница  администратора. Администратор видит список активности  всех партнеров - их переходы, вознаграждения. Так же имеет функцию активации/деактивации партнеров</td>
	</tr>
	<tr>
		<td></td>
		<td><nobr><a href=<?=Yii::$app->request->hostInfo.'/partnership/partner/'?>>/partnership/partner</a></nobr></td>
		<td>
			Страница партнера. партнер видит список переходов пользователей по его ссылке.
		</td>
	</tr>
	<tr>
		<td></td>
		<td><nobr><a style='color:red'>/partnership/partner/activate</a></nobr></td>
		<td>
			Ссылка (оформлена кнопкой) для активации/деактивации статуса партнера. <b>Требуемые параметры</b>: номер партнера($partner)
			<br><u>Находится на странице /partnership/partner/admin.</u>
		</td>
	</tr>
	<tr>
		<td></td>
		<td><nobr><a style='color:red'>/partnership/partner/view</a></nobr></td>
		<td>
			Страница партнера(для администратора). Администратор видит список активности выбранного партнера. <b>Требуемые параметры</b>: номер партнера($id)
		</td>
	</tr>
	<tr>
		<td></td>
		<td><nobr><a style='color:red'>/partnership/partner/make-payment</a></nobr></td>
		<td>
			Функция совершения выплаты (для админа). <b>Необходимые параметры:</b> userId. <u>Кнопка выплаты находится на странице /partnership/partner/view</u>
		</td>
	</tr>
	<tr>
		<td></td>
		<td><nobr><a style='color:red'>/partnership/partner/become-partner</a></nobr></td>
		<td>
			Функция запроса на становление партнером. Размещается на странице пользователя. Доступна из виджета PartnerWidget. <b>Необходимые параметры:</b> userId. <u>
		</td>
	</tr>
	<tr>
		<td></td>
		<td><nobr><a style='color:red'>/partnership/partner/referrer</a></nobr></td>
		<td>
			Реферральная ссылка. <b>Необходимые параметры:</b> code.
		</td>
	</tr>
	
	
	
	<!---->
	<tr>
		<td><b>Выплаты</b>(<u>Payments</u>)</td>
		<td><nobr><a href=<?=Yii::$app->request->hostInfo.'/partnership/payment'?>>/partnership/payment</a></nobr></td>
		<td>
			Страница выплат партнера.
		</td>
	</tr>
	<tr>
		<td></td>
		<td><nobr><a style='color:red'>/partnership/payment-request</a></nobr></td>
		<td>
			Для партнера - заявка на выплату (кнопка). <b>Необходимые параметры:</b> заявленная сумма (recoils).
		</td>
	</tr>
	
	<!---->
	
	<tr>
		<td><b>Переходы</b>(<u>Follows</u>)</td>
		<td><nobr><a href=<?=Yii::$app->request->hostInfo.'/partnership/follow/admin'?>>/partnership/follow/admin</a></nobr></td>
		<td>
			Список всех совершенных переходов (для администратора) по реферральным ссылкам.
		</td>
	</tr>
	<tr>
		<td></td>
		<td><nobr><a style='color:red'>/partnership/follow/view</a></nobr></td>
		<td>
			Список всех совершенных переходов (для администратора) по реферральным ссылкам выбранного партнера.  <b>Необходимые параметры:</b> номер партнера (id), код партнера(pCode)
		</td>
	</tr>
	<tr>
		<td></td>
		<td><nobr><a style='color:red'>/partnership/follow/activate</a></nobr></td>
		<td>
			Ссылка на активацию перехода. <b>Необходимые параметры:</b> Номер перехода (followId)
		</td>
	</tr>
	<tr>
		<td></td>
		<td><nobr><a style='color:red'>/partnership/follow/deactivate</a></nobr></td>
		<td>
			Ссылка на деактивацию перехода. <b>Необходимые параметры:</b> Номер перехода (followId)
		</td>
	</tr>
	
	<!---->
	
	<tr>
		<td><b>Товары</b>(<u>Merch</u>)</td>
		<td><nobr><a href=<?=Yii::$app->request->hostInfo.'/partnership/merch'?>>/partnership/merch</a></nobr></td>
		<td>
			Список товаров (при условии подключенного модуля pistol88/yii2-cart, pistol88/yii2-order)
		</td>
	</tr>
	<tr>
		<td></td>
		<td><nobr><a style="color: red">/partnership/order</a></nobr></td>
		<td>
			Страница заказа (при условии подключенного модуля pistol88/yii2-cart, pistol88/yii2-order). Переход по нажатию на кнопку "заказать" на странице /partnership/merch
		</td>
	</tr>
	
	<!---->
	
	<tr>
		<td><b>Настройки отчислений</b>(<u>Settings</u>)</td>
		<td><nobr><a href=<?=Yii::$app->request->hostInfo.'/partnership/setting'?>>/partnership/setting</a></nobr></td>
		<td>
			Страница настроек условий отчислений за заказы.
		</td>
	</tr>
	<tr>
		<td></td>
		<td>
		<nobr><a href=<?=Yii::$app->request->hostInfo.'/partnership/setting/create'?>>/partnership/setting/create</a></nobr>
		<br><a style='color:red'>/partnership/setting/view</a>
		<br><a style='color:red'>/partnership/setting/update</a>
		<br><a style='color:red'>/partnership/setting/delete</a>
		</td>
		
		<td>
			Просмотр, Обзор, Редактирование, Удаление
		</td>
	</tr>
</table>
</div>