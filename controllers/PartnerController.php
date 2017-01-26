<?php

namespace komer45\partnership\controllers;

use Yii;
use yii\data\Sort;
//use common\models\User;
use komer45\partnership\models\Partner;
use komer45\partnership\models\SearchPartner;
use komer45\partnership\models\Payment;
use komer45\partnership\models\SearchPayment;
use komer45\partnership\models\OrderHistory;
use komer45\partnership\models\SearchOrderHistory;
use komer45\partnership\models\Follow;
use komer45\partnership\models\SearchFollow;
use pistol88\order\models\Order;
use pistol88\order\models\tools\OrderSearch;
use pistol88\order\models\Element;
use pistol88\order\models\tools\ElementSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\filters\AccessControl;
use yii\helpers\Url;
use yii\base\Security;

/**
 * PartnerController implements the CRUD actions for Partner model.
 */
class PartnerController extends Controller
{
    public function behaviors()
    {

        return [
		'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => $this->module->adminRoles,
                    ],
					[
						'actions' => ['become-partner'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
					[
						'actions' => ['referrer'],
                        'allow' => true,
                        'roles' => ['@', '?'],
                    ],
					
                ]
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
     * Lists all Partner models.
     * @return mixed
     */
    public function actionIndex()
    {
		$searchPartner = new SearchPartner();
        $partnerCode = $searchPartner->search(Yii::$app->request->queryParams);
		$partnerCode->query->andWhere(['user_id' => Yii::$app->user->id]);
		
		$partner = Partner::find()->where(['user_id' => Yii::$app->user->id])->one();

        $searchModel = new SearchFollow();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
		if($partner){
			$dataProvider->query->andWhere(['partner' => $partner->code]);
		}
		
		$sortStatus = new Sort([
			'attributes' => [
				'status' => [
					'default' => SORT_DESC,
					'label' => '������',
				],
			],	
		]);
		
		
		$referals = Follow::find()->where(['partner' => $partner])->asArray()->all();
		$referalsIds = ArrayHelper::getColumn($referals, 'user_id');
		$referalsIds = array_unique($referalsIds);
		
		$userModel = Yii::$app->getModule('partnership')->userModel;
		$users = $userModel::find()->where(['id' => $referalsIds])->all();
		
		$sortReferal = new Sort([
			'attributes' => [
				'user_id' => [
					'default' => SORT_DESC,
					'label' => '�������',
				],
			],	
		]);
		
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
			'sortStatus' => $sortStatus,
			'users' => $users,
			'sortReferal' => $sortReferal
        ]);
    }

	
	
