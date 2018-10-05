<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;


/* @var $this yii\web\View */
/* @var $model app\models\Evaluation */

$this->title = 'Evaluation';
$this->params['breadcrumbs'][] = ['label' => 'Evaluations', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="evaluation-evaluate">

    <h1><?= Html::encode($this->title) ?></h1>

   <?php $form = ActiveForm::begin(); ?>
   <table class="table table-bordered table-striped">
   <thead>
       <tr>
           <th ><span class="glyphicon glyphicon-tasks" style="font-size: 20px"></span> <b>Statement</b></th>
           <th style="width: 250px; height: 30px;"><span class="glyphicon glyphicon-list" style="font-size: 20px"></span> <b>Score</b></th>
       </tr>
   </thead>
   <tbody class="container-items">
    <?php foreach($evalItems as $evalItem => $eItem): ?>
    <tr>
    <td>
    <?= $eItem->item->statement; ?>
    </td>
    <td>
    <?= $form->field($eItem, "[{$evalItem}]score")->inline(true)->radioList([
        '1'=>'1',
        '2'=>'2',
        '3'=>'3',
        '4'=>'4',
        '5'=>'5'
            ],
            [
                'style'=>'height:40px'
             ]) 
                ?>
    </td>
     </tr>
    <?php endforeach; ?>
   </tbody>
    </table>
    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>
    

    <?php ActiveForm::end(); ?>

</div>