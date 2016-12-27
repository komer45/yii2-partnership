<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model komer45\partnership\models\Setting */

$this->title = 'Создать';
$this->params['breadcrumbs'][] = ['label' => 'Вознаграждения', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="setting-create">

    <?php echo $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
