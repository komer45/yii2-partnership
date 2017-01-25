<?php

namespace komer45\partnership\controllers;

use Yii;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
/**
 * OrderHistoryController implements the CRUD actions for OrderHistory model.
 */
class DefaultController extends \yii\web\Controller
{
	public function behaviors()
    {
        return [
            'access' => [
                //'class' => AccessControl::className(),
				'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => $this->module->adminRoles,
                    ],
                ]
            ],
        ];
    }
    /**
     * Lists all OrderHistory models.
     * @return mixed
     */
    public function actionIndex()
    {
        return $this->render('index');
    }

}
