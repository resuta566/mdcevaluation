<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\EvaluationSection */

$this->title = 'Update Evaluation Section: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Evaluation Sections', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="evaluation-section-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
