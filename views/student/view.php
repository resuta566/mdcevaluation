<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Student */

$this->title = $model->getFullName();
$this->params['breadcrumbs'][] = ['label' => 'Students', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="card">

    <div class="card-header" data-background-color="blue">
            <h1><?= Html::encode($this->title) ?></h1>
            <p class="simple-text">Student Details</p>
        </div>
        <div class="card-content">
    <div class="row">
    <div class="pull-left">

         <?php if($model->user_id==0){ ?>
            <?=Html::beginForm(['generate', 'id' => $model->id],'post');?>
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
              <?=   Html::submitButton('Generate', [
                        'class' => 'btn btn-info',
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
                'confirm' => 'Are you sure you want to Unlink and Delete the User of this student?',
                'method' => 'post',
            ],
        ]) ?>
                <?php }?>
    </div>
</div>
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
</div>
