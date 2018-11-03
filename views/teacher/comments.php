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
use app\models\Item;
use app\models\Classes;
use yii\grid\GridView;
use kartik\tabs\TabsX;
     

/* @var $this yii\web\View */
/* @var $model app\models\Teacher */

$this->title = "Evaluation Feedback for ".  $model->getFullName();
$this->params['breadcrumbs'][] = ['label' => 'Teachers', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="card" id="div1">
    <div class="card-header" data-background-color="blue">
                <h1><?= Html::encode($this->title) ?></h1>
                <p class="simple-text">Teacher Details</p>
     </div>
     <div class="card-content">
     

    <button onclick="printContent('div1')" class="btn btn-info btn-pdfprint"><i class="glyphicon glyphicon-print"></i></button>
    <?php $score = array();?>
    <?php $itemAve;?>
    <?php $scores;?>
    <?php 
    $sectScore = 0; 
    $me = 0;
    $mee = 0;
    ?>
    <?php $sectionScore = array();?>
    <?php $itemScore = array();?>
    <?php  $evaluation = Evaluation::find()->where(['eval_for' => $model->user->id])->one(); ?>
        <?php $inst = Instrument::find()->where(['id' => $evaluation->instrument->id])->one(); ?>
        <?php $sect = Section::find()->where(['instrument_id' => $inst->id]); ?>
        <table class="table table-bordered table-striped">
            <thead>
            </thead>
            <tbody class="container-items">
                        <?php foreach($sect->all() as $se => $s):?>
                            <?php $sectItems = Item::find()->where(['section_id' => $s->id]) ?>
                            <?php $sectScroore = 0; ?>
                            <tr>
                                <td>
                                <h2>
                                <?= $s->name;?> 
                                </h2>
                                <?= $s->description;?>
                                <table class="table table-bordered">
                                    <thead>
                                    </thead>
                                        <tbody>
                                        
                                        <?php
                                            $oComment = 'SELECT evaluation_section.comment as "comment",
                                            evaluation_section.id as "Evaluation Section id" 
                                            FROM `evaluation_section` 
                                            INNER JOIN evaluation 
                                            ON evaluation.eval_for = '.$model->user->id.'
                                            WHERE evaluation_section.evaluation_id = evaluation.id 
                                            AND evaluation_section.section_id = '.$s->id.'';

                                            $evalCom = Yii::$app->db->createCommand($oComment)
                                            ->queryAll();
                                            ?>
                                            
                                        <?php foreach($evalCom as $index => $comments) :?>
                                        <tr>
                                        <td>
                                       <?= $comments['comment'];  ?>
                                       </td>
                                        </tr>
                                        <?php endforeach; ?>
                                        
                                        </tbody>
                                    </table>
                                </td>
                            </tr>

                        <?php endforeach; ?>
                        
                </tbody>
                </table>
                
                <div class="pull-right">
                <h1>
                </h1>
                </div>
                
      </div>
 </div>
 <script>
      function printContent(el)
      {
         var restorepage = document.body.innerHTML;
         var printcontent = document.getElementById(el).innerHTML;
         document.body.innerHTML = printcontent;
         window.print();
         document.body.innerHTML = restorepage;
     }
   </script>