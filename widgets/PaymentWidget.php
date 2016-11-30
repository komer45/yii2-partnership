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
		<form action='/partnership/payment'>
			<div class="form-group">
				<?=Html::submitButton('Payment', ['class' => 'btn btn-primary', 'data-href' => Url::toRoute(['/partnership/payment'])]);?>
			</div>
		</form>
	<?
	}
}