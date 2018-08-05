<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Head */

$this->title = 'Create Head';
$this->params['breadcrumbs'][] = ['label' => 'Heads', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="head-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
