<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;
use yii\widgets\DetailView;
use app\models\User;
use yii\grid\GridView;
     

/* @var $this yii\web\View */

$this->title = Yii::$app->user->identity->departmentName." TEACHER RANKING";
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="card">
    <div class="card-header" data-background-color="blue">
        <div class="jem">
            <p style="font-family:Old English Text MT;font-size:20px;"> Mater Dei College
            <br>
            Tubigon,Bohol,Philippines
            <br>Teacher Evaluation <br>
            </p>
        </div>
        <div class="jem">
            <h2 style="font-family:Old English Text MT;">
           <?php
            if(Yii::$app->user->identity->department == 4){
           echo "CABM-(B & H)";
        }else if(Yii::$app->user->identity->department == 7){
            echo "High School";
        }else{
           echo  Yii::$app->user->identity->departmentName;
        }
         ?> 
              Department</h2>
        </div>
     </div>
     <div class="card-content">
     <div class="container-fluid">
        <?php echo $this->render('_deanTeacher');?>
     </div>
    
     </div>
</div>