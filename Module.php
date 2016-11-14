<?php
namespace komer45\partnership;

use Yii;
use yii\web\Session;
use pistol88\order\events\OrderEvent;
use komer45\partnership\models\PsFollow;
use komer45\partnership\models\PsSetting;
use komer45\partnership\models\PsPartner;
use komer45\partnership\models\PsOrderHistory;

class Module extends \yii\base\Module
{
//public $layoutPath = 'C:\OpenServer\domains\yii2-starter-kit\common\modules\komer45\yii2-partnership\views\layouts';
	public function onOrderCreate(OrderEvent $event)
	{
		$model = new PsOrderHistory;
		$order = $event->model;
		$tmp =	strval(Yii::$app->request->cookies['tmp_user_id']);
		if (!Yii::$app->user->isGuest){				//сли пользователь зарегистрирован
			$model->user_id = Yii::$app->user->id;
			$follow = PsFollow::find()->where(['user_id' => $model->user_id])->one();
			$part = PsFollow::find()->where(['user_id' => Yii::$app->user->id])->one();
			//$model->partner_id = $partner->partner_id;
			//echo 'registered: '.$model->user_id.', followId: '.$follow->id;

			

		} else {									//иначе - если все-таки гость
			$model->tmp_user_id = $tmp;
			$follow = PsFollow::find()->where(['tmp_user_id' => $model->tmp_user_id])->one();
			$part = PsFollow::find()->where(['tmp_user_id' => $tmp])->one();

			//echo 'unregistered '.$model->tmp_user_id.', followId: '.$follow->id;
		}
		$partner = PsPartner::find()->where(['code' => $part->partner_id])->one();		//находим партнера по коду
		$model->partner_id = $partner->id;
		$model->sum = $order->cost;
		$model->date = date('Y-m-d');
		$model->order_id = $event->model->id;
		$model->follow_id = strval($follow->id);	//сюда нужно записать id таблицы ps_follow

			$forperc = PsSetting::find()->all();
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
			echo '<script type="text/javascript">window.location.href="//yii2-starter-kit"; </script>';
		} //else echo 'валидацию PsOrderHistory не прошла!';
		//echo 'наш код: '.$_SESSION['code'].', ';
	}
}