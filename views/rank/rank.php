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
                <h2><?= Html::encode($this->title) ?></h2>
                <p class="simple-text">Teacher Ranking</p>
     </div>
     <div class="card-content">
     <button onclick="printContent('div1')" class="btn btn-info btn-pdfprint">Print Content</button>
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
     
    <?= $this->render('_cast',[
            'castTeachers' => $castTeachers 
        ])?>

       <!-- <?php 
       $items = [
           [
        'label'=>'<i class="glyphicon glyphicon-list-alt"></i> CAST',
        'content'=> "GAGO"
        ,
        'active'=>true
       ],
       [
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