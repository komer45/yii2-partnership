<?php
namespace komer45\partnership\widgets;
use Yii;
use yii\base\Widget;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\Modal;
use yii\widgets\ActiveForm;
use komer45\partnership\models\Partner;

class PartnerWidget extends Widget
{
    public $message;

    public function init()
    {
			$userId = Yii::$app->user->id;
			$partner = Partner::find()->where(['user_id' => $userId])->one();

			if(!$partner){		
				echo  Html::a('Стать Партнером', Url::to(['/partnership/partner/become-partner', 'userId' => $userId]), ['class' => 'btn btn-default']);
			}elseif($partner->status == 0) {
				echo "Ваша заявка на рассмотрении";
			}else {
				echo 'Ваша реф-ссылка: '.Yii::$app->request->hostInfo.'/partnership/partner/referrer?code='.$partner->code;
			}
	}

    public function run()
    {
        return Html::encode($this->message);
    }
}
?>