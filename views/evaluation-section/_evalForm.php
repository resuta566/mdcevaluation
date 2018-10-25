<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use app\models\Instrument;
use app\models\Section;
use wbraganca\dynamicform\DynamicFormWidget;


/* @var $this yii\web\View */
/* @var $model app\models\Evaluation */

$this->title = 'Evaluate '. app\models\Teacher::find()->where(['user_id' => $model->evalFor->id ])->one()->fullName;
$this->params['breadcrumbs'][] = $this->title;
?>
<?php $form = ActiveForm::begin(); ?>

<br>
<?php DynamicFormWidget::begin([
   'widgetContainer' => 'dynamicform_wrapper',
   'widgetBody' => '.container-items',
   'widgetItem' => '.section-item',
   'limit' => 10,
   'min' => 1,
   'insertButton' => '.add-section',
   'deleteButton' => '.remove-section',
   'model' => $modelSection[0],
   'formId' => 'dynamic-form',
   'formFields' => [
       'name',
       'description',
   ],
]); ?>
<table class="table table-bordered table-striped">
   <thead>
       <tr>
           <th ></th>
       </tr>
   </thead>
   <tbody class="container-items">
   <tr class="section-item">
           <td class="vcenter">
   <?php foreach ($evalSections as $indexSection => $modelSection): ?>
   <?= $modelSection->section->name; ?>
           <?= $this->render('_evalFormItem', [
                   'form' => $form,
                   'modelSection' => $modelSection,
                   'indexSection' => $indexSection,
                   'evalItems' => $evalItems[$indexSection],
               ]) ?>
               <?= $form->field($modelSection, "[{$indexSection}]comment")->textInput(['placeholder'=>"Comment"]) ?>
           
            <?php endforeach; ?>
    </td>
     </tr>
   </tbody>
</table>
<?php DynamicFormWidget::end(); ?>
<div class="form-group">
   <?= Html::submitButton('SAVE', ['class' => 'btn btn-success']) ?>
</div>

<?php ActiveForm::end(); ?>