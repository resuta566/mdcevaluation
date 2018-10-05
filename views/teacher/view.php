<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;
use yii\widgets\DetailView;
use app\models\Teacher;
use app\models\Instrument;
use app\models\Classes;
use yii\grid\GridView;
use kartik\tabs\TabsX;

/* @var $this yii\web\View */
/* @var $model app\models\Teacher */

$this->title = $model->getFullName();
$this->params['breadcrumbs'][] = ['label' => 'Teachers', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="card">
        <div class="card-header" data-background-color="blue">
            <h1><?= Html::encode($this->title) ?></h1>
            <p class="category">Teacher Details</p>
        </div>
    <div class="card-content">
    <p>
        <!-- <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?> -->
        
        <?php if($model->user_id==0){ ?>
        <?=  
        Html::a('Generate', ['generate', 'id' => $model->id], [
            'class' => 'btn btn-success',
            'data' => [
                'confirm' => 'Are you sure you want to generate user for this teacher?',
                'method' => 'post',
            ],
        ]) ?>
        <?php }else{?>
        
            <?=  
        Html::a('Unlink', ['unlink', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to Unlink and Delete the User of this teacher?',
                'method' => 'post',
            ],
        ]) ?>
                <?php }?>
       
    </p>
    <table class="table">
    <p><b>Teacher Details</b></p>
    <tr>
        <th>Last Name</th>
        <th>First Name</th>
        <th>Middle Name</th>
        <th>Gender</th>
    </tr>
    <tr>
    
        <td class="text-primary"><?= $model->lname ?></td>
        <td><?= $model->fname ?></td>
        <td><?= $model->mname ?></td>
        <td><?= $model->genderName ?></td>
       
    </tr>
    </table>
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            // 'id',
            // 'lname',
            // 'fname',
            // 'mname',
            // 'gender',
            //'user_id',
        ],
    ]) ?>
     <h2><b>Subjects</b>
     </h2>
<!-- <?=  
        Html::a('Evaluate', ['evaluate', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to make an evaluation to this subjects?',
                'method' => 'post',
            ],
        ]) ?>
        <?= GridView::widget([
        'dataProvider' => $dataProvider,
        // 'filterModel' => $searchModel,
        
        'columns' => [
            
            ['class' => 'yii\grid\CheckboxColumn'],
            

            'name',
            'description',
            'day',
            'time',
        ],
    ]); ?> -->
    <?php 
$items = [
    [
        'label'=>'<i class="glyphicon glyphicon-off"></i> INACTIVE',
        'content'=> 
        // This is the Inactive Evaluation subjects
       Html::beginForm(['bulk'],'post').
                    GridView::widget([
                        'dataProvider' => $dataProvider,
                        // 'filterModel' => $searchModel,
                        'columns' => [
                            [
                                    'class' => 'yii\grid\CheckboxColumn',

                            ],
                            [
                                'attribute' => 'estatus',
                                'value' =>  'estatusName',
                            ],
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
                            'description',
                            'day',
                            'time',
                        ],
                    ])
                            ." <br> Select the Instrument".
                Html::dropDownList('instrumentdropdown', null,
                    ArrayHelper::map(Instrument::find()->all(), 'id', 'name'),
                        [
                            'class' => 'form-control', 
                            'prompt'=>'Choose an Instrument'
                        ])
    . Html::submitButton('Evaluate', [
                        'class' => 'btn btn-info',
                        'data' => [
                            'confirm' => 'Are you sure you want to make an evaluation to this subjects? Please be inform that this action cannot be undone.',
                            'method' => 'post',
                        ],
                    ]).

                    Html::endForm()
        ,
        'active'=>true
    ],
    [
        'label'=>'<i class="glyphicon glyphicon-transfer"></i> ACTIVE',
        'content'=>
        //Active Evaluation Subjects 
        Html::beginForm(['stop'],'post').
                GridView::widget([
                    'dataProvider' => $activeDataProvider,
                    // 'filterModel' => $searchModel,
                    'columns' => [
                        [
                                'class' => 'yii\grid\CheckboxColumn',

                        ],
                        [
                            'attribute' => 'estatus',
                            'value' =>  'estatusName',
                        ],
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
                    
                        'description',
                        'day',
                        'time',
                    ],
                ]) 
                . 
                Html::submitButton('Stop', [
                    'class' => 'btn btn-info',
                    'data' => [
                        'confirm' => 'Are you sure you want to stop the evaluation of this subjects?',
                        'method' => 'post',
                    ],
                ])
                .
        Html::endForm()
    ],
    ];
echo TabsX::widget([
    'items'=>$items,
    'position'=>TabsX::POS_ABOVE,
    'encodeLabels'=>false
]);
?>

    <!-- <?=Html::beginForm(['bulk'],'post');?>
        <?=GridView::widget([
            'dataProvider' => $dataProvider,
            // 'filterModel' => $searchModel,
            'columns' => [
                [
                        'class' => 'yii\grid\CheckboxColumn',

                ],
                [
                    'attribute' => 'estatus',
                    'value' =>  'estatusName',
                ],
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
            
                'description',
                'day',
                'time',
            ],
        ]); ?>
        <?=  
        Html::submitButton('Evaluate', [
            'class' => 'btn btn-info',
            'data' => [
                'confirm' => 'Are you sure you want to make an evaluation to this subjects?',
                'method' => 'post',
            ],
        ]) ?>

<?= Html::endForm();?>  -->
</div>
</div>
