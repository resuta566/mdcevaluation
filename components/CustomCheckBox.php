<?php

namespace app\components;
use Closure;

use yii\helpers\Html;
use yii\helpers\Json;
use yii\grid\CheckboxColumn;

class CustomCheckBox extends CheckboxColumn
{

    public $content;

    /**
     * @inheritdoc
     */
    protected function renderDataCellContent($model, $key, $index)
    {
        if ($this->content instanceof Closure) {
            $checkbox = call_user_func($this->content, $model, $key, $index, $this);
        } else {
            $checkbox = $this->getContentCheckBox($model,$key,$index);
        }
        return $checkbox;
    }

    public function getContentCheckBox($model,$key,$index)
    {
        if ($this->checkboxOptions instanceof Closure) {
            $options = call_user_func($this->checkboxOptions, $model, $key, $index, $this);
        } else {
            $options = $this->checkboxOptions;
        }
        if (!isset($options['value'])) {
            $options['value'] = is_array($key) ? Json::encode($key) : $key;
        }
        if ($this->cssClass !== null) {
            Html::addCssClass($options, $this->cssClass);
        }
        return Html::checkbox($this->name, !empty($options['checked']), $options);
    }

}