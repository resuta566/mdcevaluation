<?php

use yii\helpers\Html;
use yii\grid\GridView;
use app\models\Teacher;
use yii\bootstrap\Modal;

/* @var $this yii\web\View */
/* @var $searchModel app\models\TeacherSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Teachers';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="teacher-index">
<div class="card">
<div class="card-header" data-background-color="blue">
    <h2 class="title"><?= Html::encode($this->title) ?></h2>
    <p class="category">List of <?= Html::encode($this->title) ?> of the Evaluation</p>
    
</div>
<div style="margin: 20px">
<p class="category">Teachers Lists by Departments</p>
<?= Html::a('CAST', ['cast-teacher'], ['class' => 'btn btn-info','target' => '_blank']) ?>
<?= Html::a('COE', ['coe-teacher'], ['class' => 'btn btn-info','target' => '_blank']) ?>
<?= Html::a('CABM-B', ['cabmb-teacher'], ['class' => 'btn btn-info','target' => '_blank']) ?>
<?= Html::a('CABM-H', ['cabmh-teacher'], ['class' => 'btn btn-info','target' => '_blank']) ?>
<?= Html::a('CON', ['con-teacher'], ['class' => 'btn btn-info','target' => '_blank']) ?>
<?= Html::a('CCJ', ['ccj-teacher'], ['class' => 'btn btn-info','target' => '_blank']) ?>
<?= Html::a('SHS', ['shs-teacher'], ['class' => 'btn btn-info','target' => '_blank']) ?>
<?= Html::a('JHS', ['jhs-teacher'], ['class' => 'btn btn-info','target' => '_blank']) ?>
<?= Html::a('Elementary', ['elem-teacher'], ['class' => 'btn btn-info','target' => '_blank']) ?>
<?php echo $this->render('_search', ['model' => $searchModel]); ?>
<br>

    <div class="pull-right">
    <?= Html::a('Generate Many', ['list'], ['class' => 'btn btn-info']) ?>
    </div>
    <br>
    <div>
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
</div>
</div>