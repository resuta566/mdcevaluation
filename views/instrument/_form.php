<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use wbraganca\dynamicform\DynamicFormWidget;

/* @var $this yii\web\View */
/* @var $model app\models\Instrument */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="instrument-form">

    <?php $form = ActiveForm::begin(['id' => 'dynamic-form']); ?>

<div>
       <?= $form->field($modelInstrument, 'name')->textInput(['maxlength' => true,'style'=>'width: 50%', 'placeholder'=>'Name'])->label(false) ?>

       <?= $form->field($modelInstrument, 'description')->textArea(['rows' => '6', 'placeholder'=>'Description'])->label(false) ?>

</div>

<div class="padding-v-md">
   <div class="line line-dashed"></div>
</div>
<br>
<?php DynamicFormWidget::begin([
   'widgetContainer' => 'dynamicform_wrapper',
   'widgetBody' => '.container-items',
   'widgetItem' => '.section-item',
   'min' => 1,
   'insertButton' => '.add-section',
   'deleteButton' => '.remove-section',
   'model' => $modelsSection[0],
   'formId' => 'dynamic-form',
   'formFields' => [
       'name',
       'description',
   ],
]); ?>
<table class="table table-bordered table-striped">
   <thead>
       <tr>
           <th >Sections</th>
           <th style="width: 650px; height: 30px;">Items</th>
           <th class="text-center" style="width: 30px; height: 30px;">
               <button type="button" class="add-section btn btn-success btn-xs"><span class="glyphicon glyphicon-plus" style="font-size: 10px"></span></button>
           </th>
       </tr>
   </thead>
   <tbody class="container-items">
   <?php foreach ($modelsSection as $indexSection => $modelSection): ?>
       <tr class="section-item">
           <td class="vcenter">
               <?php
                   // necessary for update action.
                   if (! $modelSection->isNewRecord) {
                       echo Html::activeHiddenInput($modelSection, "[{$indexSection}]id");
                   }
               ?>
               <?= $form->field($modelSection, "[{$indexSection}]name")->label(false)->textInput(['placeholder'=>"Name"]) ?>
               <?= $form->field($modelSection, "[{$indexSection}]description")->label(false)->textArea(['rows' => '6', 'placeholder'=>'Description']) ?>
           </td>
           <td>
               <?= $this->render('_form-item', [
                   'form' => $form,
                   'indexSection' => $indexSection,
                   'modelsItem' => $modelsItem[$indexSection],
               ]) ?>
           </td>
           <td class="text-center vcenter" style="width: 40px; verti">
               <button type="button" class="remove-section btn btn-danger btn-xs"><span class="glyphicon glyphicon-minus" style="font-size: 10px"></span></button>
           </td>
       </tr>
    <?php endforeach; ?>
   </tbody>
</table>
<?php DynamicFormWidget::end(); ?>

<div class="form-group">
   <?= Html::submitButton($modelInstrument->isNewRecord ? 'Create' : 'Update', ['class' => 'btn btn-primary']) ?>
</div>

<?php ActiveForm::end(); ?>

</div>
