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
     * @var int
     */
    public $returnLenght;

    public $message = 'Поле «{attribute}» должно содержать 10 или 11 цифр номера.';

    public function validateAttribute($model, $attribute)
    {
        $model->{$attribute} = (string)preg_replace('/\D/', '', $model->{$attribute});
        $lenght = mb_strlen($model->{$attribute});
        if ($lenght < 10 || $lenght > 11) {
            $this->addError($model, $attribute, $this->message);
        }

        if ($this->returnLenght !== null && $lenght != $this->returnLenght) {
            $model->{$attribute} = substr($model->{$attribute}, $lenght - $this->returnLenght);
        }
    }

    public function clientValidateAttribute($model, $attribute, $view)
    {
        $message = $this->formatMessage($this->message, ['attribute' => $model->getAttributeLabel($attribute)]);
        $message = json_encode($message, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
        return "if (value.length < 10 || value.length > 11) { messages.push($message); }";
    }
}