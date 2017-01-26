<?php 
namespace komer45\partnership;

use Yii;
use komer45\partnership\models\Follow;
use komer45\partnership\models\Partner;
use komer45\partnership\models\Payment;
use komer45\partnership\models\OrderHistory;
use komer45\partnership\events\MakePaymentEvent;
//use yii\helpers\Url;

class Partnership extends \yii\base\Component
{	
	public function getFollows($userId)
	{
		$follow = Follow::find()->where(['user_id' => $userId])->all();
		return $follow;
	}

	public function addFollow($userId, $urlFrom, $urlTo, $ip, $partner)
	{
		
		$addFollow = new Follow;
		$tmp =	strval(Yii::$app->request->cookies['tmp_user_id']);
		$addFollow->ip = $ip;
		$addFollow->user_id = $userId;
		if ($userId == NULL)										
			$addFollow->tmp_user_id = $tmp;	
		else 
			$addFollow->tmp_user_id = NULL;
		$addFollow->url_to = $urlTo;
		$addFollow->partner = (Yii::$app->session['code']);
		$addFollow->date = date('Y-m-d');
		$addFollow->url_from = $urlFrom;
		$part = Partner::find()->where(['code' => Yii::$app->session['code']])->one();
		//$addFollow->status = 1;

		if ($part)		//записываем в Follow только тогда, когда уверены в том, что партнер записан в базе, а такого юзера еще нет 
		{
			if (!Yii::$app->user->isGuest)
				$followsarch = Follow::find()->where(['user_id' => $userId])->one();
			else
				$followsarch = Follow::find()->where(['ip' => $ip, 'tmp_user_id' => $tmp])->one();
				
				if(!$followsarch){ 								//записываем в базу только тогда, когда уверены, что нет совпадений (юзер не найден)
					if($addFollow->validate()){
						$addFollow->save();
						}//else echo 'no1!';
					}//else  echo 'Данный пользователь уже есть в системе!';	//выводим эхом
		}//else echo 'Такая запись уже есть в системе!';
	}
	
	public function makePayment($paymentId)						//из экшна actionMakePayment (PartnerController) переходим сюда
	{
		$paymentModel = Payment::findOne($paymentId);
		if($paymentModel) {
			$paymentModel->status = 1;
			$OrderHistory = OrderHistory::find()->where(['partner_id' => $paymentModel->partner_id])->andWhere(['status' => 'process'])->all();
			if ($paymentModel->save()){
				foreach($OrderHistory as $order)
				{
					$order->status = 'payed';
					$order->update();
				}
				$module = \Yii::$app->getModule('partnership');						//получаем модуль приложения partnership - module.php
				$paymentEvent = new MakePaymentEvent(['model' => $paymentModel]);	//создаем событие(event) и отсылаем в него paymentModel в качестве параметра 'Module' 
				$module->trigger($module::EVENT_MAKE_PAYMENT, $paymentEvent);		//в модуль приложения (module.php) ТРИГГЕРОМ
			}else {
				return false;
			}
		}

	}
	
	public function getUserByPartnerId($partnerId)
	{
		return Partner::findOne($partnerId)->user_id;
	}
}