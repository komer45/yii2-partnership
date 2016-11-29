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
?>

<?php /* Выведет количество товаров и сумму заказа */ ?>
<?= 'Товаров '.CartInformer::widget(['htmlTag' => 'a', 'offerUrl' => '/?r=cart', 'text' => '{c} на {p}']); ?>

<?php /* Выведет кнопку очистки корзины */ ?>
<?//= TruncateButton::widget(['text' => 'Очистить']); ?>
<?=ElementsList::widget(['type' => ElementsList::TYPE_DROPDOWN]);?>

<form action='merch/order' method='POST'>
	<div class="form-group">
		<?= Html::submitButton('Заказать', ['class' => 'btn btn-primary']) ?>
	</div>
</form>
	
<?
//$merch = Merch::find()->all();
foreach ($merch as $product)
{
	echo 'Номер: '.$product->id.'<br>';
	echo 'Наименование: '.$product->name.'<br>';
	echo 'Цена: '.$product->price.'<br>';
	echo 'Кол-во: '.ChangeCount::widget(['model' => $product]);
	echo 'Коммент: '.$product->comment.'<br>';
	echo BuyButton::widget(['model' => $product, 'price' => $product->getCartPrice(),  'text' => 'В корзину']);
	echo '<br>';
	/*echo BuyButton::widget(['model' => $product, 'text' => 'Заказать', 'htmlTag' => 'a', 'cssClass' => 'custom_class']);*/
}
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