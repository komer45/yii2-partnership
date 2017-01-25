<?php

namespace komer45\partnership\controllers;

use Yii;

/**
 * OrderHistoryController implements the CRUD actions for OrderHistory model.
 */
class DefaultController extends \yii\web\Controller
{
    /**
     * Lists all OrderHistory models.
     * @return mixed
     */
    public function actionIndex()
    {
        return $this->render('index');
    }

}
