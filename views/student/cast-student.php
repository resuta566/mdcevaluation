<?php

use yii\helpers\Html;
use yii\grid\GridView;
use app\models\Teacher;
use yii\bootstrap\Modal;

/* @var $this yii\web\View */
/* @var $searchModel app\models\TeacherSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'CAST Students';
$this->params['breadcrumbs'][] = $this->title;
$user = \app\models\User::find()->where(['role' => 30])->andWhere(['department'=> 1])->one();
?>

<div class="card">
    <div class="card-header" data-background-color="blue">
    <h2 class="title"><?= Html::encode($this->title) ?></h2><h3 class="title">DEAN - <?= $user->teacher->fullName?></h3>
        <p class="category">List of <?= Html::encode($this->title) ?> of the Evaluation </p>
        
    </div>
    <div class="card-content">
    <?php echo $this->render('_searchCast', ['model' => $searchModel]); ?>
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

        //     ['class' => 'yii\grid\ActionColumn',
        //      'template' => '{view}',
        // ],
        ],
    ]); ?>
    </div>
</div>