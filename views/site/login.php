<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Login';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-login" align="center">
<div class="card card-nav-tabs text-center"  style=" width : 500px;">
<img class="card-img" src="<?= Yii::$app->request->baseUrl ?>/img/mdclogo.png" style="width: 200px; height: 200px;"  alt="Card image cap"/>
<div class="card-img-overlay">
    <!-- <div class="card-header ">
  <h1><?= Html::encode($this->title) ?></h1>
  </div>
     -->

    <p>Sign in</p>
    <?php $form = ActiveForm::begin([
        'id' => 'login-form',
        // 'layout' => 'horizontal',
        'fieldConfig' => [
            // 'template' => "<div style=\"align: center \" class=\"col-lg-14 \">{input}{error}</div>",
            // " \n<div style=\"align: center \" class=\"col-lg-7 \">{input}</div>\n
            // <div <div class=\"col-lg-7\">{error}</div>",
            'labelOptions' => ['class' => 'col-lg-1 control-label'],
        ],
    ]); ?>
        <?= $form->field($model, 'username', ['options' => [
                         'tag' => 'div',
                            'class' => 'form-group'
                        ],
                            'labelOptions' => [ 
                                'class' => 'control-label' ,
                            ],
                            'template' => "<div class=\"input-group \">
                            <span class=\"input-group-addon col-lg-offset-5 col-lg-13\">
                            <div class=\"row col-lg-12 \">
                            <span style=\"font-size:25px;\" class=\"glyphicon glyphicon-user\"></span>
                            {input}{error}</div>
                            </span></div>", 
                ])->textInput([
                                'autofocus'=>true,
                                'type' => 'username', 
                                'placeholder' =>'Username / ID Number',
                                ]) ?>

        <?= $form->field($model, 'password', ['options' => [
                         'tag' => 'div',
                            'class' => 'form-group'
                        ],
                            'labelOptions' => [ 
                                'class' => 'control-label '
                            ],
                            'template' => "<div class=\"input-group \">
                            <span class=\"input-group-addon col-lg-offset-5 col-lg-13\">
                            <div class=\"row col-lg-12 \"><i style=\"font-size:25px;\" class=\"glyphicon glyphicon-pencil\">
                            </i>{input}{error}</div>
                            </span></div>",
                            ])->passwordInput([
                                    'class' => 'form-control',
                                    'placeholder' => 'Password'
                                    ]) ?>

        <?= $form->field($model, 'rememberMe',['options' =>[
            'class' => 'check-box',
        ] 
        ])->checkbox([
            'name' => 'optionsCheckboxes']) ?>

        <div class="form-group">
            <div class="col-lg-offset-1 col-lg-10">
                <?= Html::submitButton('Sign in', ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>
            </div>
        </div>
    <?php ActiveForm::end(); ?>

   
   
    </div>
    
    </div>
    <p>&copy; MDC Teachers Evaluation <?= date('Y') ?> 
    Powered by <a target="_blank" href="https://www.facebook.com/m3is.tr">Resuta</a></p>

    </div>
</div>