<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\EvaluationSection */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="evaluation-section-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'evaluation_id')->textInput() ?>

    <?= $form->field($model, 'section_id')->textInput() ?>

    <?= $form->field($model, 'comment')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
