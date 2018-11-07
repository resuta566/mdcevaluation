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
    <p class="category">List of <?= Html::encode($this->title) ?> of the Evaluation that has no user yet.</p>
    
</div>
<div style="margin: 20px">
<?php echo $this->render('_listsearch', ['model' => $searchModel]); ?>
<?= Html::beginForm(['generatebulk'],'post'); ?>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'tableOptions' => [
            'class' => 'table table-condensed',
        ],
        'columns' => [
            [
                'class' => 'yii\grid\CheckboxColumn',

        ],
            
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
            'typeName',
            // 'user_id',

        //     ['class' => 'yii\grid\ActionColumn',
        //      'template' => '{view}',
        // ],
        ],
    ]); ?>
    <br>
    <?php
       $dept_list = array(
           1 => 'CAST',
           2 => 'COE',
           3 => 'CABM-H',
           4 => 'CABM-B',
           5 => 'CON',
           6 => 'CCJ',
           7 => 'Senior High School',
           8 => 'Junior High School',
           9 => 'Elementary'
       );
       ?>
    <?=  Html::dropDownList('userDepartment', null, $dept_list,
               [
                   'class' => 'form-control', 
                   'prompt'=>'Choose a Department'
               ]) ?>
   <?php
       $dept_list = array(
           20 => 'Teacher',
           30 => 'Dean'
       );
       ?>
   <?=  Html::dropDownList('userRole', null, $dept_list,
               [
                   'class' => 'form-control', 
                   'prompt'=>'Users Role'
               ]) ?>
   <br>
   <?= Html::submitButton('GENERATE', [
               'class' => 'btn btn-info',
               'data' => [
                   'confirm' => 'Are you sure you want to generate users for this Teachers?',
                   'method' => 'post',
               ],
           ]); ?>
   <?= Html::endForm(); ?>
</div>
</div>
</div>