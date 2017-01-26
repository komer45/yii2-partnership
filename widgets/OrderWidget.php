<?php
namespace komer45\partnership\widgets;
use Yii;
use yii\helpers\Html;
use yii\helpers\Url;


class OrderWidget extends \yii\base\Widget
{
	public function init()
    {
        parent::init();
        return true;
    }
	
	
	public function run()
    {
		echo Html::a('Магазин', Url::to(['/partnership/merch']));
	}
}