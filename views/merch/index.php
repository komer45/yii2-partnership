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

<?php /* Выведет количество товаров и сумму заказа */ ?>
<?= 'Товаров '.CartInformer::widget(['htmlTag' => 'a', 'offerUrl' => '/?r=cart', 'text' => '{c} на {p}']); ?>

<?php /* Выведет кнопку очистки корзины */ ?>
<?//= TruncateButton::widget(['text' => 'Очистить']); ?>
<?=ElementsList::widget(['type' => ElementsList::TYPE_DROPDOWN]);?>

<form action='merch/order' method='POST'>
	<div class="form-group">
		<?/*= Html::submitButton('Заказать', ['class' => 'btn btn-primary']) */?>
		<input type='submit' value='Заказать'>
	</div>
</form>
	
<?
//$merch = Merch::find()->all();
foreach ($merch as $product)
{
	$i++;
	//echo "<form id=formName $i>";
		echo 'Номер: '.$product->id.'<br>';
		echo 'Наименование: '.$product->name.'<br>';
		echo 'Цена: '.$product->price.'<br>';
		echo 'Кол-во: '.ChangeCount::widget(['model' => $product]);
		echo 'Коммент: '.$product->comment.'<br>';
		echo BuyButton::widget(['model' => $product, 'price' => $product->getCartPrice(),  'text' => 'В корзину']);
		
		?>
	<form action='/cart/element/create' method='POST'>
		<input type="hidden" name="<?= Yii::$app->request->csrfParam; ?>" value="<?= Yii::$app->request->csrfToken; ?>" />
		<input type='hidden' name='CartElement[model]' value='komer45\partnership\models\Merch'>
		<input type='hidden' name='CartElement[count]' value='1'>
		<input type='hidden' name='CartElement[price]' value='1111'>
		<input type='hidden' name='CartElement[item_id]' value='1'>
		
		<input type='hidden' name='elementsListWidgetParams[offerUrl]' value=''>
		<input type='hidden' name='elementsListWidgetParams[textButton]' value=''>
		<input type='hidden' name='elementsListWidgetParams[type]' value='dropdown'>
		<input type='hidden' name='elementsListWidgetParams[columns]' value=4>
		<input type='hidden' name='elementsListWidgetParams[model]' value=''>
		<input type='hidden' name='elementsListWidgetParams[showTotal]' value=false>
		<input type='hidden' name='elementsListWidgetParams[showOptions]' value=true>
		<input type='hidden' name='elementsListWidgetParams[showOffer]' value=false>
		<input type='hidden' name='elementsListWidgetParams[showTruncate]' value=false>
		<input type='hidden' name='elementsListWidgetParams[currency]' value=''>
		<input type='hidden' name='elementsListWidgetParams[currencyPosition]' value=''>
		<input type='hidden' name='elementsListWidgetParams[showCountArrows]' value=true>
		
		<input type='submit' name='buy' value='Положить'>
	</form>

		<?
		/*echo '<form action="#" method=POST>
				<input type=submit name="merch" value="В корзину" class="pistol88-cart-buy-button pistol88-cart-buy-button1 btn btn-success" data-id="1" data-count="1" data-price="1111" data-options="{}" data-description="" data-model="komer45\partnership\models\Merch">
			</form>';*/
		echo '<br>';
		/*echo BuyButton::widget(['model' => $product, 'text' => 'Заказать', 'htmlTag' => 'a', 'cssClass' => 'custom_class']);*/
	//echo '</form>';
}

//if (isset($_POST['merch'])){echo 'the Button is set!';}else echo 'try again';
$elements = yii::$app->cart->elements;

?>
<?php /* У ChangeOptions можно изменить вид ('type' => ChangeOptions::TYPE_RADIO) */ ?>
<?//=ChangeOptions::widget(['model' => $product]);?>

<?php
/*
Выведет корзину с выпадающими или обычными ('type' => ElementsList::TYPE_FULL) элементами списка.
Можно передать перечень дополнительных полей через otherFields (['Остаток' => 'amount']).
*/
?>


<?php /* Выведет кнопку удаления элемента */ ?>
<?//=DeleteButton::widget(['model' => $product]);?>