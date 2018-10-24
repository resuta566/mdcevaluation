<?php

namespace app\controllers;

use Yii;
use yii\base\Model;
use app\models\Evaluation;
use app\models\Classes;
use app\models\StudentClass;
use app\models\User;
use app\models\Teacher;
use app\models\Section;
use app\models\Item;
use app\models\EvaluationSection;
use app\models\EvaluationItem;
use app\models\TeacherSearch;
use app\models\TeacherSearchList;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use app\components\AccessRule;
use app\models\ClassesSearchT;
use app\models\ClassesSearchActive;
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
                'only' => ['index','view','generate','unlink','bulk','generatebulk','list','score'],
                'rules'=>[
                    [
                        'actions'=>['login'],
                        'allow' => true,
                        'roles' => ['@']
                    ],
                    [
                        'actions' => ['index','view','generate','unlink','bulk','generatebulk','list','score'],
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

    public function actionList()
    {
        $this->layout = "alayout";
        $searchModel = new TeacherSearchList();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('list', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }


    public function actionScore($id)
    {
        $model = Teacher::findOne($id);
        $user = User::find()->where(['id' => $model->user->id])->one();
        $evaluations = Evaluation::find()->where(['eval_for' => $user->id])->all();
        $evaluation = Evaluation::find()->where(['eval_for' => $user->id])->one();
        $sections = EvaluationSection::find()->where(['evaluation_id' => $evaluation->id])->one();
        $evalItems = EvaluationItem::find()->where(['evaluation_section_id' => $sections->id])->one();
        if($evalItems->score == null){
            throw new \yii\web\HttpException(404, "The Evaluatee didn't submit scores yet.");
        }
        // $instruSection = Section::find()->where(['instrument_id' => $evaluation->instrument->id]);
        return $this->render('score',[
            'model' => $model,
            'evaluations' => $evaluations,
            'user' => $user
            ]);
    }

    public function actionRank()
    {

        return $this->render('rank');
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
        $instrument = Instrument::find()->all();
        $eval = new Evaluation();
        $activeClass = new ClassesSearchActive();
        $dataProvider = $searchModel->search($id);
        $activeDataProvider = $activeClass->search($id);
        $model = Teacher::findOne($id);
        $classes = Classes::find()->where(['teacher_id'=>$id])->one();
        return $this->render('view', [
            'model'=> $model,
            'eval' =>  $eval,
            'classes'=> $classes,
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'instrument' => $instrument,
            'activeDataProvider' => $activeDataProvider
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
        $action = Yii::$app->request->post('instrumentdropdown');
        $instrument = Instrument::find('id')->where(['id'=> $action ])->one();
        $instrumentSection = Section::find('id')->where(['instrument_id' => $instrument])->all();
        // foreach($instrumentSection as $iS){
        //     echo $iS->id." " . $iS->name. " - ";
        // $instrumentSectionItem = Item::find()->where(['section_id' => $iS->id])->all(); 
        // // echo  $instrumentSectionItem ."<br>";
        // echo "<br>";
        // foreach($instrumentSectionItem as $iSt){
        //     echo $iSt->id." - ";
        // }
        // }
        //Items
        // $instrumentSectionItem = Item::find()->where(['section_id' => $instrumentSection->id]); 
        $selection=(array)Yii::$app->request->post('selection');//typecasting
        foreach($selection as $id){
         $model = Classes::findOne((int)$id);//make a typecasting
         $sclass = StudentClass::find()->where(['class_id'=>$model->id])->all();
            foreach ($sclass as $sc) {
                $evaluation = new Evaluation();
                $evalby = User::find()->where(['id' => $sc->student->user->id])->one();
                $evalfor = User::find()->where(['id' => $model->teacher->user->id])->one();
                $evaluation->eval_by = $sc->id;
                $evaluation->eval_for = $model->teacher->user_id;
                $evaluation->instrument_id = $instrument->id;
                $evaluation->class_id = $model->id;
                $evaluation->link('evalBy', $evalby);
                $evaluation->link('evalFor', $evalfor);
                $evaluation->link('instrument', $instrument);
                $evaluation->link('class', $model);
                // $model->estatus = 1;
                $model->save();
                $evaluation->save();
            
                // print_r($evaluationId);
                // die();
                            foreach($instrumentSection as $iS){
                                $evalSection = new EvaluationSection;
                                $evalSection->evaluation_id = $evaluation->id;
                                $evalSection->section_id = $iS->id;
                                $evalSection->link('evaluation', $evaluation);
                                $evalSection->link('section', $iS);
                                // echo $iS->id." " . $iS->name. " - ";
                                $instrumentSectionItem = Item::find()->where(['section_id' => $iS->id])->all(); 
                                        // echo  $instrumentSectionItem ."<br>";
                                        // echo "<br>";
                                        foreach($instrumentSectionItem as $institem){
                                                $evalItem = new EvaluationItem;
                                                $evalItem->evaluation_section_id = $evalSection->id;
                                                $evalItem->item_id = $institem->id;
                                                $evalItem->link('evaluationSection', $evalSection);
                                                $evalItem->link('item', $institem);
                                                $evalItem->save();
                                                if(!$evalItem->save()){
                                                    print_r($evalItem->getErrors());
                                                    die();
                                                }
                                        }
                            }
                    
                
                }
        }
        if(!$evalItem->save() || !$evaluation->save())
        {
        Yii::$app->session->setFlash('danger',
         "Evaluation can't be submitted! Check if there is student for the class");
        }
        Yii::$app->session->setFlash('success',
        "Evaluation has been submitted to all the students of the subjects you selected");
       
       return $this->redirect(['view', 'id' => $model->teacher->id]);
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
        $activeClass = new ClassesSearchActive();
        $dataProvider = $searchModel->search($id);
        $activeDataProvider = $activeClass->search($id);
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
                'activeDataProvider' => $activeDataProvider
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
        $userDept = Yii::$app->request->post('userDepartment');
        $searchModel = new ClassesSearchT();
        $activeClass = new ClassesSearchActive();
        $dataProvider = $searchModel->search($id);
        $activeDataProvider = $activeClass->search($id);
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
                            $user->department = $userDept;
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
                        'activeDataProvider' => $activeDataProvider
                ]);

        }
        
        
    }


    public function actionGeneratebulk()
    {
        $userDept = Yii::$app->request->post('userDepartment');
        $selection=(array)Yii::$app->request->post('selection');
        foreach($selection as $studid){
            $teacher = Teacher::find()->where(['id' => $studid])->one();
            $user = new User;
            if (!$teacher->user_id === 0){
                Yii::$app->session->setFlash('danger', 
                ' '.$teacher->getFullName()." has an account already.");
                return $this->redirect('list');
        
                    }else{
            
                            $user->username = $teacher->getTeacherUser();
                            $user->setPassword($teacher->getTeacherPass());
                            $user->role = 20;
                            $user->status = 10;
                            $user->department = $userDept;
                            $user->save();
                            if(!$user->save()){
                                Yii::$app->session->setFlash('danger', 
                                " One of the Teachers you select has already has an account");
                            }else{
                                
                                Yii::$app->session->setFlash('success', 
                                "Accounts has been generated successfully");
                                $teacher->link('user', $user);
                            }
                            
                            if(!$teacher->save()){
                                Yii::$app->session->setFlash('error', 
                                "Teacher Accounts has not been connected to their User Account");
                            }else{
                            $teacher->save();
                            Yii::$app->session->setFlash('info',
                           "Teachers has been connected to their User Account");
                            }
                    }
                    

        }
        return $this->redirect('list');
        // print_r($selection);
        // die();
    }


    public function actionStop()
    {
        return "GAGO";
    }
}
