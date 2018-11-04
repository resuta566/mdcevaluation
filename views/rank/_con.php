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

<div id="div1">

    <div class="jem">
    <p style="font-family:Old English Text MT;"> Mater Dei College
<br>
     Tubigon,Bohol,Philippines
     <br>Teacher Evaluation <br>
      CON Department</p>
    </div>

<br>
<div>
    <?php
        $data = array(array(),array());
        $score = array();
        $itemAve;
        $averageScore = 0;
        $scores;
        
        $sectScore = 0; 
        $me = 0;
        $mee = 0;
        
        $sectionScore = array();
        $itemScore = array();
        foreach($teachers as $indexTeacher => $teacher):

        $evaluation = Evaluation::find()->where(['eval_for' => $teacher->id])->one();
        if(!$evaluation){
        
        }else{
        Teacher::find()->where(['user_id' => $teacher->id])->one(); 
            $inst = Instrument::find()->where(['id' => $evaluation->instrument->id])->one(); 


            $sect = Section::find()->where(['instrument_id' => $inst->id]); 
                            foreach($sect->all() as $se => $s):
                                $sectItems = Item::find()->where(['section_id' => $s->id]);
                                $sectScroore = 0; 
                                                foreach($sectItems->all() as $secI => $sI): 
                                                        
                                                        $sql1 = 'SELECT evaluation.id as "Evaluation ID",
                                                        evaluation_section.id as "Evaluation Section ID", 
                                                        evaluation_item.id as "Evaluation Item ID", 
                                                        evaluation_item.score as "SCORE" 
                                                        FROM `evaluation` 
                                                        INNER JOIN (evaluation_section,evaluation_item) 
                                                        ON evaluation.eval_for = '. $teacher->id .' 
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
                                                        ON evaluation.eval_for = '. $teacher->id .' 
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
                                                        ON evaluation.eval_for = '. $teacher->id .' 
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
                                                        ON evaluation.eval_for = '. $teacher->id .' 
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
                                                        ON evaluation.eval_for = '. $teacher->id .' 
                                                        WHERE evaluation_section.evaluation_id = evaluation.id 
                                                        AND evaluation_item.evaluation_section_id = evaluation_section.id 
                                                        AND evaluation_item.item_id = '.$sI->id .' 
                                                        AND evaluation_item.score = 5';

                                                        $itemScore[0] = Evaluation::findBySql($sql1)->count();
                                                        $itemScore[1] = Evaluation::findBySql($sql2)->count();
                                                        $itemScore[2] = Evaluation::findBySql($sql3)->count();
                                                        $itemScore[3] = Evaluation::findBySql($sql4)->count();
                                                        $itemScore[4] = Evaluation::findBySql($sql5)->count();
                                                            
                                                        
                                                        
                                                    
                                                    $itemCount = $itemScore[0]+$itemScore[1]+$itemScore[2]+$itemScore[3]+$itemScore[4];
                                                    
                                                    if(!$itemCount==0){
                                                        
                                                    $itemAve =
                                                    (($itemScore[0]*1)+($itemScore[1]*2)+($itemScore[2]*3)+($itemScore[3]*4)+($itemScore[4]*5))/$itemCount;
                                                    
                                                            
                                                    $sectScore += $itemAve;
                                                    }
                                                    
                                                endforeach; 
                                                $sectionScorenotAve[$se] = $sectScore;
                                                $sectionScore[$se] = number_format((float) $sectionScorenotAve[$se]/$sectItems->count(),2, '.', '');
                                                $sectScore = 0;

                                $mee += ($sectionScore[$se]*$sectItems->count()); 
                                
                                
                                $me +=$sectItems->count();
                            endforeach; 
                    " AVERAGE SCORE: ". $teacher->teacher->fullname."-".$averageScore = $mee/$me; 
                    $name = $teacher->teacher->fullname; 
                    $data[$indexTeacher]['id'] = $teacher->teacher->id;
                    $data[$indexTeacher]['name'] = $name;
                    $data[$indexTeacher]['score'] = $averageScore;
                    
                    $averageScore = 0;
                    $mee = 0;
                    $me = 0;
                                
        }
                    endforeach; 
                    $data;
                //    print_r($data); 
                //     die();
                echo"<table class='table'>";
                echo "<thead>";
                echo "<tr>";
                echo "<th> Teacher Name </th>";
                echo "<th> Score </th>";
                echo "</tr>";
                echo "</thead>";
                echo "<tbody>";
                if(!empty($data) && !in_array(null,$data)){
                    usort($data, function ($a, $b) {
                        if ($a['score'] === $b['score']) {
                            return 0;
                        }
                        return ($a['score'] < $b['score']) ? 1 : -1;
                         });
                for($i=0;$i<count($data);$i++) {
                    echo('<tr>');
                    echo('<td>' . Html::a($data[$i]['name'], ['teacher/view','id'=> $data[$i]['id']], ['target' => '_blank']) . '</td>');
                    echo('<td style="width: 20%">' . $data[$i]['score'] . '</td>');
                    echo('</tr>');
                }
            }
                echo "</tbody>";
                echo "</table>";
                    
                    ?>
            </div>
</div>