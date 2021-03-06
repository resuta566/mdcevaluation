<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\HeadSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Heads';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="card">
<div class="card">
<div class="card-header" data-background-color="blue">
    <h1 class="title"><?= Html::encode($this->title) ?></h1>
    <p class="category">List of <?= Html::encode($this->title) ?> of the Evaluation</p>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
</div>

<div class="card-content">
    <h1><?= Html::encode($this->title) ?></h1>
    <?php echo $this->render('_search', ['model' => $searchModel]); ?>

    <!-- <p>
        <?= Html::a('Create Head', ['create'], ['class' => 'btn btn-success']) ?>
    </p> -->

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        // 'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [ 'attribute' => 
            'id', 
            'label' => 'ID Number',
            'format' => 'raw', 
            'value' => 
            function ($model) {
            return Html::a($model->id, 
            [ 'head/view', 'id' => $model->id ], [
                'target' => '_blank']
                );
            },
        ],
            'lname',
            'fname',
            'mname',
            'gender',
            //'user_id',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
    </div>
</div>
