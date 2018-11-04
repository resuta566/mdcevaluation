<?php

namespace app\controllers;

use Yii;
use yii\helpers\Json;
use yii\bootstrap\ActiveForm;
use yii\web\Response;
use app\models\ModelForm as Model;
use yii\helpers\ArrayHelper;
use app\models\Evaluation;
use app\models\Instrument;
use app\models\Section;
use app\models\EvaluationSection;
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
                'only' => ['index','create','update','view','evaluate'],
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
                        'actions' => ['evaluate'],
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
    public function actionUpdates($id)
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
        $instrument = Instrument::find()->where(['id' => $model->instrument_id])->one();
        $sections = Section::find()->where(['instrument_id' => $instrument->id ])->all();
        // echo $model->id;
        // die();
        $evalSections = $model->evaluationSections;
        $evalItems = [];
        $oldItems = [];
        if (!empty($evalSections)) {
            foreach ($evalSections as $indexSection => $modelSection) {
                
                $items = $modelSection->evaluationItems;
                $evalItems[$indexSection] = $items;
                $oldItems = ArrayHelper::merge(ArrayHelper::index($items, 'id'), $oldItems);
          
            }
            
        }
        if($model->evalBy->id !== Yii::$app->user->id){
            throw new \yii\web\HttpException(401, 'You are Forbidden to Evaluate this Teacher for it is not yours to evaluate!');
        }elseif($model->status == 1){
            throw new \yii\web\HttpException(401, "You're done evaluating this teacher you cant change anything after you submit!");
        }
            
        if (Yii::$app->request->post()) {
            // reset
            $evalItems = [];

            $oldSectionIDs = ArrayHelper::map($evalSections, 'id', 'id');
            $evalSections = Model::createMultiple(EvaluationSection::classname(), $evalSections);
            Model::loadMultiple($evalSections, Yii::$app->request->post());
            $deletedSectionIDs = array_diff($oldSectionIDs, array_filter(ArrayHelper::map($evalSections, 'id', 'id')));

            if (Yii::$app->request->isAjax) {
                Yii::$app->response->format = Response::FORMAT_JSON;
                return ActiveForm::validateMultiple($evalSections);
            }

            // validate Evaluation and EvaluationSection models
            $valid = $model->validate();
            $valid = Model::validateMultiple($evalSections) && $valid;

            $itemsIDs = [];
            if (isset($_POST['EvaluationItem'][0][0])) {
                foreach ($_POST['EvaluationItem'] as $indexSection => $items) {
                    $itemsIDs = ArrayHelper::merge($itemsIDs, array_filter(ArrayHelper::getColumn($items, 'id')));
                    // die($itemsIDs);
                    foreach ($items as $indexItem => $item) {
                        $data['EvaluationItem'] = $item;
                        $modelItem = (isset($item['id']) && isset($oldItems[$item['id']])) ? $oldItems[$item['id']] : new EvaluationItem;
                        // $modelItem->scenario = 'update';
                        $modelItem->load($data);
                        $evalItems[$indexSection][$indexItem] = $modelItem;
                        $valid = $modelItem->validate();
                    }
                }
            }

            $oldItemsIDs = ArrayHelper::getColumn($oldItems, 'id');
            $deletedItemsIDs = array_diff($oldItemsIDs, $itemsIDs);

            if ($valid) {
                $transaction = Yii::$app->db->beginTransaction();
                try {
                    if ($flag = $model->save(false)) {

                        // if (! empty($deletedItemsIDs)) {
                        //     // EvaluationItem::deleteAll(['id' => $deletedItemsIDs]);
                        //     echo "YEAH 1";
                        //     die();
                        // }

                        // if (! empty($deletedSectionIDs)) {
                        //     // EvaluationsSection::deleteAll(['id' => $deletedSectionIDs]);
                        //     echo "YEAH 2";
                        //     die();
                        // }
                        
                        foreach ($evalSections as $indexSection => $modelSection) {
                                
                            if ($flag === false) {
                                break;
                            }

                            if (!($flag = $modelSection->save())) {
                                break;
                            }

                            if (isset($evalItems[$indexSection]) && is_array($evalItems[$indexSection])) {
                                foreach ($evalItems[$indexSection] as $indexItem => $modelItem) {
                                    
                                    if (!($flag = $modelItem->save(false))) {
                                        break;
                                    }
                                }
                            }
                        }
                    }
                         $model->status = 1;
                         $model->save();
                        $transaction->commit();
                        return $this->redirect(['/']);
                    
                } catch (Exception $e) {
                    $transaction->rollBack();
                }
            }
        }

    return $this->render('evaluate', [
        'model' => $model,
        'evalSections' => $evalSections,
        'evalItems' => $evalItems
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
