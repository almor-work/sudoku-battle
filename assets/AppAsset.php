<?php

namespace app\assets;

use yii\web\AssetBundle;

class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';

    public $css = [
        'libs/bootstrap.min.css',
        'styles/main.css'
    ];

    public $js = [
        'libs/bootstrap.min.js',
        'scripts/main.js'
    ];
}
