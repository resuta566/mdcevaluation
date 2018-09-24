<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Instrument */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Instruments', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="card">
	 <div class="card-header" data-background-color="blue">

    <h1><?= Html::encode($this->title) ?></h1>
</div>
<div class="card-content">
    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <!-- <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'name',
            'description:ntext',
        ],
    ]) ?> -->

    <?php $form = ActiveForm::begin(['id' => 'dynamic-form']); ?>

<div>
       <?= $form->field($model, 'name')->textInput(['maxlength' => true,'style'=>'width: 50%', 'placeholder'=>'Name','readOnly'=> true]) ?>

       <?= $form->field($model, 'description')->textArea(['rows' => '6', 'placeholder'=>'Description','readOnly'=> true]) ?>

</div>

    <table class="table table-bordered table-striped">
   <thead>
       <tr>
       <th style="text-align: center"> # </th>
           <th ><span class="glyphicon glyphicon-tasks" style="font-size: 20px"></span> <b>Sections</b></th>
           <th style="width: 650px; height: 30px;"><span class="glyphicon glyphicon-list" style="font-size: 20px"></span> <b>Items</b></th>
       </tr>
   </thead>
   <tbody class="container-items">
   <?php foreach ($sections as $indexSection => $section): ?>
       <tr class="section-item">
       <td class="text-center vcenter">
        <?php echo ''.$indexSection + 1
        ?>
       </td>
           <td class="vcenter">
           
               <?= $form->field($section, "[{$indexSection}]name")->textInput(['placeholder'=>"Name",'readOnly'=> true]) ?>
               <?= $form->field($section, "[{$indexSection}]description")->textArea(['rows' => '6', 'placeholder'=>'Description', 'readOnly'=> true]) ?>
           </td>
           <td>
               <!-- Items Table -->
               <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th ><?php echo '<b>'.$section->name.'</b>' ?></th>
                            </tr>
                        </thead>
                        <tbody class="container-rooms">
                        <?php foreach ($section->items as $indexItem => $modelItem): ?>
                            <tr class="item-item">
                                <td class="vcenter">
                                    <?= $form->field($modelItem, "[{$indexSection}][{$indexItem}]statement")->textInput(['maxlength' => true, 'readOnly'=> true]) ?>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
           </td>
       </tr>
    <?php endforeach; ?>
   </tbody>
</table>

<?php ActiveForm::end(); ?>
</div>
</div>
