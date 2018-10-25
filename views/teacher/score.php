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

$this->title = $model->getFullName()."'s Score";
$this->params['breadcrumbs'][] = ['label' => 'Teachers', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="card" id="div1">
    <div class="card-header" data-background-color="blue">
                <h1><?= Html::encode($this->title) ?></h1>
                <p class="simple-text">Teacher Details</p>
     </div>
     <div class="card-content">
     

    <button onclick="printContent('div1')" class="btn btn-info btn-pdfprint">Print Content</button>
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
                                    <table class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>Statement</th>
                                            <th>Score</th>
                                        </tr>
                                    </thead>
                                        <tbody>
                                            <?php foreach($sectItems->all() as $secI => $sI):?>
                                            <tr>
                                                <td for="statement">  
                                                    <?= $sI->statement  ?>
                                                </td>
                                                <td for="score">  
                                                    <?php 
                                                    $sql1 = 'SELECT evaluation.id as "Evaluation ID",
                                                    evaluation_section.id as "Evaluation Section ID", 
                                                    evaluation_item.id as "Evaluation Item ID", 
                                                    evaluation_item.score as "SCORE" 
                                                    FROM `evaluation` 
                                                    INNER JOIN (evaluation_section,evaluation_item) 
                                                    ON evaluation.eval_for = '. $model->user->id .' 
                                                    WHERE evaluation_section.evaluation_id = evaluation.id 
                                                    AND evaluation_item.evaluation_section_id = evaluation_section.id 
                                                    AND evaluation_item.item_id = '.$sI->id .' 
                                                    AND evaluation_item.score = 1';

                                                    $sql2 = 'SELECT evaluation.id as "Evaluation ID",
                                                    evaluation_section.id as "Evaluation Section ID", 
                                                    evaluation_item.id as "Evaluation Item ID", 
                                                    evaluation_item.score as "SCORE" 
                                                    FROM `evaluation` 
                                                    INNER JOIN (evaluation_section,evaluation_item) 
                                                    ON evaluation.eval_for = '. $model->user->id .' 
                                                    WHERE evaluation_section.evaluation_id = evaluation.id 
                                                    AND evaluation_item.evaluation_section_id = evaluation_section.id 
                                                    AND evaluation_item.item_id = '.$sI->id .' 
                                                    AND evaluation_item.score = 2';

                                                    $sql3 = 'SELECT evaluation.id as "Evaluation ID",
                                                    evaluation_section.id as "Evaluation Section ID", 
                                                    evaluation_item.id as "Evaluation Item ID", 
                                                    evaluation_item.score as "SCORE" 
                                                    FROM `evaluation` 
                                                    INNER JOIN (evaluation_section,evaluation_item) 
                                                    ON evaluation.eval_for = '. $model->user->id .' 
                                                    WHERE evaluation_section.evaluation_id = evaluation.id 
                                                    AND evaluation_item.evaluation_section_id = evaluation_section.id 
                                                    AND evaluation_item.item_id = '.$sI->id .' 
                                                    AND evaluation_item.score = 3';

                                                    $sql4 = 'SELECT evaluation.id as "Evaluation ID",
                                                    evaluation_section.id as "Evaluation Section ID", 
                                                    evaluation_item.id as "Evaluation Item ID", 
                                                    evaluation_item.score as "SCORE" 
                                                    FROM `evaluation` 
                                                    INNER JOIN (evaluation_section,evaluation_item) 
                                                    ON evaluation.eval_for = '. $model->user->id .' 
                                                    WHERE evaluation_section.evaluation_id = evaluation.id 
                                                    AND evaluation_item.evaluation_section_id = evaluation_section.id 
                                                    AND evaluation_item.item_id = '.$sI->id .' 
                                                    AND evaluation_item.score = 4';

                                                    $sql5 = 'SELECT evaluation.id as "Evaluation ID",
                                                    evaluation_section.id as "Evaluation Section ID", 
                                                    evaluation_item.id as "Evaluation Item ID", 
                                                    evaluation_item.score as "SCORE" 
                                                    FROM `evaluation` 
                                                    INNER JOIN (evaluation_section,evaluation_item) 
                                                    ON evaluation.eval_for = '. $model->user->id .' 
                                                    WHERE evaluation_section.evaluation_id = evaluation.id 
                                                    AND evaluation_item.evaluation_section_id = evaluation_section.id 
                                                    AND evaluation_item.item_id = '.$sI->id .' 
                                                    AND evaluation_item.score = 5';

                                                    $itemScore[0] = Evaluation::findBySql($sql1)->count();
                                                    $itemScore[1] = Evaluation::findBySql($sql2)->count();
                                                    $itemScore[2] = Evaluation::findBySql($sql3)->count();
                                                    $itemScore[3] = Evaluation::findBySql($sql4)->count();
                                                    $itemScore[4] = Evaluation::findBySql($sql5)->count();
                                                        
                                                    ?>
                                                    
                                                <?php 
                                                $itemAve =
                                                (($itemScore[0]*1)+($itemScore[1]*2)+($itemScore[2]*3)+($itemScore[3]*4)+($itemScore[4]*5))/($itemScore[0]+$itemScore[1]+$itemScore[2]+$itemScore[3]+$itemScore[4])
                                                ?>
                                                <?= $itemAve ?>
                                                <?php $sectScore += $itemAve?>
                                                </td>
                                            </tr>
                                            <?php endforeach; ?>
                                            
                                            <?php $sectionScorenotAve[$se] = $sectScore?>
                                            <?php $sectionScore[$se] = number_format((float) $sectionScorenotAve[$se]/$sectItems->count(),2, '.', '');?>
                                            <?php echo "SCORE: ". $sectionScore[$se] ?>
                                            <?php $sectScore = 0;?>
                                        </tbody>
                                    </table>
                                </td>
                            </tr>

                            <?php $mee += ($sectionScore[$se]*$sectItems->count()) ?>
                            <?php $me +=$sectItems->count()?>
                        <?php endforeach; ?>
                        
                </tbody>
                </table>
                
                <div class="pull-right">
                <h1>
                <?= " AVERAGE SCORE: ".$mee/$me ?>
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