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
use kartik\mpdf\Pdf;

/**
 * RankController implements the CRUD actions for Rank model.
 */
class RankController extends Controller
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
                        'actions' => ['index'],
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
     * Lists all Classes models.
     * @return mixed
     */
    public function actionIndex()
    {
        $this->layout = 'alayout';
        return $this->render('rank');
    }

    /**
     * Print the Teacher ranking
     */
    public function actionPrint()
    {
        // Yii::$app->response->format = \yii\web\Response::FORMAT_RAW;
        
        $castTeachers = User::find()->where(['department' => 1])->andWhere(['role' => [20,30]])->all();
        $content = $this->renderPartial('_cast',[
            'castTeachers' => $castTeachers 
        ]);
    
    // setup kartik\mpdf\Pdf component
    $pdf = new Pdf([
        // set to use core fonts only
        'mode' => Pdf::MODE_CORE, 
        // A4 paper format
        'format' => Pdf::FORMAT_LETTER, 
        // portrait orientation
        'orientation' => Pdf::ORIENT_PORTRAIT, 
        // stream to browser inline
        'destination' => Pdf::DEST_BROWSER, 
        // your html content input
        'content' => $content,  
        // format content from your own css file if needed or use the
        // enhanced bootstrap css built by Krajee for mPDF formatting 
        'cssFile' => '@vendor/kartik-v/yii2-mpdf/src/assets/kv-mpdf-bootstrap.min.css',
        // any css to be embedded if required
        'cssInline' => '.kv-heading-1{font-size:18px} 
                        .jem{
                            display: flex;
                            justify-content: center;
                            align-items: center
                        }', 
         // set mPDF properties on the fly
        'options' => [
            'title' => 'MDC TEACHER EVALUATION',
            'subject' => 'PDF Document Subject'
        ],
         // call mPDF methods on the fly
        'methods' => [ 
            'SetTitle' => 'MATER DEI COLLEGE TEACHER EVALUATION RANKING',
            'SetSubject' => 'Generating Hard Copies of Teacher Ranking in the Evaluation',
            'SetHeader' => ['MDC TEACHER EVALUATION RANK ||Generated On: ' . date("r")],
            'SetFooter' => ['|Page {PAGENO}|'],
            'SetAuthor' => Yii::$app->user->identity->teacher->fullName,
            'SetCreator' => Yii::$app->user->identity->teacher->fullName,
            'SetKeywords' => 'Krajee, Yii2, Export, PDF, MPDF, Output, Privacy, Policy, yii2-mpdf',
        ]
    ]);
    
    // return the pdf output as per the destination setting
    return $pdf->render(); 
    }
}