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
<div class="card">
    <div class="card-header" data-background-color="blue">
                <h2><?= Html::encode($this->title) ?></h2>
                <p class="simple-text">Teacher Ranking</p>
     </div>
     <div class="card-content">
     <?= Html::beginForm(['prints'],'post');?>
             <?php
                $dept_list = array(
                    1 => 'COLLEGE',
                    7 => 'Senior High School',
                    8 => 'Junior High School',
                    9 => 'Elementary'
                );
                ?>
             <?=  Html::dropDownList('userDepartment', null, $dept_list,
                        [
                            'class' => 'form-control', 
                            'prompt'=>'Choose a Department'
                        ]) ?>
              <?=   Html::submitButton('Print', [
                        'class' => 'btn btn-info',
                        'data' => [
                            'method' => 'post',
                        ],
                    ]) ?>
        <?= Html::endForm();?>

     <?php 
      $castTeachers = User::find()->where(['department' => [1,2,3,4,5,6,]])->andWhere(['role' => [20,30]])->all();
      $coeTeachers = User::find()->where(['department' => 2])->andWhere(['role' => [20,30]])->all();
      $cabmhTeachers = User::find()->where(['department' => 3])->andWhere(['role' => [20,30]])->all();
      $cabmbTeachers = User::find()->where(['department' => 4])->andWhere(['role' => [20,30]])->all();
      $conTeachers = User::find()->where(['department' => 5])->andWhere(['role' => [20,30]])->all();
      $ccjTeachers = User::find()->where(['department' => 6])->andWhere(['role' => [20,30]])->all();
      $shsTeachers = User::find()->where(['department' => 7])->andWhere(['role' => [20,30]])->all();
      $jhsTeachers = User::find()->where(['department' => 8])->andWhere(['role' => [20,30]])->all();
      $elemTeachers = User::find()->where(['department' => 9])->andWhere(['role' => [20,30]])->all();
     ?>
            <div >
            <?php 
            ini_set('memory_limit','-1');
            echo yii\bootstrap\Tabs::widget([
            'navType' => 'nav-pills',
            'encodeLabels' => false,
            'items' => [
                [
                    'label' => 'COLLEGE', 
                    'icon' => 'user',
                    'content' => $this->render('_cast',[
                        'castTeachers' => $castTeachers 
                    ]),
                    'active' => true
                ],[
                    'label' => 'SHS', 
                    'icon' => 'user',
                    'content' => $this->render('_shs',[
                        'teachers' => $shsTeachers 
                    ]),
                ],[
                    'label' => 'JHS', 
                    'icon' => 'user',
                    'content' => $this->render('_jhs',[
                        'teachers' => $jhsTeachers 
                    ]),
                ],[
                    'label' => 'ELEMENTARY', 
                    'icon' => 'user',
                    'content' => $this->render('_elem',[
                        'teachers' => $elemTeachers 
                    ]),
                ],
                ]
                ]);
                
        ?>     
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