<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use app\models\User;
use yii\bootstrap\Modal;

/* @var $this yii\web\View */
/* @var $model app\models\User */
if(Yii::$app->user->identity->role== User::ROLE_ADMIN || Yii::$app->user->identity->role== User::ROLE_HEAD || Yii::$app->user->identity->role== User::ROLE_TEACHER){
    $titles = Yii::$app->user->identity->teacher->fullName;
}else{
    $titles = Yii::$app->user->identity->student->fullName;
}
$this->title = $titles;
$this->params['breadcrumbs'][] = ['label' => 'Users', 'url' => ['/']];
$this->params['breadcrumbs'][] = $this->title;
?>

    <p>
    <a class="btn btn-info" href="<?= \yii\helpers\Url::to(['user/changepassword']) ?>"  style="color: white">Change Password</a>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'username',
            // 'password',
            // 'authkey',
            'roleName',
            'statusName',
            'departmentname',
        ],
    ]) ?>
	
        