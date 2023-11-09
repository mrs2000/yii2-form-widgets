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

            function generateStrongPassword(length = 9, available_sets = 'luds') {
                let sets = []
                if (available_sets.includes('l')) {
                    sets.push('abcdefghjkmnpqrstuvwxyz')
                }
                if (available_sets.includes('u')) {
                    sets.push('ABCDEFGHJKMNPQRSTUVWXYZ')
                }
                if (available_sets.includes('d')) {
                    sets.push('23456789')
                }
                if (available_sets.includes('s')) {
                    sets.push('!@#%&*?')
                }
            
                let all = ''
                let password = ''
                for (let index in sets) {
                    const set = sets[index]
                    const rand = parseInt(Math.random() * set.length)
                    password += set.split('')[rand]
                    all += set
                }
            
                const all_a = all.split('')
                for (let i = 0; i < length - sets.length; i++) {
                    const rand =  parseInt(Math.random() * all_a.length)
                    password += all_a[rand]
                }
            
                return shuffle(password)
            }
            
            function shuffle(string) {
                const parts = string.split('')
                for (let i = parts.length; i > 0;) {
                    const random = parseInt(Math.random() * i)
                    const temp = parts[--i]
                    parts[i] = parts[random]
                    parts[random] = temp
                }
                return parts.join('')
            }
                        
            const input = $('#$inputId')
            $('#$buttonRevealId').on('click', function () {
                if ($(this).hasClass('active')) {
                    $(this).removeClass('active')
                    input.attr('type', 'password')
                } else {
                    $(this).addClass('active')
                    input.attr('type', 'text')
                }
            })
            $('#$buttonGenerateId').on('click', function () {
                if (input.attr('type') === 'password') {
                    $('#$buttonRevealId').addClass('active')
                    input.attr('type', 'text')
                }
                input.val(generateStrongPassword(8))
            })
JS;
            $this->view->registerJs($js);
        }

        echo Html::endTag('div');
    }
}