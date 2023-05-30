<?php
$params = array_merge(
    require __DIR__ . '/../../common/config/params.php',
    require __DIR__ . '/../../common/config/params-local.php',
    require __DIR__ . '/params.php',
    require __DIR__ . '/params-local.php'
);

return [
    'id' => 'app-tu2i',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'controllerNamespace' => 'tu2i\controllers',
    'components' => [
        'request' => [
            'csrfParam' => '_csrf-tu2i',
        ],
        'user' => [
            'identityClass' => 'backend\modules\sae\models\User',
            'enableAutoLogin' => true,
            'identityCookie' => ['name' => '_identity-tu2i', 'httpOnly' => true],
        ],
        'session' => [
            // this is the name of the session cookie used for login on the tu2i
            'name' => 'advanced-tu2i',
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        /*
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
            ],
        ],
        */
    ],
    'params' => $params,
];
