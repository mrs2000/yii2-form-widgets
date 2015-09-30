<?php

namespace mrssoft\formwidgets;

use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\InputWidget;

class FieldPhone extends InputWidget
{
    public $inputType = 'tel';

    public function run()
    {
        $options = ArrayHelper::merge([
            'class' => 'form-control',
            'placeholder' => '11 цифр',
            'pattern' => '\d{10,11}',
            'title' => '11 цифр номера',
            'maxlenght' => 10
        ], $this->options);

        echo Html::activeInput($this->inputType, $this->model, $this->attribute, $options);

        $id = $this->options['id'];
        $js = "$('#$id').blur(function() {
            var val = $(this).val().replace(/\D/g, '');
            $(this).val(val);
        });";

        $this->view->registerJs($js, \yii\web\View::POS_READY);
    }
}
