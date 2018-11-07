<?php

use yii\helpers\Html;
use yii\grid\GridView;
use app\models\Student;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel app\models\StudentSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Students';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="student-index">
    <div class="card">
    <div class="card-header" data-background-color="blue">
        <h2 class="title"><?= Html::encode($this->title) ?></h2>
        <p class="category">List of <?= Html::encode($this->title) ?> of the Evaluation</p>
        
    </div>
        <div style="margin: 20px">
        <p class="category"><?= Html::encode($this->title) ?> Lists by Departments</p>
        <?= Html::a('CAST', ['student-department', 'department' => 1], ['class' => 'btn btn-info','target' => '_blank']) ?>
        <?= Html::a('COE', ['student-department', 'department' => 2], ['class' => 'btn btn-info','target' => '_blank']) ?>
        <?= Html::a('CABM-B', ['student-department', 'department' => 3], ['class' => 'btn btn-info','target' => '_blank']) ?>
        <?= Html::a('CABM-H', ['student-department', 'department' => 4], ['class' => 'btn btn-info','target' => '_blank']) ?>
        <?= Html::a('CON', ['student-department', 'department' => 5], ['class' => 'btn btn-info','target' => '_blank']) ?>
        <?= Html::a('CCJ', ['student-department', 'department' => 6], ['class' => 'btn btn-info','target' => '_blank']) ?>
        <?= Html::a('SHS', ['student-department', 'department' => 7], ['class' => 'btn btn-info','target' => '_blank']) ?>
        <?= Html::a('JHS', ['student-department', 'department' => 8], ['class' => 'btn btn-info','target' => '_blank']) ?>
        <?= Html::a('Elementary', ['student-department', 'department' => 9], ['class' => 'btn btn-info','target' => '_blank']) ?>
        
        <?php Pjax::begin(['enablePushState'=>false,'timeout' => 5000]); ?>

            <?php echo $this->render('_search', ['model' => $searchModel]); ?>
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
                        \yii\helpers\Url::toRoute([ 'student/view', 'id' => $model->id ]), [
                            'data-pjax' => 0,
                            'target' => '_blank']
                            );
                        },
                    ],
                    

                    'lname',
                    'fname',
                    'mname',
                    'genderName',
                    'user.departmentName',
                    'evalDone'

                //     ['class' => 'yii\grid\ActionColumn',
                //      'template' => '{view}',
                // ],
                ],
            ]); ?>
            </div>
    <?php Pjax::end(); ?>
</div>
</div>
</div>