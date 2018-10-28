<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\TeacherSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="teacher-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'options' => [
            'data-pjax' => 1
        ],
    ]); ?>

    <table class="table table-striped">

<tr>
    
    <?php
            $dept_list = array(
                1 => 'CAST',
                2 => 'COE',
                3 => 'CABM-H',
                4 => 'CABM-B',
                5 => 'CON',
                6 => 'CCJ',
                7 => 'Senior High School',
                8 => 'Junior High School',
                9 => 'Elementary'
            );
            ?>
    <th style="width: 20%"><?= $form->field($model, 'teacherRole')->dropDownList(
        $dept_list,
        [
            'prompt'=>'Select Department'
            ]   
    );

?></th>
<th> <?= $form->field($model, 'teacherSearch') ?></th>
<tr>
</table>

    <!-- <?= $form->field($model, 'lname') ?> -->

    <!-- <?= $form->field($model, 'fname') ?> -->

    <!-- <?= $form->field($model, 'mname') ?> -->

    <!-- <?= $form->field($model, 'gender') ?> -->

    <?php // echo $form->field($model, 'user_id') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <!-- <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?> -->
    </div>

    <?php ActiveForm::end(); ?>

</div>
