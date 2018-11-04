<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\User;

if(Yii::$app->user->identity->role==User::ROLE_TEACHER || Yii::$app->user->identity->role==User::ROLE_HEAD){
    $this->title = $model->teacher->fullName;
}elseif(Yii::$app->user->identity->role==User::ROLE_STUDENT){
    $this->title = $model->student->fullName;
}
$this->params['breadcrumbs'][] = ['label' => 'Users', 'url' => ['/']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="user-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'password')->passwordInput(['maxlength' => true])->label('Old Password') ?>

    <?= $form->field($model, 'password')->passwordInput(['maxlength' => true])->label('New Password') ?>

    <?= $form->field($model, 'password')->passwordInput(['maxlength' => true])->label('Confirm Password') ?>


    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
