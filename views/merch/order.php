<?php 

use yii\widgets\ActiveForm;
use yii\helpers\Html;
use komer45\partnership\models\Merch;
use pistol88\order\widgets\OrderForm;
use komer45\partnership\controllers\ProductController;
?>

<h3>Форма заказа:</h3>							<?//перенести в отдельную вьюху?>
<? echo OrderForm::widget(); ?>