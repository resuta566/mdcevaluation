<?php

namespace app\controllers;

use Yii;
use yii\base\Model;
use app\models\Evaluation;
use app\models\Classes;
use app\models\StudentClass;
use app\models\User;
use app\models\Teacher;
use app\models\TeacherSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use app\components\AccessRule;
use app\models\ClassesSearchT;
use app\models\Instrument;
/**
 * TeacherController implements the CRUD actions for Teacher model.
 */
class TeacherController extends Controller
{
    public $username;

    public function rules()
    {
        return [
            ['username', 'required'],
            // ['username', 'unique', 'targetClass' =>
            //  '\app\models\User', 'message' => 'This username has already been taken.'],
            ['username', 'string', 'min' => 2, 'max' => 255],
        ];
    }

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
                'only' => ['index','view','generate','unlink','bulk'],
                'rules'=>[
                    [
                        'actions'=>['login'],
                        'allow' => true,
                        'roles' => ['@']
                    ],
                    [
                        'actions' => ['index','view','generate','unlink','bulk'],
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
     * Lists all Teacher models.
     * @return mixed
     */
    public function actionIndex()
    {
        $this->layout = "alayout";
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
        $searchModel = new ClassesSearchT();
        $dataProvider = $searchModel->search($id);
        $model = Teacher::findOne($id);
        $classes = Classes::find()->where(['teacher_id'=>$id])->one();
        return $this->render('view', [
            'model'=> $model,
            'classes'=> $classes,
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
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

    public function actionBulk(){
        $action=Yii::$app->request->post('action');
        $instrument = Instrument::find('id')->where(['name'=>'Student Form'])->one();
        $selection=(array)Yii::$app->request->post('selection');//typecasting
        foreach($selection as $id){
         $model = Classes::findOne((int)$id);//make a typecasting
        //  echo $model->name." " ;
         $sclass = StudentClass::find()->where(['class_id'=>$model->id])->all();
         foreach ($sclass as $sc) {
             $evaluation = new Evaluation();
             $evalby = User::find()->where(['id' => $sc->student->user->id])->one();
             $evalfor = User::find()->where(['id' => $model->teacher->user->id])->one();
            //  echo $sc->student->id. " ";
            //  echo $evalfor . " " . $evalby;
            //  $evaluation->eval_by = $sc->id;
            //  $evaluation->evaly_for = $model->teacher->user_id;
            //  $evaluation->instrument_id = $instrument;
            //  $evaluation->class_id = $model->id;
             $evaluation->link('evalBy', $evalby);
             $evaluation->link('evalFor', $evalfor);
             $evaluation->link('instrument', $instrument);
             $evaluation->link('class', $model);
             $model->estatus = 10;
             $model->save();
             $evaluation->save();
             
            // $gago = Instrument::find($id)->where(['name'=>'Student Form'])->one();
            // echo $gago->id ." ";
            // echo  $sc->student->user->username." & ";
        }
        
        //  echo $sclass->student->lname;
        //  $model->save();
         // or delete
       }
       return $this->redirect(['/teacher']);
     }

     /**
     * Unlink a single Teacher User.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUnlink($id)
    {
        $searchModel = new ClassesSearchT();
        $dataProvider = $searchModel->search($id);
        $teacher = Teacher::findOne($id);
        $user = User::find()->where(['username'=> $teacher->id])->one();
        $teacher->unlink('user',$user);
        Yii::$app->session->setFlash('success', 
        ' '.Teacher::findOne($id)->getFullName(). "'s account has been unlinked.");
                     
        $user->delete();
        Yii::$app->session->setFlash('danger', 
        ' '.Teacher::findOne($id)->getFullName()."'s account has been deleted");
                    
        return $this->render('view', [
            'model' => $this->findModel($id),
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
    ]);
    }
     /**
     * Generate a single Teacher user.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionGenerate($id)
    {
        $searchModel = new ClassesSearchT();
        $dataProvider = $searchModel->search($id);
        $teacher = Teacher::findOne($id);
        $user = new User;
        if (!$teacher->user_id === 0){
                Yii::$app->session->setFlash('danger', 
                ' '.Teacher::findOne($id)->getFullName()." has an account already.");
                            return $this->render('view', [
                                'model' => $this->findModel($id),
                        ]);
        
                    }else{
            
                            $user->username = Teacher::findOne($id)->getTeacherUser();
                            $user->setPassword(Teacher::findOne($id)->getTeacherPass());
                            $user->role = 20;
                            $user->status = 10;
                            $user->save();
                        if(!$user->save()){
                            Yii::$app->session->setFlash('danger', 
                            ' '.Teacher::findOne($id)->getFullName(). " already has an account");
                        }else{
                            
                            Yii::$app->session->setFlash('success', 
                            ' '.Teacher::findOne($id)->getFullName()."'s account has been generated");
                            $teacher->link('user', $user);
                        }
                        
                        if(!$teacher->save()){
                            Yii::$app->session->setFlash('error', 
                            ' '.Teacher::findOne($id)->getFullName()."'s has not been connected to his/her User Account");
                        }else{
                        $teacher->save();
                        Yii::$app->session->setFlash('info',
                        ' '.Teacher::findOne($id)->getFullName()."'s has been connected to his/her User Account");
                        }
                        
                    return $this->render('view', [
                        'model' => $this->findModel($id),
                        'searchModel' => $searchModel,
                        'dataProvider' => $dataProvider,
                ]);

        }
        
        
    }
}
