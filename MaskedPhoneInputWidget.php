<?php

namespace app\widgets;

use app\assets\MaskedInputAsset;
use yii\bootstrap\Html;
use yii\bootstrap\InputWidget;
use yii\web\JqueryAsset;

/**
 * Поле для ввода телеофна с маской в формате: +7(983)413-55-66
 */
class MaskedPhoneInputWidget extends InputWidget
{
    public $inputType = 'tel';

    public function run()
    {
        $inputId = $this->options['id'];

        if ($this->hasModel()) {
            echo Html::activeInput($this->inputType, $this->model, $this->attribute, $this->options);
        } else {
            echo Html::input($this->inputType, $this->name, $this->value, $this->options);
        }

        MaskedInputAsset::register($this->view);
        $this->view->registerJs("$.mask.definitions['f']='[9]'; $('#$inputId').mask('+7(f99)999-9999');");
    }
}