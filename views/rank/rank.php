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
    <?= Html::a('Print', ['prints'], [
        'class' => 'btn btn-success',
        'target' => '_blank'
        ]) ?>
     <button onclick="printContent('div1')" class="btn btn-info btn-pdfprint"><i class="glyphicon glyphicon-print" style="font-size: 20px"></i></button>
     <?php 
      $castTeachers = User::find()->where(['department' => 1])->andWhere(['role' => [20,30,100]])->all();
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
            <?php echo yii\bootstrap\Tabs::widget([
            'navType' => 'nav-pills',
            'encodeLabels' => false,
            'items' => [
                [
                    'label' => 'CAST', 
                    'icon' => 'user',
                    'content' => $this->render('_cast',[
                        'castTeachers' => $castTeachers 
                    ]),
                    'active' => true
                ],[
                    'label' => 'COE', 
                    'icon' => 'user',
                    'content' => $this->render('_coe',[
                        'teachers' => $coeTeachers 
                    ]),
                ],[
                    'label' => 'CABM-B', 
                    'icon' => 'user',
                    'content' => $this->render('_cabmb',[
                        'teachers' => $cabmbTeachers 
                    ]),
                ],[
                    'label' => 'CABM-H', 
                    'icon' => 'user',
                    'content' => $this->render('_cabmh',[
                        'teachers' => $cabmhTeachers 
                    ]),
                ],[
                    'label' => 'CON', 
                    'icon' => 'user',
                    'content' => $this->render('_con',[
                        'teachers' => $conTeachers 
                    ]),
                ],[
                    'label' => 'CCJ', 
                    'icon' => 'user',
                    'content' => $this->render('_ccj',[
                        'teachers' => $ccjTeachers 
                    ]),
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