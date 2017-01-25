<?php 

use yii\widgets\ActiveForm;
use yii\helpers\Html;
use komer45\partnership\models\Merch;
use pistol88\order\widgets\OrderForm;
use komer45\partnership\controllers\ProductController;

?>

<h3>Форма заказа:</h3>
<div id="orderForm">
	<?php echo OrderForm::widget(); ?>
</div>