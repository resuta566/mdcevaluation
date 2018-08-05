<?php

namespace app\controllers;

use Yii;
use app\models\Student;
use app\models\User;
use app\models\StudentSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

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
        $model = Student::find()->orderBy('id')->all();
        $searchModel = new StudentSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
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
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }
    /**
     * Generate a user for the student
     * 
     */
    public function actionGenerate($id)
    {
        $student = Student::findOne($id);
        $userV = User::findAll('roles');
        // print_r($userV);
        // die();
        $user = new User;
        if ( $userV === 15 && !$student->user_id == 0){
                Yii::$app->session->setFlash('danger', 
                            Student::findOne($id)->getFullName().
                            " has an account already.");
                            return $this->render('view', [
                                'model' => $this->findModel($id),
                        ]);
        
                    }else{
            
                            $user->username = Student::findOne($id)->getStudentUser();
                            $user->setPassword(Student::findOne($id)->getStudentPass());
                            $user->role = 15;
                            $user->status = 10;
                            $user->save();
                            // print_r($user->save());
                            // die();
                        if(!$user->save()){
                            print_r($user->save());
                            die();
                            Yii::$app->session->setFlash('danger', 
                            Student::findOne($id)->getFullName().
                            " already has an accountsdsds");
                        }else{
                            
                            Yii::$app->session->setFlash('success', 
                            Student::findOne($id)->getFullName().
                            "'s account has been generated");
                            $student->link('user', $user);
                        }
                        if(!$student->save()){
                            Yii::$app->session->setFlash('error', 
                            Student::findOne($id)->getFullName().
                            "'s has not been connected to his/her User Account");
                        }else{
                            $student->save();
                        Yii::$app->session->setFlash('notice',
                        Student::findOne($id)->getFullName().
                        "'s has been connected to his/her User Account");
                        }

            }
             return $this->render('view', [
                        'model' => $this->findModel($id),
                    ]);
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
