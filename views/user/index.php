<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel app\models\UserSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Users';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="card">

<div class="card-header" data-background-color="blue">
    <h2 class="title"><?= Html::encode($this->title) ?></h2>
    <p class="category">List of Users of the Evaluation</p>
    
</div>
<div style="margin: 20px">
    <!-- <p>
    <?= Html::a('Create User', ['create'], ['class' => 'btn btn-success']) ?>
    </p> -->
    <?php Pjax::begin(['enablePushState'=>false,'timeout' => 5000]); ?>
    <?php  echo $this->render('_search', ['model' => $searchModel]); ?>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'tableOptions' => [
            'class' => 'table table-condensed',
        ],
        // 'filterModel' => $searchModel,
        'columns' => [

            // 'id',
            [ 'attribute' => 
                   'username', 
                   'label' => 'Username',
                   'format' => 'raw', 
                   'value' => 
                   function ($model) {
                   return Html::a($model->username, 
                   \yii\helpers\Url::toRoute([ 'user/view', 'id' => $model->id ]), [
                        'data-pjax' => 0,
                       'target' => '_blank']
                       );
                   },
                   'contentOptions' => [ 'style' => 'width: 40px' ],
               ],
            // 'holder',
            // 'password',
            // 'authkey',
            'roleName',
            'statusName',
            //'department',

            // ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
    <?php Pjax::end(); ?>
</div>
</div>
