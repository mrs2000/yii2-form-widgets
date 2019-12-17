<?php

namespace mrssoft\formwidgets;

use yii\bootstrap\Html;
use yii\bootstrap\InputWidget;

/**
 * Поле для ввода пароля с кнопкой "Показать пароль"
 */
class PasswordRevealInputWidget extends InputWidget
{
    public $buttonGenerateText = '<i class="glyphicon glyphicon-random"></i>';
    public $buttonGenerateTitle = 'Сгенерировать пароль';
    public $buttonGenerateClass = 'btn btn-default';

    public $buttonRevealText = '<i class="glyphicon glyphicon-eye-open"></i>';
    public $buttonRevealTitle = 'Показать пароль';
    public $buttonRevealClass = 'btn btn-default';

    public $passwordLenght = 8;
    public $passwordSymbols = '0123456789qwertyuiopasdfghjklzxcvbnm!@#$&?%';

    public $buttonGenerate = true;
    public $buttonReveal = true;

    public function run()
    {
        $inputId = $this->options['id'];
        $buttonRevealId = $this->options['id'] . '-reveal';
        $buttonGenerateId = $this->options['id'] . '-generate';

        echo Html::beginTag('div', ['class' => 'input-group']);

        if ($this->hasModel()) {
            echo Html::activePasswordInput($this->model, $this->attribute, $this->options);
        } else {
            echo Html::passwordInput($this->name, $this->value, $this->options);
        }

        if ($this->buttonGenerate || $this->buttonReveal) {
            echo Html::beginTag('div', ['class' => 'input-group-btn']);
            if ($this->buttonGenerate) {
                echo Html::button($this->buttonGenerateText, [
                    'class' => $this->buttonGenerateClass,
                    'title' => $this->buttonGenerateTitle,
                    'type' => 'button',
                    'id' => $buttonGenerateId
                ]);
            }
            if ($this->buttonReveal) {
                echo Html::button($this->buttonRevealText, [
                    'class' => $this->buttonRevealClass,
                    'title' => $this->buttonRevealTitle,
                    'type' => 'button',
                    'id' => $buttonRevealId
                ]);
            }
            echo Html::endTag('div');

            $js = <<<JS
            const input = $('#$inputId');
            $('#$buttonRevealId').on('click', function () {
                if ($(this).hasClass('active')) {
                    $(this).removeClass('active');
                    input.attr('type', 'password');
                } else {
                    $(this).addClass('active');
                    input.attr('type', 'text');
                }
            });
            $('#$buttonGenerateId').on('click', function () {
                if (input.attr('type') === 'password') {
                    $('#$buttonRevealId').addClass('active');
                    input.attr('type', 'text');
                }
                input.val();
                let pwd = '',
                    symbols = '$this->passwordSymbols',
                    lenght = symbols.length;
                for (let i = 0; i < $this->passwordLenght; i++) {
                    let random = Math.floor(Math.random() * lenght);
                    let char = symbols.substr(random, 1);
                    if (Math.random() > 0.5) {
                        char = char.toUpperCase();
                    }
                    pwd += char;
                }
                input.val(pwd);
            });
JS;
            $this->view->registerJs($js);
        }

        echo Html::endTag('div');
    }
}