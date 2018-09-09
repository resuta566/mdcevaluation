<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\StudentClass */

$this->title = 'Create Student Class';
$this->params['breadcrumbs'][] = ['label' => 'Student Classes', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="student-class-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
