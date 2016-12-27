<?
namespace komer45\partnership\widgets;
use Yii;
use yii\helpers\Html;
use yii\helpers\Url;


class PaymentWidget extends \yii\base\Widget
{
	public function init()
    {
        parent::init();
        return true;
    }
	
	
	public function run()
    {
	?>
		<?=Html::a('Мои отчисления', Url::to(['/partnership/payment']));?>
	<?
	}
}