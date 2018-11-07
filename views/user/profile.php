<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use app\models\User;

/* @var $this yii\web\View */
/* @var $model app\models\User */
if(Yii::$app->user->identity->role==User::ROLE_TEACHER || Yii::$app->user->identity->role==User::ROLE_HEAD){
    $this->title = $model->teacher->fullName;
}elseif(Yii::$app->user->identity->role==User::ROLE_STUDENT){
    $this->title = $model->student->fullName;
}
$this->params['breadcrumbs'][] = ['label' => 'Users', 'url' => ['/']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('change password', ['changepass', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
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


        <a href="<?= \yii\helpers\Url::to(['/teacher/score','id' => Yii::$app->user->identity->id]) ?>">A</a>
</div>
