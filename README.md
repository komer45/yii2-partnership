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
			'layout' => 'main'
		],
		//...
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
			//..
			$model = new \komer45\partnership\models\PsOrderHistory;
			$tmp =	strval(Yii::$app->request->cookies['tmp_user_id']);
			if (!Yii::$app->user->isGuest){				//сли пользователь зарегистрирован
				$model->user_id = Yii::$app->user->id;
				$follow = \komer45\partnership\models\PsFollow::find()->where(['user_id' => $model->user_id])->one();
				$part   = \komer45\partnership\models\PsFollow::find()->where(['user_id' => Yii::$app->user->id])->one();
			} else {									//иначе - если все-таки гость
				$model->tmp_user_id = $tmp;
				$follow = \komer45\partnership\models\PsFollow::find()->where(['tmp_user_id' => $model->tmp_user_id])->one();
				$part   = \komer45\partnership\models\PsFollow::find()->where(['tmp_user_id' => $tmp])->one();
			}		
			$partner = \komer45\partnership\models\PsPartner::find()->where(['code' => $part->partner_id])->one(); //находим партнера по коду
			$model->partner_id = $partner->id;
			$model->sum = $event->model->cost;
			$model->date = date('Y-m-d');
			$model->order_id = $event->model->id;
			$model->follow_id = strval($follow->id);	//сюда нужно записать id таблицы ps_follow
				$forperc = \komer45\partnership\models\PsSetting::find()->all();
				foreach ($forperc as $search)
				{
					if ($search->sum >= $model->sum)
					{
						$percent = (($model->sum)/100*$search->percent);
						break;
					}
				}
				$model->recoil = $percent;
				$model->status = 0;
			if ($model->validate())
			{
				$model->save();
			}
			//..
		},
		//..
]
```
Так жe для перевода пользователя из незарегистрированного в зарегистрированного в контроллере user (\common\models\user) необходимо дописать следующий код в методе afterSignup(array $profileData = []):

```php
<?php
...
use komer45\partnership\models\PsFollow;
...
public function afterSignup(array $profileData = [])
{
	$reFollow = PsFollow::find()->where(['tmp_user_id' => Yii::$app->request->cookies['tmp_user_id']])->one();
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
use komer45\partnership\widgets\OrderWidget;
use komer45\partnership\widgets\PaymentWidget;
use komer45\partnership\widgets\AdminWidget;
?>
<?=OrderWidget::widget();?>		//Виджет заказа
<?=PaymentWidget::widget();?>	//Виджет выплат (партнер - оставить заявку на выплату)
<?=AdminWidget::widget();?>		//Виджет выплат (администратор - выплаты по заявкам)
```