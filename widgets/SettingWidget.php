<?php
namespace komer45\partnership\widgets;
use Yii;
use yii\base\Widget;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\Modal;
use yii\widgets\ActiveForm;
use komer45\partnership\models\Setting;

class SettingWidget extends Widget
{
	public function init()
    {
        parent::init();
        return true;
    }
	
	
	public function run()
    {
		echo Html::a('Настройки', Url::to(['/partnership/setting/index']));
	}
}
?>