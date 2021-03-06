<?php

namespace app\controllers;

use Yii;
use app\models\Student;
use app\models\User;
use app\models\StudentSearch;
use app\models\StudentSearchList;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use app\components\AccessRule;
use app\models\StudentClassStudView;

/**
 * StudentController implements the CRUD actions for Student model.
 */
class StudentController extends Controller
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
                'only' => ['index','view','generate','list','generateBulk'],
                'rules'=>[
                    [
                        'actions'=>['login'],
                        'allow' => true,
                        'roles' => ['@']
                    ],
                    [
                        'actions' => ['index','view','generate','list'],
                        'allow' => true,
                        'roles' => [User::ROLE_ADMIN]
                    ],
                    [
                        'actions' => ['index','view','generate','list'],
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
     * Lists all Student models.
     * @return mixed
     */
    public function actionIndex()
    {
        $this->layout = "alayout";
        $searchModel = new StudentSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionList()
    {
        $this->layout = "alayout";
        $model = Student::find()->orderBy('id')->all();
        $searchModel = new StudentSearchList();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->pagination->pageSize= 100;
        return $this->render('list', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'model' => $model,
        ]);
    }

    /**
     * Displays a single Student model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        
        $activeClass = new StudentClassStudView();
        $activeDataProvider = $activeClass->search($id);

        return $this->render('view', [
            'model' => $this->findModel($id),
            'activeDataProvider' => $activeDataProvider,

        ]);
    }

    public function actionUnlink($id)
    {
        $student = Student::findOne($id);
        $user = User::find()->where(['username'=> $student->id])->one();
        $user->setPassword(Student::findOne($id)->getStudentPass()); 
        $user->save();
        if(!$user->save()){
            Yii::$app->session->setFlash('danger', 
                            Student::findOne($id)->getFullName().
                            "'s account password can't be reset.");
        }
        Yii::$app->session->setFlash('success', 
                            Student::findOne($id)->getFullName().
                            "'s account has been password reset.");
                    
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Generate one user for the student
     * 
     */
    public function actionGenerate($id)
    {
        $userDept = Yii::$app->request->post('userDepartment');
        $student = Student::findOne($id);
        $user = new User;
        if (!$student->user_id === 0){
            Yii::$app->session->setFlash('danger', 
            ' '.Student::findOne($id)->getFullName()." has an account already.");
                        return $this->render('view', [
                            'model' => $this->findModel($id),
                    ]);
    
                }else{
        
                        $user->username = Student::findOne($id)->getStudentUser();
                        $user->setPassword(Student::findOne($id)->getStudentPass());
                        $user->role = 15;
                        $user->status = 10;
                        $user->department = $userDept;
                        $user->save();
                    if(!$user->save()){
                        Yii::$app->session->setFlash('danger', 
                        ' '.Student::findOne($id)->getFullName()." already has an account");
                    }else{
                        
                        Yii::$app->session->setFlash('success', 
                        ' '.Student::findOne($id)->getFullName()."'s account has been generated");
                        $student->link('user', $user);
                    }
                    
                    if(!$student->save()){
                        Yii::$app->session->setFlash('error', 
                        ' '.Student::findOne($id)->getFullName()."'s has not been connected to his/her User Account");
                    }else{
                    $student->save();
                    Yii::$app->session->setFlash('info',
                    ' '.Student::findOne($id)->getFullName()."'s has been connected to his/her User Account");
                    }
                    
                return $this->render('view', [
                    'model' => $this->findModel($id),
            ]);

        }
    }
    /**
     * 
     * Generate Users based on how many Student you select
     * 
     */
    public function actionGeneratebulk()
    {
        $userDept = Yii::$app->request->post('userDepartment');
        $selection=(array)Yii::$app->request->post('selection');
        foreach($selection as $studid){
            $student = Student::find()->where(['id' => $studid])->one();
            $user = new User;
            if (!$student->user_id === 0){
                Yii::$app->session->setFlash('danger', 
                ' '.$student->getFullName()." has an account already.");
                return $this->redirect('list');
        
                    }else{
            
                            $user->username = $student->getStudentUser();
                            $user->setPassword($student->getStudentPass());
                            $user->role = 15;
                            $user->status = 10;
                            $user->department = $userDept;
                            $user->save();
                            if(!$user->save()){
                                Yii::$app->session->setFlash('danger', 
                                " One of the Student you select has already has an account");
                            }else{
                                
                                Yii::$app->session->setFlash('success', 
                                "Accounts has been generated successfully");
                                $student->link('user', $user);
                            }
                            
                            if(!$student->save()){
                                Yii::$app->session->setFlash('error', 
                                "Students Accounts has not been connected to their User Account");
                            }else{
                            $student->save();
                            Yii::$app->session->setFlash('info',
                           "Students has been connected to their User Account");
                            }
                    }
                    

        }
        return $this->redirect('list');
        // print_r($selection);
        // die();
    }


    public function actionStudentDepartment($department)
    {
        if($department == 1){
            //CAST
            $castUsers = User::find()->where(['role' => 15])->andWhere(['department' => 1])->all();
            $this->layout = "alayout";
            $searchModel = new \app\models\StudentSearchCAST();
            $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

            return $this->render('cast-student',[
                'castUsers' => $castUsers,
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
            ]);
        }else if($department == 2) {
            //COE
            $castUsers = User::find()->where(['role' => 15])->andWhere(['department' => 2])->all();
            $this->layout = "alayout";
            $searchModel = new \app\models\StudentSearchCOE();
            $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

            return $this->render('coe-student',[
                'castUsers' => $castUsers,
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
            ]);
        }else if($department == 3) {
        //CABM-H
            $castUsers = User::find()->where(['role' => 15])->andWhere(['department' => 3])->all();
            $searchModel = new \app\models\StudentSearchCABMH();
            $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

            return $this->render('cabmh-student',[
                'castUsers' => $castUsers,
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
            ]);
        }else if($department == 4) {
        //CABM-B
            $castUsers = User::find()->where(['role' => 15])->andWhere(['department' => 4])->all();
            $searchModel = new \app\models\StudentSearchCABMB();
            $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

            return $this->render('cabmb-student',[
                'castUsers' => $castUsers,
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
            ]);
        }else if($department == 5) {
        //CON
            $castUsers = User::find()->where(['role' => 15])->andWhere(['department' => 5])->all();
            $searchModel = new \app\models\StudentSearchCON();
            $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

            return $this->render('con-student',[
                'castUsers' => $castUsers,
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
            ]);
        }else if($department == 6) {
        //CCJ
            $castUsers = User::find()->where(['role' => 15])->andWhere(['department' => 6])->all();
            $searchModel = new \app\models\StudentSearchCCJ();
            $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

            return $this->render('ccj-student',[
                'castUsers' => $castUsers,
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
            ]);
        }else if($department == 7) {
        //Senior HS
            $castUsers = User::find()->where(['role' => 15])->andWhere(['department' => 7])->all();
            $searchModel = new \app\models\StudentSearchSHS();
            $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

            return $this->render('shs-student',[
                'castUsers' => $castUsers,
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
            ]);
        }else if($department == 8) {
        //Junior HS
            $castUsers = User::find()->where(['role' => 15])->andWhere(['department' => 8])->all();
            $searchModel = new \app\models\StudentSearchJHS();
            $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

            return $this->render('jhs-student',[
                'castUsers' => $castUsers,
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
            ]);
        }else if($department == 9) {
        //Elementary
            $castUsers = User::find()->where(['role' => 15])->andWhere(['department' => 9])->all();
            $searchModel = new \app\models\StudentSearchELEM();
            $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

            return $this->render('elem-student',[
                'castUsers' => $castUsers,
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
            ]);
        }
            throw new \yii\web\HttpException(404, 'Department Not Found');
    }
    
    /**
     * Updates an existing Student model.
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
     * Finds the Student model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Student the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Student::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
