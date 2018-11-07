<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\User;

if(Yii::$app->user->identity->role== User::ROLE_ADMIN || Yii::$app->user->identity->role== User::ROLE_HEAD || Yii::$app->user->identity->role== User::ROLE_TEACHER){
    $titles = Yii::$app->user->identity->teacher->fullName;
}else{
    $titles = Yii::$app->user->identity->student->fullName;
}
$this->title = $titles;
$this->params['breadcrumbs'][] = ['label' => 'Users', 'url' => ['/']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-changepassword">
    
    <p>Please fill out the following fields to change password :</p>
    
    <?php $form = ActiveForm::begin([
        'id'=>'changepassword-form',
        'options'=>['class'=>'form-horizontal'],
        'fieldConfig'=>[
            'template'=>"{label}\n<div class=\"col-lg-3\">
                        {input}</div>\n<div class=\"col-lg-5\">
                        {error}</div>",
            'labelOptions'=>['class'=>'col-lg-2 control-label'],
        ],
    ]); ?>
        <?= $form->field($model,'oldpass')->passwordInput([
                                'autofocus'=>true,
                                'placeholder' =>'Current Password',
                                ])->label(false) ?>
        
        <?= $form->field($model,'newpass')->passwordInput([
                                'placeholder' =>'New Password',
                                ])->label(false) ?>
        
        <?= $form->field($model,'repeatnewpass')->passwordInput([
                                'placeholder' =>'Repeat New Password',
                                ])->label(false) ?>
        
        <div class="form-group">
            <div class="col-lg-offset-1 col-lg-11">
                <?= Html::submitButton('Change password',[
                    'class'=>'btn btn-primary'
                ]) ?>
            </div>
        </div>
    <?php ActiveForm::end(); ?>
</div>
