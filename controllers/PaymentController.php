<?php

namespace komer45\partnership\controllers;

use Yii;
use komer45\partnership\models\PsPayment;
use komer45\partnership\models\PsPartner;
use komer45\partnership\models\PsOrderHistory;
use komer45\partnership\models\SearchPayment;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * PaymentController implements the CRUD actions for PsPayment model.
 */
class PaymentController extends Controller
{
    public function behaviors()
    {
        return [
			'access' => [
				'class' => \yii\filters\AccessControl::className(),
				'only' => ['index', 'order'],
				'rules' => [
                    [
                        'allow' => true,	//true - Указанная роль имеет доступ к указанной странице; false - Указанная роль не имеет доступ к указанной странице.
                        'roles' => ['@'],	//РОЛИ(-Ъ), которые имеют доступ к странице
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ];
    }

    /**
     * Lists all PsPayment models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new SearchPayment();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

	public function actionDone()
	 {
		//$model = PsPayment::find()->one();
		return $this->render('done');
	 }
	
    /**
     * Displays a single PsPayment model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new PsPayment model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
		$recoils = $_POST["recoils"];
		$hello = PsOrderHistory::find()->where(['partner_id' => Yii::$app->user->id, 'status' => 0])->all();
		foreach ($hello as $privet)
		{
			$privet->status = 1;
			$privet->update();
		}
		$pay= NEW PsPayment;
		$pay->sum = $recoils;
		$pay->partner_id = PsPartner::find()->where(['partner_id' => Yii::$app->user->id])->one()->id;
		$pay->date = date('Y-m-d');
		$pay->save();
		
		return $this->redirect('/partnership/payment/index?payment=payed');
    }

    /**
     * Updates an existing PsPayment model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing PsPayment model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the PsPayment model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return PsPayment the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = PsPayment::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
