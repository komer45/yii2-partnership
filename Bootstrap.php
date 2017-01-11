<?php
namespace komer45\partnership;

use Yii;
use komer45\partnership\models\Follow;
use komer45\partnership\models\Partner;
use yii\helpers\Url;
use yii\caching\Cache;
use yii\base\BootstrapInterface;

class Bootstrap implements BootstrapInterface
{
    public function bootstrap($app)	//$app - сервис локатор
    {		
        if(!$app->has('Partnership')) {
            $app->set('Partnership', ['class' => '\komer45\partnership\Partnership']);
        }
		$app->on('beforeAction', function() use ($app)
		{
			$request = Yii::$app->request;
			$refTo = Url::current();								//сюда перешел пользователь (страниця по пересылке)
			$userId = Yii::$app->user->id;							//получаем id юзера
			$refFrom = Yii::$app->request->referrer;				//ссылаемся на предыдущую страницу $_SERVER['HTTP_REFERER'];
			Yii::$app->session['url_from'] = $refFrom;						//записываем переход в сессию
			$ip =  $_SERVER["REMOTE_ADDR"];							//определяем ip юзера
			if(isset($_GET['code'])){
				$partnercode = Partner::find()->where(['code' => $_GET['code']])->one();			//находим партнера
				Yii::$app->session['code'] = $partnercode->code;						//запишем код партнера в сессию
			}else {$partnercode = 0;}
			/*проведем работу с coockie*/
			if (!isset(Yii::$app->request->cookies['tmp_user_id'])) {
				Yii::$app->response->cookies->add(new \yii\web\Cookie([
					'name' => 'tmp_user_id',
					'value' => md5($ip+microtime())
				]));
			} 
			/*закончим работу с coockie*/		
			$app->Partnership->addFollow($userId, $refFrom, $refTo, $ip, $partnercode);
		});
	}
}