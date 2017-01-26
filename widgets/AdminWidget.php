<?php
namespace komer45\partnership\widgets;
use Yii;
use yii\helpers\Html;
use yii\helpers\Url;


class AdminWidget extends \yii\base\Widget
{
	public function init()
    {
        parent::init();
        return true;
    }
	
	
	public function run()
    {
		echo Html::a('Администрирование', Url::to(['/partnership/partner/admin']));
	}
}