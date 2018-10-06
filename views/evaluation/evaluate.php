<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use app\models\Instrument;
use app\models\Section;


/* @var $this yii\web\View */
/* @var $model app\models\Evaluation */

$this->title = 'Evaluation';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="evaluation-evaluate">

    <h1><?= Html::encode($this->title) ?></h1>

   <?php $form = ActiveForm::begin(); ?>
   
   <?php
    $instrument = Instrument::find()->where(['id' => $model->instrument_id])->one(); 
    $sections = Section::find()->where(['instrument_id' => $instrument->id])->all();
   ?>
    <?php foreach($sections as $section => $sec): ?>
    <h2><?= $sec->name; ?></h2> <br>

                <table class="table table-bordered table-hover">
                    <thead>
                        <tr class="table-primary">
                            <th ><span class="glyphicon glyphicon-tasks" style="font-size: 20px"></span> <b>Statement</b></th>
                            <th style="width: 250px; height: 30px;"><span class="glyphicon glyphicon-list" style="font-size: 20px"></span> <b>Score</b></th>
                        </tr>
                    </thead>
                    <tbody class="container-items">
                    <?php
                    
                    $items = app\models\Item::find()->where(['section_id' => $sec->id])->all();

                    ?>
                    <?php foreach($items as $evalItem => $eItem): ?>
                    <?= $res = $eItem->id; ?> 
                    <tr>
                                <td>
                                <strong><?= $eItem->statement; ?></strong>
                                </td>
                                <td>
                                   
                            
                                </td>
                            </tr>
                   
                        
                    <?php endforeach; ?>
                    <!-- <?php foreach($evalItems as $evalItem => $eItem): ?>
                            <tr>
                                <td>
                                <strong><?= $eItem->item->statement; ?></strong>
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
                                                'style'=>'height:40px;'
                                            ]) 
                                                ?>
                                </td>
                            </tr>
                        <?php endforeach; ?> -->
                    </tbody>
             </table>


    <?php endforeach; ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>
    

    <?php ActiveForm::end(); ?>

</div>