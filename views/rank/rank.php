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
     

/* @var $this yii\web\View */
/* @var $model app\models\Teacher */

$this->title = "TEACHER RANKING";
$this->params['breadcrumbs'][] = ['label' => 'Teachers', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="card" id="div1">
    <div class="card-header" data-background-color="blue">
                <h1><?= Html::encode($this->title) ?></h1>
                <p class="simple-text">Teacher Ranking</p>
     </div>
     <div class="card-content">
     <?php 
      $castTeachers = User::find()->where(['department' => 1])->andWhere(['role' => 20])->orWhere(['role' => 100])->all();
      $coeTeachers = User::find()->where(['department' => 2])->andWhere(['role' => 20])->all();
      $cabmhTeachers = User::find()->where(['department' => 3])->andWhere(['role' => 20])->all();
      $cabmbTeachers = User::find()->where(['department' => 4])->andWhere(['role' => 20])->all();
      $conTeachers = User::find()->where(['department' => 5])->andWhere(['role' => 20])->all();
      $ccjTeachers = User::find()->where(['department' => 6])->andWhere(['role' => 20])->all();
      $shsTeachers = User::find()->where(['department' => 7])->andWhere(['role' => 20])->all();
      $jhsTeachers = User::find()->where(['department' => 8])->andWhere(['role' => 20])->all();
      $elemTeachers = User::find()->where(['department' => 9])->andWhere(['role' => 20])->all();
     ?>

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
    <?php foreach($castTeachers as $indexCastTeac => $casTeacher):?>
    <?php  $evaluation = Evaluation::find()->where(['eval_for' => $casTeacher->id])->one(); ?>
    <?= Teacher::find()->where(['user_id' => $casTeacher->id])->one()->fullName." " ?>
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
                            <?php $me +=$sectItems->count()?>
                        <?php endforeach; ?>
                <?= " AVERAGE SCORE: ".$mee/$me ?>
                <?php $mee = 0;?>
                <?php $me = 0;?>
                <?php endforeach; ?>







       <!-- <?php 
       $items = [
           [
        'label'=>'<i class="glyphicon glyphicon-list-alt"></i> CAST',
        'content'=> "ACTIVE",
        'active'=>true
       ],[
        'label'=>'<i class="glyphicon glyphicon-list-alt"></i> COE',
        'content'=> "INACTIVE",
       ],
       [
        'label'=>'<i class="glyphicon glyphicon-list-alt"></i> CABM-H',
        'content'=> "INACTIVE",
       ],[
        'label'=>'<i class="glyphicon glyphicon-list-alt"></i> CABM-B',
        'content'=> "INACTIVE",
       ],[
        'label'=>'<i class="glyphicon glyphicon-list-alt"></i> CON',
        'content'=> "INACTIVE",
       ],[
        'label'=>'<i class="glyphicon glyphicon-list-alt"></i> CCJ',
        'content'=> "INACTIVE",
       ],
    ];
       echo TabsX::widget([
    'items'=>$items,
    'position'=>TabsX::POS_ABOVE,
    'encodeLabels'=>false
]);
?> -->
     </div>
</div>