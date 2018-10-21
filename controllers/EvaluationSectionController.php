<?php

namespace app\controllers;

use Yii;
use yii\base\Model;
use yii\helpers\ArrayHelper;
use app\models\Evaluation;
use app\models\EvaluationItem;
use app\models\EvaluationSection;
use app\models\EvaluationSectionSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * EvaluationSectionController implements the CRUD actions for EvaluationSection model.
 */
class EvaluationSectionController extends Controller
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
     * Lists all EvaluationSection models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new EvaluationSectionSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single EvaluationSection model.
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
     * Creates a new EvaluationSection model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new EvaluationSection();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing EvaluationSection model.
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
        $evaluation = Evaluation::find()->where(['id' => $id])->one();
        $evalSections = EvaluationSection::find()->where(['evaluation_id' => $evaluation->id])->all();
        $evalItems = [];
        $oldItems = [];
        if (!empty($evalSections)) {
            foreach ($evalSections as $indexSection => $modelSection) {
                $items = $modelSection->evaluationItems;
                $evalItems[$indexSection] = $items;
                $oldItems = ArrayHelper::merge(ArrayHelper::index($items, 'id'), $oldItems);
            }
        }

        if ($evaluation->load(Yii::$app->request->post())) {
           
            // reset
            $evalItems = [];

            $oldSectionIDs = ArrayHelper::map($evalSections, 'id', 'id');
            $evalSections = Model::createMultiple(Section::classname(), $evalSections);
            Model::loadMultiple($evalSections, Yii::$app->request->post());
            $deletedSectionIDs = array_diff($oldSectionIDs, array_filter(ArrayHelper::map($evalSections, 'id', 'id')));

            // validate Instrument and Section models
            $valid = $evaluation->validate();
            $valid = Model::validateMultiple($evalSections) && $valid;

            $itemsIDs = [];
            if (isset($_POST['Item'][0][0])) {
                foreach ($_POST['Item'] as $indexSection => $items) {
                    $itemsIDs = ArrayHelper::merge($itemsIDs, array_filter(ArrayHelper::getColumn($items, 'id')));
                    foreach ($items as $indexItem => $item) {
                        $data['Item'] = $item;
                        $modelItem = (isset($item['id']) && isset($oldItems[$item['id']])) ? $oldItems[$item['id']] : new Item;
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
                    if ($flag = $evaluation->save(false)) {

                        if (! empty($deletedItemsIDs)) {
                            EvaluationItem::deleteAll(['id' => $deletedItemsIDs]);
                        }

                        if (! empty($deletedSectionIDs)) {
                            EvaluationSection::deleteAll(['id' => $deletedSectionIDs]);
                        }

                        foreach ($evalSections as $indexSection => $modelSection) {

                            if ($flag === false) {
                                break;
                            }

                            // $modelSection->instrument_id = $evaluation->id;

                            if (!($flag = $modelSection->save(false))) {
                                break;
                            }

                            if (isset($evalItems[$indexSection]) && is_array($evalItems[$indexSection])) {
                                foreach ($evalItems[$indexSection] as $indexItem => $modelItem) {
                                    // $modelItem->section_id = $modelSection->id;
                                    if (!($flag = $modelItem->save(false))) {
                                        break;
                                    }
                                }
                            }
                        }
                    }

                    if ($flag) {
                        $transaction->commit();
                        return $this->redirect(['view', 'id' => $evaluation->id]);
                    } else {
                        $transaction->rollBack();
                    }
                } catch (Exception $e) {
                    $transaction->rollBack();
                }
            }
        }
        
        print_r($evaluation->save());
        die();
        return $this->render('evaluation', [
            'model' => $evaluation,
            'evalSections' =>  $evalSections,
            'evalItems' =>  $evalItems
        ]);
    }

    /**
     * Deletes an existing EvaluationSection model.
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
     * Finds the EvaluationSection model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return EvaluationSection the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = EvaluationSection::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
