Yii2-partnership
==========
Это модуль для реализации партнерсской программы. Пользователь, перешедший с сайта-партнера, идентифицируется - если он не зарегестрирован в системе, то при переходе он фиксируется за партнером, который привел его. Затам отслеживается его активность по заказам - после завершения заказа партнеру отчисляется определенный процент. По достижению определенной суммы отчислений по заказам клиента партнер может забрать свою выплату.
Для идентификации партнера в системе необходимо: 1. Чтобы он был в таблице user, 2. Чтобы тот пользователь таблицы user, который  должен быть партнером должен быть занесен в таблицу ps_partner, 3. Для идентификации пользователя как партнера в таблице ps_partner в поле partner_id должно быть занесено значение поля id таблицы user соответствующего пользователя. 

Функционал:

* Регистрация переходов
* Привязка пришедшего посетителя к партнеру, который привел посетителя на ресурс.
* Начисление процентов по совершенным (пришедшим пользователем) заказам партнеру, который привел пользователя.
* Управление отчисляемыми процентами

Установка
---------------------------------
Выполнить команду

```
php composer require komer45/yii2-partnership "*"
```

Или добавить в composer.json

```
"komer45/yii2-partnership": "*",
```

И выполнить

```
php composer update
```

Далее, мигрируем базу:

```
php yii migrate --migrationPath=vendor/komer45/yii2-partnership/migrations
```

Подключение и настройка
---------------------------------
Для пользования необходимо подключить модуль в конфиге:

```'php'
	'modules' => [
		'partnership' => [
			'class' => 'komer45\partnership\Module',
			'adminRoles' => ['superadmin', 'administrator'],
		],
		//...
	]
```
Для доступа к компоненту в том же конфиге необходимо подключить обращение:
```'php'
	'components' => [
	...
		'partnership' => [
			'class' => 'komer45\partnership\Partnership'
		],
	...
	]
```
Для того, чтобы подписаться на совершение покупки необходимо в конфиге прописать следующий код для модуля order:

```php
<?php
...
'order' => [
		'class' => 'pistol88\order\Module',
		///...
		'on create' =>function($event) {
			$model = new \komer45\partnership\models\OrderHistory;
			$tmp =  strval(Yii::$app->request->cookies['tmp_user_id']);
			if (!Yii::$app->user->isGuest){             //сли пользователь зарегистрирован
				$model->user_id = Yii::$app->user->id;
				$follow = \komer45\partnership\models\Follow::find()->where(['user_id' => $model->user_id])->one();
				$part   = \komer45\partnership\models\Follow::find()->where(['user_id' => Yii::$app->user->id])->one();
			} else {                                    //иначе - если все-таки гость
				$model->tmp_user_id = $tmp;
				$follow = \komer45\partnership\models\Follow::find()->where(['tmp_user_id' => $model->tmp_user_id])->one();
				$part   = \komer45\partnership\models\Follow::find()->where(['tmp_user_id' => $tmp])->one();
			}
			if($part){
				$partner = \komer45\partnership\models\Partner::find()->where(['code' => $part->partner])->one(); //находим партнера по коду
				$model->partner_id = $partner->id;
			}
			$model->sum = $event->model->cost;
			$model->date = date('Y-m-d');
			$model->order_id = $event->model->id;
			if($follow){
				$model->follow_id = strval($follow->id);    //сюда нужно записать id таблицы ps_follow
			}
				$forperc = \komer45\partnership\models\Setting::find()->all();
				if($forperc){
					foreach ($forperc as $search)
					{
						if ($model->sum >= $search->sum)
						{
							$percent = (($model->sum)/100*$search->percent);
							break;
						}
					}
					$model->recoil = $percent;
				}
				$model->status = 'new';
			if ($model->validate())
			{
				$model->save();
			}   else {
					//die('Uh-oh something in config went wrong');
				}
		},
		//..
]
```
Так жe для перевода пользователя из незарегистрированного в зарегистрированного в контроллере user (\common\models\user) необходимо дописать следующий код в методе afterSignup(array $profileData = []):

```php
<?php

public function afterSignup(array $profileData = [])
{
	$reFollow = \komer45\partnership\models\Follow::find()->where(['tmp_user_id' => Yii::$app->request->cookies['tmp_user_id']])->one();
	$reFollow->tmp_user_id = NULL;
	$reFollow->user_id = $this->getId();
	if ($reFollow->validate())
	{
		$reFollow->save();
	}
	//...
}
```

Для того, чтобы совершить заказ (клиент), запросить выплату (партнер), выплатить (администратор) можно подключить виджеты:

```php
<?php
use komer45\partnership\widgets\OrderWidget;			//Виджет заказа
use komer45\partnership\widgets\PartnerWidget;			//Виджет партнерства
use komer45\partnership\widgets\AdminWidget;			//Переход на вкладку администрирования
use komer45\partnership\widgets\SettingWidget;			//Переход на вкладку настроек
use komer45\partnership\widgets\PartnerOrdersWidget;	//"Мои отчисления", "Мои рефералы" 
?>
<?=OrderWidget::widget();?>
<?=PartnerWidget::widget();?>
<?=AdminWidget::widget();?>
<?=SettingWidget::widget();?>
<?=PartnerOrdersWidget::widget();?>
```

Если необходимо связать данный модуль с модулем кошелька (komer45/yii2-balance), можно сделать подписку на событие. В конфиге модифицируем подключение partnership в разделе modules:
```php
 'partnership' => [
	...
			'on makePayment' => function($event){
				$model = $event->model;
				$userId = Yii::$app->Partnership->getUserByPartnerId($model->partner_id);
				$balance = Yii::$app->balance->getUserScore($userId);
				if ($balance){
					Yii::$app->balance->addTransaction($balance->id, 'in', $model->sum, 'partnership rewads');
				} else return false;
			}
  ],

``` 
Если модель подключаемого User не соответствует 'common\models\User' то ее необходимо задать в Модуле(Module.php) изменив переменную $userModule;