<?php

use yii\helpers\Html;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\modules\komer45\partnership\models\search\Setting */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Вознаграждения';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="setting-index">

    <p>
        <?php echo Html::a('Добавить', ['create'], ['class' => 'btn btn-success']) ?>
    </p>


    <?php echo GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            //'id' ,
            'sum',
            'percent',

            ['class' => 'yii\grid\ActionColumn', 'template' => '{update} {delete}',  'buttonOptions' => ['class' => 'btn btn-default'], 'options' => ['style' => 'width: 65px;']]
        ],
    ]); ?>

</div>
