#!/usr/bin/env php
<?php
// Yii console entry script (custom) for Windows environments where yii (no extension) is missing.

// Adjust debug/env as needed
defined('YII_DEBUG') or define('YII_DEBUG', true);
defined('YII_ENV') or define('YII_ENV', 'dev');

require __DIR__ . '/vendor/autoload.php';
require __DIR__ . '/vendor/yiisoft/yii2/Yii.php';

// Bootstrap files
$commonBootstrap = __DIR__ . '/common/config/bootstrap.php';
if (file_exists($commonBootstrap)) {
    require $commonBootstrap;
}
$consoleBootstrap = __DIR__ . '/console/config/bootstrap.php';
if (file_exists($consoleBootstrap)) {
    require $consoleBootstrap;
}

// Build config
$files = [
    __DIR__ . '/common/config/main.php',
    __DIR__ . '/common/config/main-local.php',
    __DIR__ . '/console/config/main.php',
    __DIR__ . '/console/config/main-local.php',
];
$config = [];
foreach ($files as $f) {
    if (file_exists($f)) {
        $cfg = require $f;
        if (empty($config)) {
            $config = $cfg;
        } else {
            $config = yii\helpers\ArrayHelper::merge($config, $cfg);
        }
    }
}

$application = new yii\console\Application($config);
exit($application->run());
