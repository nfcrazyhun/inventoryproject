<?php

namespace app\controllers;

use app\models\Category;
use app\models\History;
use Yii;
use app\models\Workpiece;
use app\models\search\WorkpieceSearch;
use yii\base\DynamicModel;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii2mod\collection\Collection;

/**
 * WorkpieceController implements the CRUD actions for Workpiece model.
 */
class WorkpieceController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],

            //set access only for authenticated users
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['index','view','create','update','delete','deposit','withdraw'],
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['index','view','create','update','delete','deposit','withdraw'],
                        'roles' => ['@'],
                    ],
                ],
            ],

        ];
    }

    /**
     * Lists all Workpiece models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new WorkpieceSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Workpiece model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Workpiece model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Workpiece();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Workpiece model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Workpiece model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Workpiece model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Workpiece the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Workpiece::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }


    /**
     * Increase stock for a selected Workpiece, and create a history from the changes,
     * @param $id
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException
     * @throws \yii\base\InvalidConfigException
     */
    public function actionDeposit($id)
    {
        $model = $this->findModel($id);
        $request = Yii::$app->request;
        $quantity = $request->getBodyParam('quantity');
        $remark = $request->getBodyParam('remark');
        $validator = null;


        //if received a POST request
        if ($request->isPost) {

            //ad hoc validator
            $validator = DynamicModel::validateData(
                ['quantity' => $quantity, 'remark' => $remark],
                [   //rules
                    [['quantity'], 'required'],
                    [['quantity'], 'integer'],
                    [['quantity'], 'compare', 'compareValue' => 0, 'operator' => '>'], // must be gt: than zero
                    [['remark'], 'required']
                ]
            );


            // if validation succeed (no errors)
            if (!$validator->hasErrors()) {

                $model->in_stock += $quantity; //add quantity to stock

                //-- create history --
                $history = new History();
                $history->workpiece_id = $model->id;
                $history->quantity = $quantity;
                $history->remark = $remark;
                //----------

                if ($model->save() && $history->save()) {
                    \Yii::$app->getSession()->setFlash('success', 'Deposit saved successful!');
                    return $this->redirect(['view', 'id' => $model->id]);
                }
            }
        }

        //default
        return $this->render('deposit', [
            'model' => $model,
            'validator' => $validator,
        ]);
    }

    /**
     * Shows a view where you can decrease a workpiece's stock
     * @param $id
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException
     * @throws \yii\base\InvalidConfigException
     */
    public function actionWithdraw($id)
    {
        $model = $this->findModel($id);
        $request = Yii::$app->request;
        $quantity = $request->getBodyParam('quantity');
        $remark = $request->getBodyParam('remark');
        $validator = null;


        //if received a POST request
        if ($request->isPost) {

            //ad hoc validator
            $validator = DynamicModel::validateData(
                ['quantity' => $quantity, 'remark' => $remark],
                [   //rules
                    [['quantity'], 'required'],
                    [['quantity'], 'integer'],
                    [['quantity'], 'compare', 'compareValue' => 0, 'operator' => '>'], // must be gt: than zero
                    [['quantity'], 'compare', 'compareValue' => $model->in_stock, 'operator' => '<='], // must be lte: then current stock
                    [['remark'], 'required']
                ]
            );


            // if validation succeed (no errors)
            if (!$validator->hasErrors()) {
                $quantity = (-1)*$quantity; //inverse value
                $model->in_stock += $quantity; //add quantity to stock

                //-- create history --
                $history = new History();
                $history->workpiece_id = $model->id;
                $history->quantity = $quantity;
                $history->remark = $remark;
                //----------

                if ($model->save() && $history->save()) {
                    \Yii::$app->getSession()->setFlash('success', 'Withdraw saved successful!');
                    return $this->redirect(['view', 'id' => $model->id]);
                }
            }
        }

        //default
        return $this->render('withdraw', [
            'model' => $model,
            'validator' => $validator,
        ]);


    }
}
