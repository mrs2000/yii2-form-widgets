<?php

namespace mrssoft\formwidgets;

use yii\web\AssetBundle;
use yii\web\JqueryAsset;

class MaskedInputAsset extends AssetBundle
{
    public $sourcePath = '@bower/jquery.maskedinput/dist';

    public $js = [
        'jquery.maskedinput.min.js'
    ];

    public $depends = [
        JqueryAsset::class
    ];
}