	public function actionAdmin()		//��� ������ - ���������� ����������� ���������
    {
        $searchModel = new SearchPartner();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
		
		$sortStatus = new Sort([
			'attributes' => [
				'status' => [
					'default' => SORT_DESC,
					'label' => '������',
				],
			],	
		]);
		
		$sortUser = new Sort([
			'attributes' => [
				'user_id' => [
					'default' => SORT_DESC,
					'label' => '������������',
				],
			],	
		]);

		$userModel = Yii::$app->getModule('partnership')->userModel;
		$partnerId = Partner::find()->all();
		$referalsIds = ArrayHelper::getColumn($partnerId, 'user_id');
		$referalsIds = array_unique($referalsIds);
		$users = $userModel::find()->where(['id' => $referalsIds])->all();
		
        return $this->render('admin', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
			'sortStatus' => $sortStatus,
			'users' => $users,
			'sortUser' => $sortUser,
        ]);
    }
	
	
	
	public function actionActivate($statusTo, $partner)	//��� ������ - ������������/�������������� �������
    {
		$model = Partner::find()->where(['id' => $partner])->one();
		if ($statusTo == 0){
			$model->status = 0;
		}elseif ($statusTo == 1){
			$model->status = 1;
		}
		$model->update();
		return $this->redirect('admin');
	}
		
    /**
     * Displays a single Partner model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
		$paymentSearchModel = new SearchPayment();
        $paymentDataProvider = $paymentSearchModel->search(Yii::$app->request->queryParams);
		$paymentDataProvider->query->andWhere(['partner_id' => $id]);
		$paymentDataProvider->sort->defaultOrder = ['id' => SORT_DESC];
		
		if($dateStart = yii::$app->request->get('date_start')) {
            $paymentDataProvider->query->andWhere(['>=', 'date', date('Y-m-d', strtotime($dateStart))]);

        }

        if($dateStop = yii::$app->request->get('date_stop')) {
            $paymentDataProvider->query->andWhere(['<=', 'date', date('Y-m-d H:i:s', strtotime($dateStop) + 86399)]);
		}
		
		$orderHistorySearchModel = new SearchOrderHistory();
        $orderHistoryDataProvider = $orderHistorySearchModel->search(Yii::$app->request->queryParams);
		$orderHistoryDataProvider->query->andWhere(['partner_id' => $id]);
		$orderHistoryDataProvider->sort->defaultOrder = ['id' => SORT_DESC];
		
		$referals = OrderHistory::find()->where(['partner_id' => $id])->asArray()->all();
		$referalsIds = ArrayHelper::getColumn($referals, 'user_id');
		$referalsIds = array_unique($referalsIds);
		$userModel = Yii::$app->getModule('partnership')->userModel;
		$users = $userModel::find()->where(['id' => $referalsIds])->all();
		$orders = OrderHistory::find()->all();

		$sort = new Sort([
			'attributes' => [
				'user_id' => [
					'default' => SORT_DESC,
					'label' => '�������',
				],
			],	
		]);

		$sortStatus = new Sort([
			'attributes' => [
				'status' => [
					'default' => SORT_DESC,
					'label' => '������',
				],
			],	
		]);
		
				
		$sortOrder = new Sort([
			'attributes' => [
				'order_id' => [
					'default' => SORT_DESC,
					'label' => 'Id ������',
				],
			],	
		]);
		
		
        return $this->render('view', [
			'paymentDataProvider' => $paymentDataProvider,
			'profitDataProvider' => $orderHistoryDataProvider,
			'paymentSearchModel' => $paymentSearchModel,
			'profitSearchModel' => $orderHistorySearchModel,
            'model' => $this->findModel($id),
			'model2' => OrderHistory::find()->where(['partner_id' => $id])->all(),
			'users' => $users,
			'sort' => $sort,
			'sortStatus' => $sortStatus,
			'sortOrder' => $sortOrder,
			'orders' => $orders
        ]);
    }

    /**
     * Creates a new Partner model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Partner();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Partner model.
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
     * Deletes an existing Partner model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }
	
	public function actionMakePayment($paymentId)					//�� ������� �� ������ "��������� |��������|"
	{
		$pay = Yii::$app->Partnership->makePayment($paymentId);		//���������� � ������� makePayment($paymentId) � ������ Partnership.php
		return $this->redirect(Yii::$app->request->referrer);
	}

    /**
     * Finds the Partner model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Partner the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Partner::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
	
	public function actionBecomePartner($userId)
	{
		$model = Partner::find()->where(['user_id' => $userId])->one();
		if (!$model){
			$partner = new Partner();
			
			$partner->user_id = $userId;
			$code1 = (string)Yii::$app->user->identity->username;
			$code2 = (string)Yii::$app->user->id;
			$code3 = explode('.', round(microtime(), 6));
			$code3 = $code3[1].Yii::$app->user->id;
			$code = $code3;
			$partner->code = $code;

			if ($partner->validate())
			{
				$partner -> save();
			}
		}
		return $this->redirect(Yii::$app->request->referrer);
	}
	
	public function actionOrderView($orderId)
	{
		$order = Order::findOne($orderId);
		$orderElement = Element::find()->where(['order_id' => $orderId])->one();
		$partnerId = Partner::find()->where(['user_id' => Yii::$app->user->id])->one()->id;

		return $this->render('order', [
				'order' => $order,
				'orderElement' => $orderElement,
				'partnerId' => $partnerId
            ]);
	}
	
	public function getOrder($orderId)
    {
		$element = Order::find()->where(['order_id' => $orderId])->one();
        return $element->hasOne(Order::className(), ['id' => 'order_id']);
    }
	
	public function actionReferrer($code = null)
	{
		$request = Yii::$app->request;
		$urlTo = Url::current();								//���� ������� ������������ (�������� �� ���������)
		$userId = Yii::$app->user->id;							//�������� id �����
		$urlFrom = Yii::$app->request->referrer;				//��������� �� ���������� �������� $_SERVER['HTTP_REFERER'];
		Yii::$app->session['url_from'] = $urlFrom;						//���������� ������� � ������
		$ip =  $_SERVER["REMOTE_ADDR"];							//���������� ip �����
		if($code){
			$partner = Partner::find()->where(['code' => $code])->one();				//������� ��������
			if($partner){
				Yii::$app->session['code'] = $partner->code;						//������� ��� �������� � ������
			}
		}else {$partner = 0;}
		/*�������� ������ � coockie*/
		if (!isset(Yii::$app->request->cookies['tmp_user_id'])) {
			Yii::$app->response->cookies->add(new \yii\web\Cookie([
				'name' => 'tmp_user_id',
				'value' => md5($ip+microtime())
			]));
		} 
		/*�������� ������ � coockie*/		
		Yii::$app->Partnership->addFollow($userId, $urlFrom, $urlTo, $ip, $partner);
		return $this->redirect(Yii::$app->homeUrl);
	}
	
}
