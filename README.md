Yii2 Form Widgets
=================
[![Latest Stable Version](https://img.shields.io/packagist/v/mrssoft/yii2-form-widgets.svg)](https://packagist.org/packages/mrssoft/yii2-form-widgets)
![PHP](https://img.shields.io/packagist/php-v/mrssoft/yii2-form-widgets.svg)
![Total Downloads](https://img.shields.io/packagist/dt/mrssoft/yii2-form-widgets.svg)

Yii2 widgets for form fields

Input widgets:
- PasswordRevealWidget
- PhoneInputWidget
- MaskedPhoneInputWidget

Validators:
- PhoneValidator


Installation
------------

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

Either run

```
php composer.phar require --prefer-dist mrssofy/yii2-form-widgets "~2.0"
```

or add

```
"mrssofy/yii2-form-widgets": "~2.0"
```

to the require section of your `composer.json` file.


Usage
-----

Once the extension is installed, simply use it in your code by  :

```php
$form->field($order, 'name')->widget(NameInputWidget::class);
$form->field($order, 'phone')->widget(PhoneInputWidget::class);
$form->field($order, 'password')->widget(PasswordRevealWidget::class);
```

```php
public function rules()
{
    return [
        [['phone'], 'required'],
        [['phone'], PhoneValidator::class, 'returnLenght' => 10],
        ...
    ];
}
```