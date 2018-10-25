<?php

use yii\helpers\Html;
use wbraganca\dynamicform\DynamicFormWidget;

?>

<table class="table table-bordered">
    <thead>
        <tr>
            <th>Statement</th>
            <th>Score</th>
        </tr>
    </thead>
    <tbody class="container-item">
    
    <?php foreach ($evalItems as $indexItem => $modelItem): ?>
    <tr class="item-item">
    <td>
        <?= $modelItem->item->statement; ?>
        </td>
        <td>
                <?= $form->field($modelItem, "[{$indexSection}][{$indexItem}]score")->label(false)->inline(true)->radioList([
                                        '1'=>'1',
                                        '2'=>'2',
                                        '3'=>'3',
                                        '4'=>'4',
                                        '5'=>'5'
                                            ],
                                            [
                                                'style'=>'height:40px;'
                                            ])  ?>
            </td>
        </tr>
     <?php endforeach; ?>
    </tbody>
</table>