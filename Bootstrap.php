<?php
namespace komer45\partnership;
//setcookie("TestCookie", $value);		//задаем куку

use Yii;
use komer45\partnership\models\PsFollow;
use komer45\partnership\models\PsPartner;
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
			Yii::$app->params['min'] = 300;
			$request = Yii::$app->request;
			$ref_to = Url::current();								//сюда перешел пользователь (страниця по пересылке)
			$user_id = Yii::$app->user->id;							//получаем id юзера
			$ref_from = Yii::$app->request->referrer;				//ссылаемся на предыдущую страницу $_SERVER['HTTP_REFERER'];
			$_SESSION['url_from'] = $ref_from;						//записываем переход в сессию 
			$ip =  $_SERVER["REMOTE_ADDR"];							//определяем ip юзера
			$partnercode = PsPartner::find()->where(['code' => $_GET['code']])->one();			//находим партнера
			$_SESSION['code'] = $partnercode->code;						//запишем код партнера в сессию
			$fortmp = $ip+microtime();								//дадим незарегистрированному юзеру определитель - свяжем его ip с микровременем
			$cache = md5($fortmp);
			/*проведем работу с coockie*/
			if (!isset(Yii::$app->request->cookies['tmp_user_id'])) {
				Yii::$app->response->cookies->add(new \yii\web\Cookie([
					'name' => 'tmp_user_id',
					'value' => $cache
				]));
			} 
			/*закончим работу с coockie*/		
			
			$app->Partnership->addFollow($user_id, $ref_from, $ref_to, $ip, $partnercode);
		});
	}
}