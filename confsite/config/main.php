<?php
$params = array_merge(
    require __DIR__ . '/../../common/config/params.php',
    require __DIR__ . '/../../common/config/params-local.php',
    require __DIR__ . '/params.php',
    require __DIR__ . '/params-local.php'
);

return [
    'id' => 'app-confsite',
	'name'=>'ConfValley.com',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'controllerNamespace' => 'confsite\controllers',
	'modules' => [
		'user' => [
			'class' => 'dektrium\user\Module',
			'controllerMap' => [
				'registration' => 'confsite\controllers\user\RegistrationController',
				'security' => 'confsite\controllers\user\SecurityController',
				'recovery' => 'confsite\controllers\user\RecoveryController'
			],
			'modelMap' => [
				'RegistrationForm' => 'confsite\models\user\RegistrationForm',
				'User' => 'confsite\models\user\User',
				'LoginForm' => 'confsite\models\user\LoginForm',
			],
			// uncomment if in production
			//'enableConfirmation' => true, 
			//'enableUnconfirmedLogin' => false,
			
			'enableConfirmation' => true,
			'enableUnconfirmedLogin' => true,
			'enableFlashMessages' => false,
			
		],
		
	],
    'components' => [
        'request' => [
            'csrfParam' => '_csrf-confsite',
        ],
		
		'view' => [
			'theme' => [
				'pathMap' => [
					'@dektrium/user/views' => '@confsite/views/user'
				],
			],
		],
		 'urlManager' => [
            'enablePrettyUrl' => true,
             'showScriptName' => false,
            'rules' => [
			'' => 'site/index',
			'<confurl>' => 'site/home',
			'<confurl>/<controller>/<action>' => '<controller>/<action>',
			
			
			
            ],
        ],
        /* 'user' => [
            'identityClass' => 'common\models\User',
            'enableAutoLogin' => true,
            'identityCookie' => ['name' => '_identity-confsite', 'httpOnly' => true],
        ], */
        'session' => [
            // this is the name of the session cookie used for login on the confsite
            'name' => 'advanced-confsite',
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
	
	/* 'modules' => [
        'supplier' => [
            'class' => 'confsite\modules\supplier\Module',
        ],
		'catalog' => [
            'class' => 'confsite\modules\catalog\Module',
        ],
		'client' => [
            'class' => 'confsite\modules\client\Module',
        ],
    ], */
	
	
    'params' => $params,
];


