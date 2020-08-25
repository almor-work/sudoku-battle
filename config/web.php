<?php

$params = require __DIR__ . '/params.php';

$config = [
    'id' => 'sudoku',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'components' => [
        'request' => [
            'cookieValidationKey' => $params['cookieValidationKey'],
            'enableCsrfValidation' => true,
            'csrfParam' => 'CSRF',
        ],
        'user' => [
            'identityClass' => 'app\models\User',
            'enableAutoLogin' => false
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'assetManager' => [
            'appendTimestamp' => true,
            'linkAssets' => true,
            'bundles' => [
                'yii\web\JqueryAsset' => [
                    'sourcePath' => null,
                    'js' => [
                        'https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js',
                    ]
                ],
            ],
        ],
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [],
        ],
        'formatter' => [
            'timeZone' => 'Europe/Moscow',
            'datetimeFormat' => 'php:d.m.Y H:i:s',
            'nullDisplay' => ''
        ],
    ],
    'params' => $params,
];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
        'allowedIPs' => ['*'],
    ];
}

return $config;
