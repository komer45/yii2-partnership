<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model komer45\partnership\models\Setting */

$this->title = 'Изменить: ' . ' ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Вознаграждения', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Изменить';
?>
<div class="setting-update">

    <?php echo $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
