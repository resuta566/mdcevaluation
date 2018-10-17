<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Evaluation */

$this->title = 'Evaluate';
?>
<div class="card">
    <div class="card-content">
    <div class="card-header" data-background-color="blue">
            <h3>Evaluate: <?= app\models\Teacher::find()->where(['user_id' => $model->evalFor->id ])->one()->fullName ?></h3>
            <p class="title">For Subject: <b><?= $model->class->name ?></b></p>
        </div>
    <?= $this->render('_evalForm', [
        'model' => $model,
        'evalItems' => $evalItems,
    ]) ?>
    </div>
</div>