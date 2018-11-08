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
     <?php 
            ini_set('memory_limit','-1');
            echo yii\bootstrap\Tabs::widget([
            'navType' => 'nav-pills',
            'encodeLabels' => false,
            'items' => [
                [
                    'label' => 'STUDENT SCORE', 
                    'icon' => 'user',
                    'content' =>  $this->render('_scoreStudent',[
                        'model' => $model,
                        'evaluations' => $evaluations,
                        'user' => $user
                        ]),
                    'active' => true
                ],[
                    'label' => 'HEAD SCORE', 
                    'icon' => 'user',
                    'content' => $this->render('_scoreHead',[
                        'model' => $model,
                        'evaluations' => $evaluations,
                        'user' => $user
                        ]),
                ]
                ]
                ]);
                
        ?>     

    <button onclick="printContent('div1')" class="btn btn-info btn-pdfprint"><i class="glyphicon glyphicon-print"></i></button>
    
               
                
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