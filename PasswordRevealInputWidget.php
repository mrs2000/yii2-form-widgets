<?php

namespace mrssoft\formwidgets;

use yii\bootstrap\Html;
use yii\bootstrap\InputWidget;

/**
 * Поле для ввода пароля с кнопкой "Показать пароль"
 */
class PasswordRevealInputWidget extends InputWidget
{
    public $buttonText = 'Показать';

    public $buttonTitle = 'Показать пароль';

    public $buttonClass = 'btn btn-default';

    public function run()
    {
        $inputId = $this->options['id'];
        $buttonId = $this->options['id'] . '-reveal';

        echo Html::beginTag('div', ['class' => 'input-group']);
        if ($this->hasModel()) {
            echo Html::activePasswordInput($this->model, $this->attribute, $this->options);
        } else {
            echo Html::passwordInput($this->name, $this->value, $this->options);
        }
        echo Html::beginTag('div', ['class' => 'input-group-btn']);
        echo Html::button($this->buttonText, [
            'class' => $this->buttonClass,
            'title' => $this->buttonTitle,
            'type' => 'button',
            'id' => $buttonId
        ]);
        echo Html::endTag('div');
        echo Html::endTag('div');

        $js = <<<JS
            $('#$buttonId').click(function () {
                if ($(this).hasClass('active')) {
                    $(this).removeClass('active');
                    $('#$inputId').attr('type', 'password');
                } else {
                    $(this).addClass('active');
                    $('#$inputId').attr('type', 'text');
                }
            });
JS;
        $this->view->registerJs($js);
    }
}