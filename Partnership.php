<?php 

namespace komer45\partnership;

use Yii;
use komer45\partnership\models\PsFollow;
use komer45\partnership\models\PsPartner;
//use yii\helpers\Url;

class Partnership extends \yii\base\Component
{	
	public function getFollow($user)
	{
		$follow = PsFollow::find()->where(['user_id' => $user])->all();
		return $follow;
	}

	public function addFollow($user_id, $url_from, $url_to, $ip, $partner)
	{
		$addFollow = new PsFollow;
		$tmp =	strval(Yii::$app->request->cookies['tmp_user_id']);
		$addFollow->ip = $ip;
		$addFollow->user_id = $user_id;
		if ($user_id == NULL)										
			$addFollow->tmp_user_id = $tmp;	
		else 
			$addFollow->tmp_user_id = NULL;
		$addFollow->url_to = $url_to;
		$addFollow->partner_id = $_SESSION['code'];
		$addFollow->date = date('Y-m-d');
		$addFollow->url_from = $url_from;
		$part = psPartner::find()->where(['code' => $_SESSION['code']])->one();
		if ($part)		//записываем в psFollow только тогда, когда уверены в том, что партнер записан в базе, а такого юзера еще нет 
		{	
			if (!Yii::$app->user->isGuest)
				$followsarch = psFollow::find()->where(['user_id' => $user_id])->one();
			else
				$followsarch = psFollow::find()->where(['ip' => $ip, 'tmp_user_id' => $tmp])->one();
				if(!$followsarch){ 								//записываем в базу только тогда, когда уверены, что нет совпадений (юзер не найден)
					if($addFollow->validate()){
						$addFollow->save();
						}
					}	//else  echo 'Данный пользователь уже есть в системе!';	//выводим эхом
		} //else echo 'Такая запись уже есть в системе!';
	}
}