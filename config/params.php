<?php
$paramsFile = __DIR__ . '/params-local.php';
$paramsLocal = [];
if (file_exists($paramsFile)) {
    $paramsLocal = require $paramsFile;
}

return \yii\helpers\ArrayHelper::merge([
    'cookieValidationKey' => 'ldmR9quvmCTtJuhxhr3CzmZMgV5Df7cA',
], $paramsLocal);
