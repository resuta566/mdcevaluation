<?php

namespace app\controllers;

use Yii;
use app\models\Classes;
use app\models\ClassesSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\models\StudentClass;
use app\models\StudentClassSearchS;
use app\models\User;
use yii\filters\AccessControl;
use app\components\AccessRule;

/**
 * ClassesController implements the CRUD actions for Classes model.
 */
class ClassesController extends Controller
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
                        'actions' => ['view'],
                        'allow' => true,
                        'roles' => [User::ROLE_HEAD]
                    ],
                    [
                        'actions' => ['view'],
                        'allow' => true,
                        'roles' => [User::ROLE_TEACHER]
                    ],
                    [
                        'actions' => ['index','view'],
                        'allow' => true,
                        'roles' => [User::ROLE_ADMIN]
                    ],
                    [
                        'actions' => ['index','view'],
                        'allow' => true,
                        'roles' => [User::ROLE_GUIDANCE]
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
     * Lists all Classes models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ClassesSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Classes model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {

        $searchModel = new StudentClassSearchS();
        $dataProvider = $searchModel->search($id);
        $model = Classes::findOne($id);
        $sclasses = StudentClass::find()->where(['class_id'=>$id])->one();
        if(Yii::$app->user->identity->role == User::ROLE_TEACHER){
            if(Yii::$app->user->identity->teacher->id == $model->teacher->id){
                return $this->render('view', [
                    'model'=> $model,
                    'sclasses'=> $sclasses,
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
                ]);
            }
            
        }elseif(Yii::$app->user->identity->role == User::ROLE_ADMIN){
            return $this->render('view', [
                'model'=> $model,
                'sclasses'=> $sclasses,
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
            ]);
        }elseif(Yii::$app->user->identity->role == User::ROLE_HEAD){
            if(Yii::$app->user->identity->department == 4){
                if($model->teacher->user->department == 3 || $model->teacher->user->department == 4){
                    return $this->render('view', [
                        'model'=> $model,
                        'sclasses'=> $sclasses,
                        'searchModel' => $searchModel,
                        'dataProvider' => $dataProvider,
                    ]);  
                }
            }elseif(Yii::$app->user->identity->department == 7){
                if($model->teacher->user->department == 7 || $model->teacher->user->department == 8){
                    return $this->render('view', [
                        'model'=> $model,
                        'sclasses'=> $sclasses,
                        'searchModel' => $searchModel,
                        'dataProvider' => $dataProvider,
                    ]);  
                }
            }elseif(Yii::$app->user->identity->department == $model->teacher->user->department){
                return $this->render('view', [
                    'model'=> $model,
                    'sclasses'=> $sclasses,
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
                ]); 
            }
            throw new \yii\web\HttpException(401, 'You are Forbidden to view this teacher.');
        }
        throw new \yii\web\HttpException(401, 'You are Forbidden to view this teacher.');
       
    }

    public function actionEvaluate($id)
    {

        $searchModel = new StudentClassSearchS();
        $dataProvider = $searchModel->search($id);
        $model = Classes::findOne($id);
        $enstudents = StudentClass::find()->where(['class_id'=> $model]);
        $sclasses = StudentClass::find()->where(['class_id'=>$id])->one();
        foreach($enstudents as $enstuds ){
        $evaluation = new Evaluation();
             $evalby = User::find()->where(['id' => $sc->student->user->id])->one();
             $evalfor = User::find()->where(['id' => $model->teacher->user->id])->one();
             $evaluation->link('evalBy', $evalby);
             $evaluation->link('evalFor', $evalfor);
             $evaluation->link('instrument', $instrument);
             $evaluation->link('class', $id);
             $model->eval_status = 10;
             $model->save();
             $evaluation->save();
        }
        return $this->redirect(['/teacher']);
    }

    /**
     * Creates a new Classes model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Classes();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Classes model.
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
     * Deletes an existing Classes model.
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
     * Finds the Classes model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Classes the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Classes::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
