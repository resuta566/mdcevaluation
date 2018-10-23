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
<?php $form = ActiveForm::begin(['id' => 'dynamic-form']); ?>

<br>
<table class="table table-bordered table-striped">
   <thead>
   </thead>
   <tbody class="container-items">
   <tr class="section-item">
           <td class="vcenter">
   <?php foreach ($evalSections as $indexSection => $modelSection): ?>
   <h3><?= $modelSection->section->name ?></h3>
            <?php
                // necessary for evaluate action.
                if (! $modelSection->isNewRecord) {
                    echo Html::activeHiddenInput($modelSection, "[{$indexSection}]id");
                }
            ?>
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
<div class="form-group">
   <?= Html::submitButton($model->isNewRecord ? 'Create' : 'SAVE', ['class' => 'btn btn-success']) ?>
</div>

<?php ActiveForm::end(); ?>