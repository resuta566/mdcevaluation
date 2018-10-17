<?php

namespace app\controllers;

use Yii;
use yii\base\Model;
use app\models\Evaluation;
use app\models\EvaluationItem;
use app\models\EvaluationSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\models\User;
use yii\filters\AccessControl;
use app\components\AccessRule;

/**
 * EvaluationController implements the CRUD actions for Evaluation model.
 */
class EvaluationController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'ruleConfig' => [
                    'class' => AccessRule::className(),
                ],
                'only' => ['index','view','evaluate'],
                'rules'=>[
                    [
                        'actions'=>['login'],
                        'allow' => true,
                        'roles' => ['@']
                    ],
                    [
                        'actions' => ['evaluate'],
                        'allow' => true,
                        'roles' => [User::ROLE_STUDENT]
                    ],
                    [
                        'actions' => ['evaluate'],
                        'allow' => true,
                        'roles' => [User::ROLE_TEACHER]
                    ],
                    [
                        'actions' => ['evaluate'],
                        'allow' => true,
                        'roles' => [User::ROLE_HEAD]
                    ],
                    [
                        'actions' => ['index','view','evaluate'],
                        'allow' => true,
                        'roles' => [User::ROLE_ADMIN]
                    ]
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Evaluation models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new EvaluationSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Evaluation model.
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
     * Creates a new Evaluation model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Evaluation();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Evaluation model.
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
     * This will show the Items and give the Evaluator to score the Evaluatee.
     * If the giving of score is sucessfull this will redirect to their Dashboard.
     */
    public function actionEvaluate($id)
    {
        $model = $this->findModel($id);
        $evalItems = EvaluationItem::find()->where(['evaluation_id' => $model->id])->all();

        if (!isset($evalItems)) {
            throw new NotFoundHttpException("The item was not found.");
        }
        if (Model::loadMultiple( $evalItems, Yii::$app->request->post()) && Model::validateMultiple($evalItems)) {
          
                foreach($evalItems as $evalItem => $eItem)
                {
                    // $eItem->scenario = 'update';

                    if (!($flag = $eItem->save(false))) {
                        break;
                    }

                    $eItem->save();

                }

                return $this->redirect(['/']);
            
        }

        
        

        return $this->render('evaluate', [
            'model' => $model,
            'evalItems' => $evalItems,
        ]);
    }

    /**
     * Deletes an existing Evaluation model.
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
     * Finds the Evaluation model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Evaluation the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Evaluation::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
