<?php 

namespace app\components;

use yii\helpers\Html;

class MyWidgets {

	public static function mainPanelButton($icon, $label, $link) {
		return Html::a("<i class='$icon'></i> $label", 
			[$link],
			['class'=>'btn btn-info panel-button']);
	}

}

?>