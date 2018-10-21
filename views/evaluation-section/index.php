<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\EvaluationSectionSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Evaluation Sections';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="evaluation-section-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Evaluation Section', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'evaluation_id',
            'section_id',
            'comment',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
