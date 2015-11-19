<?
namespace mrssoft\formwidgets;

use Yii;
use yii\validators\Validator;

class PhoneValidate extends Validator
{
    public function init()
    {
        parent::init();

        Yii::$app->i18n->translations['mrssoft/formwidgets'] = [
            'class' => 'yii\i18n\PhpMessageSource',
            'sourceLanguage' => 'en-US',
            'basePath' => '@vendor/mrssoft/yii2-form-widgets/messages',
            'fileMap' => [
                'mrssoft/formwidgets' => 'messages.php',
            ],
        ];

        if ($this->message === null) {
            $this->message = Yii::t('mrssoft/formwidgets', 'The field «{attribute}» must contain 10 or 11 digits.');
        }
    }

    public function validateAttribute($model, $attribute)
    {
        $model->$attribute = preg_replace('/\D/', '', $model->$attribute);
        $lenght = mb_strlen($model->$attribute);
        if ($lenght < 10 || $lenght > 11) {
            $this->addError($model, $attribute, $this->message);
        }
    }

    public function clientValidateAttribute($model, $attribute, $view)
    {
        $message = str_replace('{attribute}', $model->getAttributeLabel($attribute), $this->message);
        $message = json_encode($message, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
        return <<<JS
if (value.length < 10 || value.length > 11) {
    messages.push($message);
}
JS;
    }
}