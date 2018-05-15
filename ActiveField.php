<?php

namespace mrssoft\formwidgets;

use yii\helpers\Html;

class ActiveField extends \yii\bootstrap\ActiveField
{
    public function label($label = null, $options = [])
    {
        if (array_key_exists('required', $this->inputOptions) && $this->inputOptions['required'] != 'off') {
            Html::addCssClass($this->labelOptions, 'required');
        }

        return parent::label($label, $options);
    }

    public function widget($class, $config = [])
    {
        $config['options'] = $this->inputOptions;
        return parent::widget($class, $config);
    }
}