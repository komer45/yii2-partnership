<?php
namespace komer45\partnership;

use Yii;
use yii\web\Session;
use pistol88\order\events\OrderEvent;
use komer45\partnership\models\Follow;
use komer45\partnership\models\Setting;
use komer45\partnership\models\Partner;
use komer45\partnership\models\OrderHistory;

class Module extends \yii\base\Module
{
	const EVENT_MAKE_PAYMENT = 'makePayment';
	
	public $adminRoles = ['admin'];
	
//public $layoutPath = 'C:\OpenServer\domains\yii2-starter-kit\common\modules\komer45\yii2-partnership\views\layouts';
	public function onOrderCreate(OrderEvent $event)
	{
	
		$model = new OrderHistory;
		$order = $event->model;
		$tmp =	strval(Yii::$app->request->cookies['tmp_user_id']);
		if (!Yii::$app->user->isGuest){				//если пользователь зарегистрирован
			$model->user_id = Yii::$app->user->id;
			$follow = Follow::find()->where(['user_id' => $model->user_id])->one();
			$part = Follow::find()->where(['user_id' => Yii::$app->user->id])->one();
			//$model->partner_id = $partner->partner_id;
			//echo 'registered: '.$model->user_id.', followId: '.$follow->id;

			

		} else {									//иначе - если все-таки гость
			$model->tmp_user_id = $tmp;
			$follow = Follow::find()->where(['tmp_user_id' => $model->tmp_user_id])->one();
			$part = Follow::find()->where(['tmp_user_id' => $tmp])->one();

			//echo 'unregistered '.$model->tmp_user_id.', followId: '.$follow->id;
		}
		$partner = Partner::find()->where(['code' => $part->partner])->one();		//находим партнера по коду
		$model->partner_id = $partner->id;
		$model->sum = $order->cost;
		$model->date = date('Y-m-d');
		$model->order_id = $event->model->id;
		$model->follow_id = strval($follow->id);	//сюда нужно записать id таблицы _follow
			$forperc = Setting::find()->orderBy(['id' => SORT_DESC])->all();

			foreach ($forperc as $search)
			{
				if ($model->sum >= $search->sum)
				{
					$percent = (($model->sum)/100*($search->percent));

						$cookies = Yii::$app->response->cookies;
						
						$cookies->add(new \yii\web\Cookie([
							'name' => 'recoil',
							'value' => $percent,
						]));
						//echo 'Сумма отчислений: '.$cookies['recoil'].', ';		//Сумма отчислений
						
						$cookies->add(new \yii\web\Cookie([
							'name' => 'sumOrder',
							'value' => $model->sum,
						]));
						//echo 'Сумма заказа: '.$cookies['sumOrder'].', ';
						
						$cookies->add(new \yii\web\Cookie([
							'name' => 'sumSearch',
							'value' => $search->sum,
						]));
						//echo 'Поискоая сумма: '.$cookies['sumSearch'].'.';
						
						$cookies->add(new \yii\web\Cookie([
							'name' => 'percent',
							'value' => $search->percent,
						]));
						//echo 'Поискоая сумма: '.$cookies['percent'].'.';
						
						/*$session = Yii::$app->session;
						$session['recoil'] = $cookies['recoil'];
						$session['sumOrder'] = $cookies['sumOrder'];
						$session['sumSearch'] = $cookies['sumSearch'];
						$session['percent'] = $cookies['percent'];*/
						
					break;
				}
			}
			$model->recoil = $percent;
		
		if ($model->validate())
		{
			$model->save();
			echo "<script type='text/javascript'>window.location.href='//yii2-starter-kit/partnership/merch/thnks'; </script>";
		} //else echo 'валидацию OrderHistory не прошла!';
		//echo 'наш код: '.$_SESSION['code'].', ';
	}
}