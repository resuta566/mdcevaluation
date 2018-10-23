<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;
use yii\widgets\DetailView;
use app\models\Teacher;
use app\models\Evaluation;
use app\models\EvaluationSection;
use app\models\EvaluationItem;
use app\models\Instrument;
use app\models\Section;
use app\models\Classes;
use yii\grid\GridView;
use kartik\tabs\TabsX;

/* @var $this yii\web\View */
/* @var $model app\models\Teacher */

$this->title = $model->getFullName()."'s Score";
$this->params['breadcrumbs'][] = ['label' => 'Teachers', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="card">
    <div class="card-header" data-background-color="blue">
                <h1><?= Html::encode($this->title) ?></h1>
                <p class="simple-text">Teacher Details</p>
     </div>
     <div class="card-content">
     <?php $evaluation = Evaluation::find()->where(['eval_for' => $model->user_id])->all() ?>
        <?php foreach($evaluation as $indexEvaluation => $eval){?>
            <?php $evaluationSection = EvaluationSection::find()->where(['evaluation_id' => $eval->id])->all()?>
            <?php foreach($evaluationSection as $indexEvaluationSection => $evalSection){?>
                <?php $evaluationItem = EvaluationItem::find()->where(['evaluation_section_id' => $evalSection->id])?>
                <?php foreach($evaluationItem->all() as $indexEvaluationItem => $evalItem){?>
                    <?= "". $evalItem->score ?>
                <?php } ?>
            <?php } ?>
     <?php } ?>
     </div>
</div>