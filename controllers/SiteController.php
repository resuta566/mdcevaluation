<?php

namespace app\controllers;

use Yii;
use \yii\helpers\Url;
use app\models\Student;
use app\models\User;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use app\components\AccessRule;

class SiteController extends Controller
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
                'only' => ['index','view','about'],
                'rules'=>[
                    [
                        'actions'=>['index'],
                        'allow' => true,
                        'roles' => ['?']
                    ],
                    [
                        'actions'=>['index'],
                        'allow' => true,
                        'roles' => ['@']
                    ],[
                        'actions' => ['index'],
                        'allow' => true,
                        'roles' => [User::ROLE_STUDENT]
                    ],[
                        'actions' => ['index'],
                        'allow' => true,
                        'roles' => [User::ROLE_TEACHER]
                    ],[
                        'actions' => ['index'],
                        'allow' => true,
                        'roles' => [User::ROLE_HEAD]
                    ],
                    [
                        'actions' => ['index','delete','about'],
                        'allow' => true,
                        'roles' => [User::ROLE_ADMIN]
                    ],
                    [
                        'actions' => ['index','delete','about'],
                        'allow' => true,
                        'roles' => [User::ROLE_GUIDANCE]
                    ]
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
            $this->layout = 'loginLayout';
        // $user = new User;
        // $user->username = "admin";
        //                 $user->setPassword('admin');
        //                 $user->role = 100;
        //                 $user->status = 10;
        //                 $user->save();
        // Yii::$app->db->schema->getTableSchema('teacher');
        if(Yii::$app->user->isGuest) {

            return $this->render('index');

        }else if (Yii::$app->user->identity->role==User::ROLE_ADMIN) {
            
            return $this->render('panels/_admin');

         }else if (Yii::$app->user->identity->role==User::ROLE_STUDENT) {
            
            return $this->render('panels/_student');

         }else if (Yii::$app->user->identity->role==User::ROLE_TEACHER) {
            
            return $this->render('panels/_teacher');

         }else if (Yii::$app->user->identity->role==User::ROLE_HEAD) {
            
            return $this->render('panels/_teacher');

         }else if (Yii::$app->user->identity->role==User::ROLE_GUIDANCE) {
            
            return $this->render('panels/_admin');

         }else{
            return $this->render('index');
         }
    }

    /**
     * Login action.
     *
     * @return Response|string
     */
    public function actionLogin()
    {
        $this->layout = 'loginLayout';
        if (!Yii::$app->user->isGuest) {
            return $this->redirect('index');
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }

        $model->password = '';
        return $this->render('login', [
            'model' => $model,
        ]);
    }
    /**
     * 
     * LogIn For Index
     */
    public function actionLogins()
    {
        $this->layout = 'loginLayout';
        if (!Yii::$app->user->isGuest) {
            return $this->redirect('index');
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }

        $model->password = '';
        return $this->renderAjax('login', [
            'model' => $model,
        ]);
    }

    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        if ( Yii::$app->user->isGuest )
    return Yii::$app->getResponse()->redirect(['/'],302);
    }

    // public function actionContact()
    // {
    //     $model = new ContactForm();
    //     if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
    //         Yii::$app->session->setFlash('contactFormSubmitted');

    //         return $this->refresh();
    //     }
    //     return $this->render('contact', [
    //         'model' => $model,
    //     ]);
    // }
    // public function actionAbout()
    // {
    //     return $this->render('about');
    // }
}
