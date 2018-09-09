<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\ClassesSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Classes';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="classes-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Classes', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            // 'id',
            [ 'attribute' => 
                   'name', 
                   'label' => 'Name',
                   'format' => 'raw', 
                   'value' => 
                   function ($model) {
                   return Html::a($model->name, 
                   [ 'classes/view', 'id' => $model->id ], [
                       'target' => '_blank']
                       );
                   },
               ],
            
            'description:ntext',
            'day',
            'time',
            //'teacher_id',

            // ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
