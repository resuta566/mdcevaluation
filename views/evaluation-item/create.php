<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Evaluationitem */

$this->title = 'Create Evaluationitem';
$this->params['breadcrumbs'][] = ['label' => 'Evaluationitems', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="evaluationitem-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
