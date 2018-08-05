<?php

namespace app\controllers;

use Yii;
use app\models\User;
use app\models\Teacher;
use app\models\TeacherSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use app\components\AccessRule;
/**
 * TeacherController implements the CRUD actions for Teacher model.
 */
class TeacherController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
        //     'access' => [
        //     'class' => AccessControl::className(),
        //     'ruleConfig' => [
        //         'class' => AccessRule::className(),
        //     ],
        //     'only' => ['index','view'],
        //     'rules'=>[
        //         [
        //             'actions'=>['index'],
        //             'allow' => true,
        //             'roles' => ['@']
        //         ],
        //         [
        //             'actions' => ['index','delete'],
        //             'allow' => true,
        //             'roles' => [User::USER_ADMIN]
        //         ]
        //     ],
        // ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Teacher models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new TeacherSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Teacher model.
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
    protected function findModel($id)
    {
        if (($model = Teacher::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

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

    public function actionGenerate($id)
    {
        $student = Teacher::findOne($id);
        $user = new User;
        $user->username = Teacher::findOne($id)->getTeacherUser();
        $user->setPassword(Teacher::findOne($id)->getTeacherPass());
        $user->role = 20;
        $user->status = 10;
        if(!$user->save()){
            Yii::$app->session->setFlash('danger', Teacher::findOne($id)->getFullName()."'s account has not been generated");
        }else{
            Yii::$app->session->setFlash('success', Teacher::findOne($id)->getFullName()."'s account has been generated");
        }
        $student->link('user', $user);
         if(!$student->save()){
            Yii::$app->session->setFlash('error', Teacher::findOne($id)->getFullName()."'s has not been connected to his/her User Account");
        }else{
        Yii::$app->session->setFlash('notice', Teacher::findOne($id)->getFullName()."'s has been connected to his/her User Account");
        }
        
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }
}
