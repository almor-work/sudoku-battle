<?php

namespace app\assets;

use yii\web\AssetBundle;

class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';

    public $css = [
        'styles/main.css'
    ];

    public $js = [
        'scripts/main.js'
    ];
}
