<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Student */

$this->title = $model->getFullName();
$this->params['breadcrumbs'][] = ['label' => 'Students', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="student-view">

    <h1><?= Html::encode($this->title) ?></h1>
    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>

         <?php if($model->user_id==0){ ?>
        <?=  
        Html::a('Generate', ['generate', 'id' => $model->id], [
            'class' => 'btn btn-success',
            'data' => [
                'confirm' => 'Are you sure you want to generate user for this student?',
                'method' => 'post',
            ],
        ]) ?>
        <?php }else{?>
        
            <?=  
        Html::a('Unlink', ['unlink', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to Unlink and Delete the User of this student?',
                'method' => 'post',
            ],
        ]) ?>
                <?php }?>
    </p>

    <table class="table">
    <p><b>Student Details</b></p>
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

    <p><strong>Subject Enrolled</strong></p>
    <!-- <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'lname',
            'fname',
            'mname',
            'gender',
            //'user_id',
        ],
    ]) ?> -->

</div>
