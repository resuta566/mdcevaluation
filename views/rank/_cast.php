<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;
use yii\widgets\DetailView;
use app\models\Teacher;
use app\models\User;
use app\models\Evaluation;
use app\models\EvaluationSection;
use app\models\EvaluationItem;
use app\models\Instrument;
use app\models\Section;
use app\models\Item;
use app\models\Classes;
use yii\grid\GridView;
use kartik\tabs\TabsX;
    
?>
<?php 
     $data = array(array(),array());
     $score = array();?>
    <?php $itemAve;?>
    <?php 
        $averageScore = 0;
        ?>
    <?php $scores;?>
    <?php 
    $sectScore = 0; 
    $me = 0;
    $mee = 0;
    ?>
    <?php $sectionScore = array();?>
    <?php $itemScore = array();?>
    <?php foreach($castTeachers as $indexCastTeac => $casTeacher):?>
    <?php  $evaluation = Evaluation::find()->where(['eval_for' => $casTeacher->id])->one(); ?>
    <?php Teacher::find()->where(['user_id' => $casTeacher->id])->one() ?>
        <?php $inst = Instrument::find()->where(['id' => 1])->one(); ?>
        <?php $sect = Section::find()->where(['instrument_id' => $inst->id]); ?>
                        <?php foreach($sect->all() as $se => $s):?>
                            <?php $sectItems = Item::find()->where(['section_id' => $s->id]) ?>
                            <?php $sectScroore = 0; ?>
                                            <?php foreach($sectItems->all() as $secI => $sI):?> 
                                                    <?php 
                                                    $sql1 = 'SELECT evaluation.id as "Evaluation ID",
                                                    evaluation_section.id as "Evaluation Section ID", 
                                                    evaluation_item.id as "Evaluation Item ID", 
                                                    evaluation_item.score as "SCORE" 
                                                    FROM `evaluation` 
                                                    INNER JOIN (evaluation_section,evaluation_item) 
                                                    ON evaluation.eval_for = '. $casTeacher->id .' 
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
                                                    ON evaluation.eval_for = '. $casTeacher->id .' 
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
                                                    ON evaluation.eval_for = '. $casTeacher->id .' 
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
                                                    ON evaluation.eval_for = '. $casTeacher->id .' 
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
                                                    ON evaluation.eval_for = '. $casTeacher->id .' 
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
                                                $itemCount = $itemScore[0]+$itemScore[1]+$itemScore[2]+$itemScore[3]+$itemScore[4];
                                                ?>
                                                <?php if(!$itemCount==0){?>
                                                    <?php
                                                $itemAve =
                                                (($itemScore[0]*1)+($itemScore[1]*2)+($itemScore[2]*3)+($itemScore[3]*4)+($itemScore[4]*5))/$itemCount
                                                ?>
                                                        
                                                <?php $sectScore += $itemAve?>
                                                <?php }?>
                                                
                                            <?php endforeach; ?>
                                            <?php $sectionScorenotAve[$se] = $sectScore?>
                                            <?php $sectionScore[$se] = number_format((float) $sectionScorenotAve[$se]/$sectItems->count(),2, '.', '');?>
                                            <?php $sectScore = 0;?>

                            <?php $mee += ($sectionScore[$se]*$sectItems->count()) ?>
                            <?php 
                            
                            $me +=$sectItems->count()?>
                        <?php endforeach; ?>
                <?php " AVERAGE SCORE: ". $casTeacher->teacher->fullname."-".$averageScore = $mee/$me; ?>
                <?php $name = $casTeacher->teacher->fullname ?>
                <?php $data[$indexCastTeac]['name'] = $name?>
                <?php $data[$indexCastTeac]['score'] = $averageScore?>
                <?php 
                $averageScore = 0;
                $mee = 0;?>
                <?php $me = 0;?>
                
                <?php endforeach; ?>
                <?php $data ?>
                <?php 
                usort($data, function ($a, $b) {
                    if ($a['score'] === $b['score']) {
                        return 0;
                    }
                    return ($a['score'] < $b['score']) ? 1 : -1;
                });
                echo"<table class='table'>";
                echo "<thead>";
                echo "<tr>";
                echo "<th> Teacher Name </th>";
                echo "<th> Score </th>";
                echo "</tr>";
                echo "</thead>";
                echo "<tbody>";
                for($i=0;$i<count($data);$i++) {
                    echo('<tr>');
                    echo('<td>' . $data[$i]['name'] . '</td>');
                    echo('<td style="width: 20%">' . $data[$i]['score'] . '</td>');
                    echo('</tr>');
                  }
                echo "</tbody>";
                echo "</table>";
                ?>