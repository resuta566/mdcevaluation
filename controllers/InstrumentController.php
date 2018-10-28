<?php

namespace app\controllers;

use Yii;
use app\models\ModelForm as Model;
use app\models\Instrument;
use app\models\Section;
use app\models\Item;
use app\models\User;
use app\models\InstrumentSearch;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use app\components\AccessRule;

/**
 * InstrumentController implements the CRUD actions for Instrument model.
 */
class InstrumentController extends Controller
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
                'only' => ['index','view','create','update','delete'],
                'rules'=>[
                    [
                        'actions'=>['login'],
                        'allow' => true,
                        'roles' => ['@']
                    ],
                    [
                        'actions' => ['index','view','create','update','delete'],
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
     * Lists all Instrument models.
     * @return mixed
     */
    public function actionIndex()
    {
        $this->layout = "alayout";
        $searchModel = new InstrumentSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Instrument model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);
        $sections = $model->sections;

        return $this->render('view', [
            'model' => $model,
            'sections' => $sections,
        ]);
    }

    /**
     * Creates a new Instrument model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $modelInstrument = new Instrument;
        $modelsSection = [new Section];
        $modelsItem = [[new Item]];

        if ($modelInstrument->load(Yii::$app->request->post())) {

            $modelsSection = Model::createMultiple(Section::classname());
            Model::loadMultiple($modelsSection, Yii::$app->request->post());

            // validate Instrument and Sections models
            $valid = $modelInstrument->validate();
            $valid = Model::validateMultiple($modelsSection) && $valid;

            if (isset($_POST['Item'][0][0])) {
                foreach ($_POST['Item'] as $indexSection => $items) {
                    foreach ($items as $indexItem => $item) {
                        $data['Item'] = $item;
                        $modelItem = new Item;
                        $modelItem->load($data);
                        $modelsItem[$indexSection][$indexItem] = $modelItem;
                        $valid = $modelItem->validate();
                    }
                }
            }

            if ($valid) {
                $transaction = Yii::$app->db->beginTransaction();
                try {
                    if ($flag = $modelInstrument->save(false)) {
                        // print_r($modelInstrument->save(false));
                        // die();
                        foreach ($modelsSection as $indexSection => $modelSection) {
                            if ($flag === false) {
                                break;
                            }
                            $modelSection->instrument_id = $modelInstrument->id;
                            if (!($flag = $modelSection->save(false))) {
                                break;
                            }
                            if (isset($modelsItem[$indexSection]) && is_array($modelsItem[$indexSection])) {
                                foreach ($modelsItem[$indexSection] as $indexItem => $modelItem) {
                                    $modelItem->section_id = $modelSection->id;
                                    if (!($flag = $modelItem->save(false))) {
                                        break;
                                    }
                                }
                            }
                        }
                    }
                    
                    if ($flag) {
                        $transaction->commit();
                        return $this->redirect(['view', 'id' => $modelInstrument->id]);
                    } else {
                        $transaction->rollBack();
                    }
                } catch (Exception $e) {
                    $transaction->rollBack();
                }
            }
            
        }

        return $this->render('create', [
            'modelInstrument' => $modelInstrument,
            'modelsSection' => (empty($modelsSection)) ? [new Section] : $modelsSection,
            'modelsItem' => (empty($modelsItem)) ? [[new Item]] : $modelsItem,
        ]);
    }

    /**
     * Updates an existing Instrument model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $modelInstrument = $this->findModel($id);
        $modelsSection = $modelInstrument->sections;
        $modelsItem = [];
        $oldItems = [];
        if (!empty($modelsSection)) {
            foreach ($modelsSection as $indexSection => $modelSection) {
                $items = $modelSection->items;
                $modelsItem[$indexSection] = $items;
                $oldItems = ArrayHelper::merge(ArrayHelper::index($items, 'id'), $oldItems);
            }
        }

        if ($modelInstrument->load(Yii::$app->request->post())) {

            // reset
            $modelsItem = [];

            $oldSectionIDs = ArrayHelper::map($modelsSection, 'id', 'id');
            $modelsSection = Model::createMultiple(Section::classname(), $modelsSection);
            Model::loadMultiple($modelsSection, Yii::$app->request->post());
            $deletedSectionIDs = array_diff($oldSectionIDs, array_filter(ArrayHelper::map($modelsSection, 'id', 'id')));

            // validate Instrument and Section models
            $valid = $modelInstrument->validate();
            $valid = Model::validateMultiple($modelsSection) && $valid;

            $itemsIDs = [];
            if (isset($_POST['Item'][0][0])) {
                foreach ($_POST['Item'] as $indexSection => $items) {
                    $itemsIDs = ArrayHelper::merge($itemsIDs, array_filter(ArrayHelper::getColumn($items, 'id')));
                    foreach ($items as $indexItem => $item) {
                        $data['Item'] = $item;
                        $modelItem = (isset($item['id']) && isset($oldItems[$item['id']])) ? $oldItems[$item['id']] : new Item;
                        $modelItem->load($data);
                        $modelsItem[$indexSection][$indexItem] = $modelItem;
                        $valid = $modelItem->validate();
                    }
                }
            }

            $oldItemsIDs = ArrayHelper::getColumn($oldItems, 'id');
            $deletedItemsIDs = array_diff($oldItemsIDs, $itemsIDs);

            if ($valid) {
                $transaction = Yii::$app->db->beginTransaction();
                try {
                    if ($flag = $modelInstrument->save(false)) {

                        if (! empty($deletedItemsIDs)) {
                            Item::deleteAll(['id' => $deletedItemsIDs]);
                        }

                        if (! empty($deletedSectionIDs)) {
                            Section::deleteAll(['id' => $deletedSectionIDs]);
                        }

                        foreach ($modelsSection as $indexSection => $modelSection) {

                            if ($flag === false) {
                                break;
                            }

                            $modelSection->instrument_id = $modelInstrument->id;

                            if (!($flag = $modelSection->save())) {
                                break;
                            }

                            if (isset($modelsItem[$indexSection]) && is_array($modelsItem[$indexSection])) {
                                foreach ($modelsItem[$indexSection] as $indexItem => $modelItem) {
                                    $modelItem->section_id = $modelSection->id;
                                    if (!($flag = $modelItem->save())) {
                                        break;
                                    }
                                }
                            }
                        }
                    }

                    if ($flag) {
                        $transaction->commit();
                        return $this->redirect(['view', 'id' => $modelInstrument->id]);
                    } else {
                        $transaction->rollBack();
                    }
                } catch (Exception $e) {
                    $transaction->rollBack();
                }
            }
        }

        return $this->render('update', [
            'modelInstrument' => $modelInstrument,
            'modelsSection' => (empty($modelsSection)) ? [new Section] : $modelsSection,
            'modelsItem' => (empty($modelsItem)) ? [[new Item]] : $modelsItem
        ]);
    }

    /**
     * Deletes an existing Instrument model.
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
     * Finds the Instrument model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Instrument the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Instrument::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
