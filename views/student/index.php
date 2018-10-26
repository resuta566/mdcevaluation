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
            <h2 class="title"><?= Html::encode($this->title) ?></h2>
            <p class="simple-text">List of Students of the Evaluation</p>
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
        <?php echo $this->render('_search', ['model' => $searchModel]); ?>
        <br>
        <?= Html::a('Generate Many', ['list'], ['class' => 'btn btn-info']) ?>
            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'tableOptions' => [
                    'class' => 'table table-condensed',
                ],
                // 'filterModel' => $searchModel,
                'columns' => [
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
        </div>
</div>