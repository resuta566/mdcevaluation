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
    <p class="category">List of Students of the Evaluation</p>
    
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
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
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