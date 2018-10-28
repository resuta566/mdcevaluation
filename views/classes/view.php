<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $model app\models\Classes */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Classes', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="classes-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <!-- <?= Html::a('Generate', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?> -->
        <!-- <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?> -->
    </p>

       <table class="table">
    <p><b>Subject Details</b></p>
    <tr>
        <th>Teacher Handling</th>
        <th>Name</th>
        <th>Description</th>
        <th>Day</th>
        <th>Time</th>
    </tr>
    <tr>
    
        <td class="text-primary">
            <?= Html::a($model->teacher->fullName, 
            ['/teacher/view', 'id'=>$model->teacher->id],
            ['target' => '_blank']
            ); ?>
        </td>
        <td><?= $model->name ?></td>
        <td><?= $model->description ?></td>
        <td><?= $model->day ?></td>
        <td><?= $model->time ?></td>
       
    </tr>
    </table>

    <!-- <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'name',
            'description:ntext',
            'day',
            'time',
            'teacher_id',
        ],
    ]) ?> -->
        <h2><b>Students Enrolled</b>
     </h2>
      <?=GridView::widget([
            'dataProvider' => $dataProvider,
            'columns' => [
                // [
                //         'class' => 'yii\grid\CheckboxColumn',
                // ],

                [ 'attribute' => 
                   'name', 
                   'label' => 'Student ID',
                   'format' => 'raw', 
                   'value' => 
                   function ($sclasses) {
                   return Html::a($sclasses->student->id, 
                   [ 'student/view', 'id' => $sclasses->student->id ], [
                       'target' => '_blank']
                       );
                   },
               ],
               'student.fullName',
               [ 'attribute' => 
                   'name', 
                   'label' => 'Status (Active / Drop)',
                   'format' => 'raw', 
                   'value' => 
                   function ($sclasses) {
                   return ($sclasses->statusName );
                   },
               ],
            ],
        ]); ?>

</div>
