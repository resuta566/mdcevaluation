<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\UserSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="user-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'userSearch') ?>

    <!-- <?= $form->field($model, 'username') ?> -->

    <!-- <?= $form->field($model, 'password') ?> -->

    <!-- <?= $form->field($model, 'authkey') ?> -->

    <!-- <?= $form->field($model, 'role') ?> -->

    <?php // echo $form->field($model, 'status') ?>

    <?php // echo $form->field($model, 'department') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <!-- <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?> -->
    </div>

    <?php ActiveForm::end(); ?>

</div>
