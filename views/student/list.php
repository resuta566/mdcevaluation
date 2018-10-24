<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\bootstrap\Modal;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel app\models\StudentSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Students';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="card">
    <div class="card-header" data-background-color="blue">
            <h1 class="title"><?= Html::encode($this->title) ?></h1>
            <p class="simple-text">List of Students of the that has no User yet.</p>
    </div>
        <div style="margin: 20px">
        <?php
        Modal::begin([
                        'header' => '<h4>Student</h4>',
                        'id' => 'modal',
                        'size' => 'modal-lg',
                        ]);
                        echo "<div id='modalContent'></div>";
                Modal::end();
        ?>
        <?php echo $this->render('_listsearch', ['model' => $searchModel]); ?>
        <br>
     <?= Html::beginForm(['generatebulk'],'post'); ?>
            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'tableOptions' => [
                    'class' => 'table table-condensed',
                ],
                // 'filterModel' => $searchModel,
                'columns' => [
                    [
                        'class' => 'yii\grid\CheckboxColumn',
                        'checkboxOptions' => [
                            'id' => 'gg'
                        ]
                    ],
                        [ 'attribute' => 
                                'id', 
                                'label' => 'Username/ID Number',
                                'format' => 'raw', 
                                'value' => 
                                // Url::to('student/view'),
                                function ($model) {
                                    return Html::a($model->id, 
                                    [ 'student/view', 'id' => $model->id ], [
                                        'target' => '_blank']
                                        );
                                    },
                                    'contentOptions' => [ 'style' => 'width: 40px' ],
                                ],
                    'lname',
                    'fname',
                    'mname',
                    'genderName',
                    // 'user_id',

                    // [
                    // 'class' => 'yii\grid\ActionColumn',
                    //  'template' => '{view}'    
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
                    6 => 'CCJ'
                );
                ?>
             <?=  Html::dropDownList('userDepartment', null, $dept_list,
                        [
                            'class' => 'form-control', 
                            'prompt'=>'Choose a Department'
                        ]) ?>
            <br>
            <?= Html::submitButton('GENERATE', [
                        'class' => 'btn btn-info',
                        'data' => [
                            'confirm' => 'Are you sure you want to generate users for this Students?',
                            'method' => 'post',
                        ],
                    ]); ?>
            <?= Html::endForm(); ?>
        </div>
</div>