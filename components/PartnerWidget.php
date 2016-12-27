<?php
namespace komer45\partnership\components;
use Yii;
use yii\base\Widget;
use yii\helpers\Html;
use yii\bootstrap\Modal;
use yii\widgets\ActiveForm;
use komer45\partnership\models\Partner;

class FormWidget extends Widget
{
    public $message;

    public function init()
    {
        parent::init();

		echo Partner::find()->where(['user_id' => Yii:$app->user->id])->one()->id;
		$partner = new Partner;
		$form =  ActiveForm::begin();
			echo $form->field($partner, 'code')->textInput();
			echo Html::submitButton($model->isNewRecord ? Yii::t('backend', 'Create') : Yii::t('backend', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']);
		ActiveForm::end();
		
    }

    public function run()
    {
        return Html::encode($this->message);
    }
}
?>