<?
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
	?>
		<form action='/partnership/merch' method='POST'>
			<div class="form-group">
				<?=Html::submitButton('Order', ['class' => 'btn btn-primary', 'data-href' => Url::toRoute(['/partnership/merch'])]);?>
			</div>
		</form>
	<?
	}
}