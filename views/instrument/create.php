<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Instrument */

$this->title = 'Create Instrument';
$this->params['breadcrumbs'][] = ['label' => 'Instruments', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="card">
	 <div class="card-header" data-background-color="blue">

    <h1><?= Html::encode($this->title) ?></h1>
</div>
<div class="card-content">
    <?= $this->render('_form', [
        'modelInstrument' => $modelInstrument,
        'modelsSection' => $modelsSection,
        'modelsItem' => $modelsItem,
    ]) ?>
</div>
</div>
