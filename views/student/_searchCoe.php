<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\TeacherSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="teacher-search">

    <?php $form = ActiveForm::begin([
        'action' => ['student-department', 'department' => 2],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'teacherSearch')->label('Student Search') ?>

    <!-- <?= $form->field($model, 'lname') ?> -->

    <!-- <?= $form->field($model, 'fname') ?> -->

    <!-- <?= $form->field($model, 'mname') ?> -->

    <!-- <?= $form->field($model, 'gender') ?> -->

    <?php // echo $form->field($model, 'user_id') ?>

    <div class="form-group">
        <!-- <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?> -->
        <!-- <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?> -->
    </div>

    <?php ActiveForm::end(); ?>

</div>