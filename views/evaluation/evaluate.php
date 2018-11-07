<?php
use app\models\User;
use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Evaluation */

$this->title = 'Evaluate';
?>
<div class="card">
    <div class="card-content">
    <div class="card-header" data-background-color="blue">
            <h2>Evaluate: <?= app\models\Teacher::find()->where(['user_id' => $model->evalFor->id ])->one()->fullName ?></h2>
            <?php if(Yii::$app->user->identity->role == app\models\User::ROLE_STUDENT): ?>
            <p class="title">For Subject: <b><?= $model->class->name ?></b></p>
    <?php endif;?>
        </div>
        <center>
        <strong>
        <?php
        if(Yii::$app->user->identity->role== User::ROLE_HEAD){
            echo '<h2>Head\'s Evaluation of Faculty</h2>';
        }else{
            echo '<h2>Student\'s Evaluation of Faculty</h2>';
        }
        ?>
        </strong>
        </center>
        <br>
    <?= $this->render('_evalForm', [
        'model' => $model,
        'evalSections' => $evalSections,
        'evalItems' => $evalItems,
    ]) ?>
    </div>
</div>