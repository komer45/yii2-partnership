<?php
namespace komer45\partnership\widgets;
use Yii;
use yii\helpers\Html;
use yii\helpers\Url;


class PartnerOrdersWidget extends \yii\base\Widget
{
	public function init()
    {
        parent::init();
        return true;
    }
	
	
	public function run()
    {
		echo Html::a('Мои отчисления', Url::to(['/partnership/payment']));
		echo ' ';
		echo Html::a('Мои рефералы', Url::to(['/partnership/partner']));
	}
}