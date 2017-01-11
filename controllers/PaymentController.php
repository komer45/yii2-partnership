<?php

namespace komer45\partnership\controllers;

use Yii;
use komer45\partnership\models\Payment;
use komer45\partnership\models\Partner;
use komer45\partnership\models\OrderHistory;
use komer45\partnership\models\SearchPayment;
use komer45\partnership\models\SearchOrderHistory;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;
use yii\data\Sort;

/**
 * PaymentController implements the CRUD actions for Payment model.
 */
class PaymentController extends Controller
{
    public function behaviors()
    {
        return [
            	'access' => [
				'class' => AccessControl::className(),
				'only' => ['index'],
				'rules' => [
                    [
                        'allow' => true,	//true - Указанная роль имеет доступ к указанной странице; false - Указанная роль не имеет доступ к указанной странице.
                        'roles' => ['@'],	//РОЛИ(-Ъ), которые имеют доступ к странице
                    ],
                ],
            ],
        ];
    }

    /**
     * Lists all Payment models.
     * @return mixed
     */
    public function actionIndex()
    {
		$partnerModel = $this->findPartner(Yii::$app->user->id);
		
        $paymentSearchModel = new SearchPayment();
        $paymentDataProvider = $paymentSearchModel->search(Yii::$app->request->queryParams);
		$paymentDataProvider->query->andWhere(['partner_id' => $partnerModel->id]);
		
        $orderHistorySearchModel = new SearchOrderHistory();
        $orderHistoryDataProvider = $orderHistorySearchModel->search(Yii::$app->request->queryParams);
		$orderHistoryDataProvider->query->andWhere(['partner_id' => $partnerModel->id]);
		
		$partnerRecoils = OrderHistory::find()->where(['partner_id' => $partnerModel->id, 'status' => 'new'])->sum('recoil');
		if(!$partnerRecoils){
			$partnerRecoils = 0;
		}
		
		if($dateStart = yii::$app->request->get('date_start')) {
            $orderHistoryDataProvider->query->andWhere(['>=', 'date', date('Y-m-d', strtotime($dateStart))]);

        }

        if($dateStop = yii::$app->request->get('date_stop')) {
            $orderHistoryDataProvider->query->andWhere(['<=', 'date', date('Y-m-d H:i:s', strtotime($dateStop) + 86399)]);
		}

		$sort = new Sort([
			'attributes' => [
				'status' => [
					'default' => SORT_DESC,
					'label' => 'Статус',
				],
			],	
		]);
		
        return $this->render('index', [
            'paymentSearchModel' => $paymentSearchModel,
            'paymentDataProvider' => $paymentDataProvider,
			'orderHistorySearchModel' => $orderHistorySearchModel,
            'orderHistoryDataProvider' => $orderHistoryDataProvider,
			'partnerModel' => $partnerModel,
			'partnerRecoils' => $partnerRecoils,
			'sort' => $sort,
        ]);
    }
	
    /**
     * Displays a single Payment model.
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
     * Creates a new Payment model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
	 

	public function actionPaymentRequest($recoils)		//для партнера - заявка на выплату
    {
		$partnerId = Partner::find()->where(['user_id' => Yii::$app->user->id])->one()->id;
		$hello = OrderHistory::find()->where(['partner_id' => $partnerId, 'status' => 'new'])->all();
		
		foreach ($hello as $privet)
		{
			$privet->status = 'process';
			$privet->update();
		}
		
		$pay= NEW Payment;
		$pay->sum = $recoils;
		$pay->partner_id = $partnerId;
		$pay->date = date('Y-m-d');
		$pay->save();
		return $this->redirect(Yii::$app->request->referrer);
	}

    /**
     * Updates an existing Payment model.
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
     * Deletes an existing Payment model.
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
     * Finds the Payment model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Payment the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Payment::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
	
	protected function findPartner($id)
    {
        if (($model = Partner::find()->where(['user_id' => $id])->one()) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
