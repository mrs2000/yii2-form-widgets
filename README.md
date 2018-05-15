Yii2 Form Widgets
=================
Yii2 widgets for form fields

Installation
------------

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

Either run

```
php composer.phar require --prefer-dist mrssofy/yii2-form-widgets "*"
```

or add

```
"mrssofy/yii2-form-widgets": "*"
```

to the require section of your `composer.json` file.


Usage
-----

Once the extension is installed, simply use it in your code by  :

```php

$form = ActiveForm::begin([
    'fieldClass' => 'mrssoft\formwidgets\ActiveField'
]);

$form->field($order, 'name')->widget(FieldFIO::class);
$form->field($order, 'phone')->widget(FieldPhone::class);
```