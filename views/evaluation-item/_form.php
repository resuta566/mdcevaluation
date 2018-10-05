<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Evaluationitem */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="evaluationitem-form">

    <?php $form = ActiveForm::begin(); ?>

    <!-- <?= $form->field($model, 'evaluation_id')->textInput(['readOnly'=> true]) ?> -->

    <table class="table table-bordered table-striped">
   <thead>
       <tr>
           <th ><span class="glyphicon glyphicon-tasks" style="font-size: 20px"></span> <b>Statement</b></th>
           <th style="width: 250px; height: 30px;"><span class="glyphicon glyphicon-list" style="font-size: 20px"></span> <b>Score</b></th>
       </tr>
   </thead>
   <tbody class="container-items">
   <tr class="height: 30px;">
   <td class="vcenter"><?= $model->item->statement; ?></td>
   <td>
   <?= $form->field($model, 'score')->inline(true)->radioList([
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
   </tbody>
   </table>
   

    
    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
