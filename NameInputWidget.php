<?php

namespace mrssoft\formwidgets;

use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\InputWidget;

class NameInputWidget extends InputWidget
{
    public $requiredName2 = true;

    public $requiredName3 = false;

    public $pattern;

    public function init()
    {
        if ($this->pattern === null) {

            $p = '[А-Яа-яЁё\-]+';

            $this->pattern = $p;
            if ($this->requiredName2) {
                $this->pattern .= '\s+' . $p;
                if ($this->requiredName3) {
                    $this->pattern .= '\s+' . $p;
                } else {
                    $this->pattern .= '.*';
                }
            } else {
                $this->pattern .= '.*';
            }
        }

        parent::init();
    }

    public function run()
    {
        $options = ArrayHelper::merge([
            'class' => 'form-control',
            'placeholder' => 'Фамилия Имя Отчество',
            'pattern' => $this->pattern,
            'title' => 'Фамилия Имя Отчество',
            'maxlenght' => 255
        ], $this->options);

        echo Html::activeTextInput($this->model, $this->attribute, $options);
    }
}
