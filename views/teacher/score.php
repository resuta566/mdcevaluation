<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;
use yii\widgets\DetailView;
use app\models\Teacher;
use app\models\Instrument;
use app\models\Section;
use app\models\Classes;
use yii\grid\GridView;
use kartik\tabs\TabsX;

/* @var $this yii\web\View */
/* @var $model app\models\Teacher */

$this->title = $model->getFullName()."'s Score";
$this->params['breadcrumbs'][] = ['label' => 'Teachers', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="card">
    <div class="card-header" data-background-color="blue">
                <h1><?= Html::encode($this->title) ?></h1>
                <p class="simple-text">Teacher Details</p>
     </div>
     <div class="card-content">
     </div>
</div>