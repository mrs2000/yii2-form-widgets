<?php

namespace mrssoft\formwidgets;

use yii\validators\Validator;

/**
 * Validate phone
 */
class PhoneValidator extends Validator
{
    /**
     * Return length of phone number (default - null, do not crop phone number)
     */
    public int $returnLenght = 0;

    public bool $checkNine = true;

    public $message = 'Поле «{attribute}» должно содержать 10 или 11 цифр номера.';

    public string $wrongNineMessage = 'Неверный формат номера телефона.';

    public function validateAttribute($model, $attribute)
    {
        $result = (string)preg_replace('/\D/', '', $model->{$attribute});
        $lenght = mb_strlen($result);
        if ($lenght < 10 || $lenght > 11) {
            $this->addError($model, $attribute, $this->message);
        } else if ($this->returnLenght && $lenght != $this->returnLenght) {
            $result = substr($result, $lenght - $this->returnLenght);
            if ($this->checkNine) {
                $pos = $this->returnLenght == 10 ? 0 : 1;
                if (mb_substr($result, $pos, 1) != 9) {
                    $this->addError($model, $attribute, $this->wrongNineMessage);
                }
            }
        }

        $model->{$attribute} = $result;
    }

    public function clientValidateAttribute($model, $attribute, $view)
    {
        $message = $this->formatClientMessage($model, $attribute, $this->message);
        $wrongNineMessage = $this->formatClientMessage($model, $attribute, $this->wrongNineMessage);

        $checkNine = $this->checkNine;

        return <<<JS
            value = value.replace(/\D/g, ''); 
            if (value.length < 10 || value.length > 11) { 
                messages.push($message);
            }
            if ($checkNine) {
                const pos = value.length == 10 ? 0 : 1;
                if (value.substr(pos, 1) != 9) {
                    messages.push($wrongNineMessage);
                }
            }
JS;
    }

    private function formatClientMessage($model, $attribute, $message): string
    {
        $message = $this->formatMessage($message, [
            'attribute' => $model->getAttributeLabel($attribute)
        ]);

        return json_encode($message, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
    }
}