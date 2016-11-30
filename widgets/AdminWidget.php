<?
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
	?>
		<form action='/partnership/payment/admin'>
			<div class="form-group">
				<?=Html::submitButton('Admin', ['class' => 'btn btn-primary', 'data-href' => Url::toRoute(['/partnership/payment/admin'])]);?>
			</div>
		</form>
	<?
	}
}