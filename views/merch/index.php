<?php 

use yii\widgets\ActiveForm;
use yii\helpers\Html;
use komer45\partnership\models\Merch;
use pistol88\order\widgets\OrderForm;
use komer45\partnership\controllers\ProductController;
use yii\bootstrap\Button;
//Подключим виджеты
use pistol88\cart\widgets\BuyButton;
use pistol88\cart\widgets\TruncateButton;
use pistol88\cart\widgets\CartInformer;
use pistol88\cart\widgets\ElementsList;
use pistol88\cart\widgets\DeleteButton;
use pistol88\cart\widgets\ChangeCount;
use pistol88\cart\widgets\ChangeOptions;

use yii\helpers\Url;
?>


<?= 'Товаров '.CartInformer::widget(['htmlTag' => 'a', 'offerUrl' => '/?r=cart', 'text' => '{c} на {p}']); ?>

<?=ElementsList::widget(['type' => ElementsList::TYPE_DROPDOWN]);?>

<form action='merch/order' method='POST'>
	<div class="form-group">
	<?php echo Html :: hiddenInput(\Yii :: $app->getRequest()->csrfParam, \Yii :: $app->getRequest()->getCsrfToken(), []); ?>
		<?/*= Html::submitButton('Заказать', ['class' => 'btn btn-primary']) */?>
		<input type='submit' value='Заказать'>
	</div>
</form>
	
<?php
foreach ($merch as $product){
	echo 'Номер: '.$product->id.'<br>';
	echo 'Наименование: '.$product->name.'<br>';
	echo 'Цена: '.$product->price.'<br>';
	echo 'Кол-во: '.ChangeCount::widget(['model' => $product]);
	echo 'Коммент: '.$product->comment.'<br>';
	echo BuyButton::widget(['model' => $product, 'price' => $product->getCartPrice(),  'text' => 'В корзину']);
}

$elements = yii::$app->cart->elements;

?>
