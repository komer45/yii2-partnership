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
	}
}