<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\StudentSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="student-search">

    <?php $form = ActiveForm::begin([
        'action' => ['list'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'studentSearch') ?>

    <!-- <?= $form->field($model, 'lname') ?>

    <?= $form->field($model, 'fname') ?>

    <?= $form->field($model, 'mname') ?>

    <?= $form->field($model, 'gender') ?> -->

    <?php // echo $form->field($model, 'user_id') ?>

    <div class="form-group">
    <?= Html::a('BACK', ['index'], ['class' => 'btn btn-default']) ?>
        <?= Html::submitButton('Search', ['class' => 'btn btn-info']) ?>
        <!-- <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?> -->
    </div>

    <?php ActiveForm::end(); ?>

</div>
