<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Head */

$this->title = 'Update Head: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Heads', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="head-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
