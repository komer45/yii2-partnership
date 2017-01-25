<?php

namespace komer45\partnership\controllers;

use Yii;
use komer45\partnership\models\Follow;
use komer45\partnership\models\Partner;
use komer45\partnership\models\SearchFollow;
use komer45\partnership\models\SearchPartner;
use common\models\User;
//use komer45\partnership\interfaces\User;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\data\Sort;
use yii\helpers\ArrayHelper;

/**
 * FollowController implements the CRUD actions for Follow model.
 */
class FollowController extends Controller
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
     * Lists all Follow models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new SearchFollow();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
		$partner = Partner::find()->where(['user_id' => Yii::$app->user->id])->one();
        $model = Follow::find()->where(['partner' => $partner->code])->all();
		
		return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
			'model' => $model
        ]);
    }
	
	
	public function actionReferals()
	{
		$partner = Partner::find()->where(['user_id' => Yii::$app->user->id])->one();
        $follows = Follow::find()->where(['partner' => $partner->code])->all();
		$users = User::find()->asArray()->all();

		return $this->render('index',[
			'follows' => $follows,
			'users' => $users
		]);
	}
	
	
    public function actionAdmin()
    {
		$searchModel = new SearchFollow();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
		$dataProvider->sort->defaultOrder = ['id' => SORT_DESC];
		
		
		return $this->render('admin', [
			'searchModel' => $searchModel,
			'dataProvider' => $dataProvider
			
		]);
	}
	
    /**
     * Displays a single Follow model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id, $pCode)	//id партнера, pCode партнера
    {
        $partnerSearchModel = new SearchFollow();
        $partnerDataProvider = $partnerSearchModel->search(Yii::$app->request->queryParams);
		$partnerDataProvider->query->andWhere(['partner' => $pCode]);
		//$partnerDataProvider->sort->defaultOrder = ['id' => SORT_DESC];
		
		$sortReferals = new Sort([
			'attributes' => [
				'user_id' => [
					'default' => SORT_DESC,
					'label' => 'Пользователь',
				],
			],	
		]);
		
		$sortStatus = new Sort([
			'attributes' => [
				'status' => [
					'default' => SORT_DESC,
					'label' => 'Статус',
				],
			],	
		]);
		
		$partnerId = Partner::find()->where(['user_id' => Yii::$app->user->id])->one()->code;
		$referals = Follow::find()->where(['partner' => $partnerId])->asArray()->all();
		$referalsIds = ArrayHelper::getColumn($referals, 'user_id');
		$referalsIds = array_unique($referalsIds);
		$userModel = Yii::$app->getModule('partnership')->userModel;
		$users = $userModel::find()->where(['id' => $referalsIds])->all();
		$partner = $this->findPartner($id);

        return $this->render('view', [
			'DataProvider' => $partnerDataProvider,
			'SearchModel' => $partnerSearchModel,
            'model' => $partner,
			'sortReferals' => $sortReferals,
			'sortStatus' => $sortStatus,
			'users' => $users
        ]);
    }

    /**
     * Creates a new Follow model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Follow();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Follow model.
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
     * Deletes an existing Follow model.
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
     * Finds the Follow model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Follow the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Follow::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
	
	protected function findPartner($id)
    {
        if (($model = Partner::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
	
	
	public function actionActivate($followId)	//для админа - активировать/деактивироваиь переход
    {
		$model = Follow::find()->where(['id' => $followId])->one();
		$model->status = 1;
		$model->update();
		return $this->redirect(Yii::$app->request->referrer);
	}
	
	public function actionDeactivate($followId)	//для админа - активировать/деактивироваиь переход
    {
		$model = Follow::find()->where(['id' => $followId])->one();
		$model->status = 0;
		$model->update();
		return $this->redirect(Yii::$app->request->referrer);
	}
		
}
