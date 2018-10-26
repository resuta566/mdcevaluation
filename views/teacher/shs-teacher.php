<?php

use yii\helpers\Html;
use yii\grid\GridView;
use app\models\Teacher;
use yii\bootstrap\Modal;

/* @var $this yii\web\View */
/* @var $searchModel app\models\TeacherSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Senior High School Teachers';
$this->params['breadcrumbs'][] = $this->title;
$user = \app\models\User::find()->where(['role' => 30])->andWhere(['department'=> 7])->one();
?>

<div class="card">
    <div class="card-header" data-background-color="blue">
    <h2 class="title"><?= Html::encode($this->title) ?></h2><h3 class="title">PRINCIPAL - <?= $user->teacher->fullName?></h3>
        <p class="category">List of <?= Html::encode($this->title) ?> of the Evaluation</p>
        
    </div>
    <div class="card-content">
    <?php echo $this->render('_searchShs', ['model' => $searchModel]); ?>
    <div>
    <p>Start Peer Evaluation</p>
    <?= Html::beginForm(['teacheval', 'id' =>  $user->department, 'deanid' =>  $user->id ],'post'); ?>

    <?=  Html::dropDownList('instrumentdropdown', null,
                    \yii\helpers\ArrayHelper::map(app\models\Instrument::find()->all(), 'id', 'name'),
                        [
                            'class' => 'form-control', 
                            'prompt'=>'Choose an Instrument'
                        ]) ?>
   <br>
   <?= Html::submitButton('GENERATE', [
               'class' => 'btn btn-info',
               'data' => [
                   'confirm' => 'Are you sure you want to Start Evaluation for this Teachers?',
                   'method' => 'post',
               ],
           ]); ?>
           </div>
        <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'tableOptions' => [
            'class' => 'table table-condensed',
        ],
        'columns' => [
            
            // ['class' => 'yii\grid\SerialColumn'],
            [ 'attribute' => 
                   'id', 
                   'label' => 'ID Number',
                   'format' => 'raw', 
                   'value' => 
                   function ($model) {
                   return Html::a($model->id, 
                   [ 'teacher/view', 'id' => $model->id ], [
                       'target' => '_blank']
                       );
                   },
               ],
            

            'lname',
            'fname',
            'mname',
            'genderName',
            // 'user_id',

        //     ['class' => 'yii\grid\ActionColumn',
        //      'template' => '{view}',
        // ],
        ],
    ]); ?>
    </div>
</div>