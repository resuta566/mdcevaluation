<?php

use yii\helpers\Html;
use wbraganca\dynamicform\DynamicFormWidget;

?>

<?php DynamicFormWidget::begin([
    'widgetContainer' => 'dynamicform_inner',
    'widgetBody' => '.container-item',
    'widgetItem' => '.item-item',
    'limit' => 20,
    'min' => 1,
    'insertButton' => '.add-stat',
    'deleteButton' => '.remove-stat',
    'model' => $modelsItem[0],
    'formId' => 'dynamic-form',
    'formFields' => [
        'statement'
    ],
]); ?>
<table class="table table-bordered">
    <thead>
        <tr>
            <th>Statement</th>
            <th class="text-center">
                <button type="button" class="add-stat btn btn-success btn-xs"><span class="glyphicon glyphicon-plus" style="font-size: 10px"></span></button>
            </th>
        </tr>
    </thead>
    <tbody class="container-item">
    <?php foreach ($modelsItem as $indexItem => $modelItem): ?>
        <tr class="item-item">
            <td class="vcenter">
                <?php
                    // necessary for update action.
                    if (! $modelItem->isNewRecord) {
                        echo Html::activeHiddenInput($modelItem, "[{$indexSection}][{$indexItem}]id");
                    }
                ?>
                <?= $form->field($modelItem, "[{$indexSection}][{$indexItem}]statement")->label(false)->textInput(['maxlength' => true]) ?>
            </td>
            <td class="text-center vcenter" style="width: 30px;">
                <button type="button" class="remove-stat btn btn-danger btn-xs"><span class="glyphicon glyphicon-minus" style="font-size: 10px"></span></button>
            </td>
        </tr>
     <?php endforeach; ?>
    </tbody>
</table>
<?php DynamicFormWidget::end(); ?>