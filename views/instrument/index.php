<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\InstrumentSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Instruments';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="card">
<div class="card-header" data-background-color="blue">
    <h1 class="title"><?= Html::encode($this->title) ?></h1>
    <p class="category">List of <?= Html::encode($this->title) ?> of the Evaluation</p>
    
</div>
<div style="margin: 20px">
<?php echo $this->render('_search', ['model' => $searchModel]); ?>
    <p>
        <?= Html::a('Create Instrument', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        // 'filterModel' => $searchModel,
        'columns' => [

            'id',
            'name',
            'description:ntext',

            // ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
</div>