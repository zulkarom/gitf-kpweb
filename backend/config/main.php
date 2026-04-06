<?php
$params = array_merge(
    require __DIR__ . '/../../common/config/params.php',
    require __DIR__ . '/../../common/config/params-local.php',
    require __DIR__ . '/params.php',
    require __DIR__ . '/params-local.php'
);

return [
    'id' => 'app-backend',
	'name' => 'FKP PORTAL',
    'basePath' => dirname(__DIR__),
    'controllerNamespace' => 'backend\controllers',
    'bootstrap' => ['log'],
	'modules' => [
		'user' => [
			'class' => 'dektrium\user\Module',
			'controllerMap' => [
				'registration' => 'backend\modules\user\controllers\RegistrationController',
				'security' => 'backend\modules\user\controllers\SecurityController',
				'recovery' => 'backend\modules\user\controllers\RecoveryController'
			],
			'modelMap' => [
				'RegistrationForm' => 'backend\modules\user\models\RegistrationForm',
				'User' => 'backend\modules\user\models\User',
				'LoginForm' => 'backend\modules\user\models\LoginForm',
			],
			// uncomment if in production
			//'enableConfirmation' => true, 
			//'enableUnconfirmedLogin' => false,
			'enableConfirmation' => false,
			'enableUnconfirmedLogin' => true,
			'enableFlashMessages' => false,
			
		],
		'admin' => [
            'class' => 'mdm\admin\Module',
			'controllerMap' => [
				'assignment' => 'backend\modules\admin\controllers\AssignmentController',
			],
        ],
		'erpd' => [
            'class' => 'backend\modules\erpd\Module',
        ],
		'staff' => [
            'class' => 'backend\modules\staff\Module',
        ],
		'website' => [
            'class' => 'backend\modules\website\Module',
        ],
		'esiap' => [
            'class' => 'backend\modules\esiap\Module',
        ],
		'proceedings' => [
            'class' => 'backend\modules\proceedings\Module',
        ],
		
		'teaching-load' => [
            'class' => 'backend\modules\teachingLoad\Module',
        ],
		'public-form' => [
            'class' => 'backend\modules\publicForm\Module',
        ],
		'questbank' => [
            'class' => 'backend\modules\questbank\Module',
        ],
		'gridview' => [
			'class' => 'kartik\grid\Module',
			// other module settings
		],
		'course-files' => [
            'class' => 'backend\modules\courseFiles\Module',
        ],
		'chapterinbook' => [
            'class' => 'backend\modules\chapterinbook\Module',
        ],
        'internship' => [
            'class' => 'backend\modules\internship\Modules',
        ],
        'undergrad' => [
            'class' => 'backend\modules\students\Modules',
        ],
        'aduan' => [
            'class' => 'backend\modules\aduan\Module',
        ],
        'downloads' => [
            'class' => 'backend\modules\downloads\Module',
        ],
        'conference' => [
            'class' => 'backend\modules\conference\Module',
        ],
        'manual' => [
	        'class' => 'backend\modules\manual\Module',
	    ],
	    'postgrad' => [
	        'class' => 'backend\modules\postgrad\Module',
	    ],
	    'workshop' => [ 
	        'class' => 'backend\modules\workshop\Module',
	    ],
	    'manual' => [
	        'class' => 'backend\modules\manual\Module',
	    ],
	    'ecert' => [
	        'class' => 'backend\modules\ecert\Module',
	    ],
		'sae' => [
            'class' => 'backend\modules\sae\Module',
        ],
		'protege' => [
            'class' => 'backend\modules\protege\Module',
        ],
		'ticket' => [
            'class' => 'backend\modules\ticket\Module',
        ],
		'grant' => [
            'class' => 'backend\modules\grant\Module',
        ],
		'moderasi' => [
			'class' => 'backend\modules\moderasi\Module',
		],
    ],
    'components' => [
        'request' => [
            'csrfParam' => '_csrf-backend',
        ],
        'user' => [
            'identityClass' => 'common\models\User',
            'enableAutoLogin' => true,
            'identityCookie' => ['name' => '_identity-backend', 'httpOnly' => true],
        ],
		'authManager' => [
            'class' => 'yii\rbac\DbManager', 
			//'yii\rbac\PhpManager' or use 
        ],
        'session' => [
            // this is the name of the session cookie used for login on the backend
            'name' => 'advanced-backend',
        ],
		'view' => [
			'theme' => [
				'pathMap' => [
					'@mdm/admin/views' => '@backend/modules/admin/views/rbac',
					'@dektrium/user/views' => '@backend/modules/user/views'
				],
			],
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
    ],
	'as access' => [
        'class' => 'mdm\admin\components\AccessControl',
        'allowActions' => [
            'site/*',
			'user-setting/*',
			'esiap/default/*',
			'esiap/course/*',
			'erpd/default/*',
			'erpd/research/*',
			'erpd/publication/*',
			'erpd/award/*',
			'erpd/membership/*',
			'erpd/knowledge-transfer/*',
			'erpd/consultation/*',
			'website/default/*',
			'staff/default/*',
			'staff/profile/*',
			'jeb/*',
			'user/*',
			'teaching-load/default/*',
			'teaching-load/appointment-letter/*',
			'public-form/*',
			'aduan/default/*',
			'course-files/default/*',
			'course-files/program/*',
			'course-files/lecture-cancel-file/*',
			'course-files/lecture-receipt-file/*',
			'course-files/lecture-exempt-file/*',
			'course-files/tutorial-cancel-file/*',
			'course-files/tutorial-receipt-file/*',
			'course-files/tutorial-exempt-file/*',
			'course-files/appointment/*',
			'coordinator-assessment-material-file/*',
			'course-files/coordinator-assessment-material-file/*',
			'course-files/coordinator-rubrics-file/*',
			'course-files/coordinator-summative-assessment-file/*',
			'course-files/coordinator-assessment-script-file/*',
			'course-files/coordinator-upload/*',
			'course-files/coordinator-result-final-file/*',
			'course-files/coordinator/*',
			'course-files/staff/*',
			'course-files/material/*',
			'course-files/auditor/*',
			'course-files/attendance-lecture-file/*',
			'undergrad/*',
			'user-manual/*',
			'manual/default/*',
			'ecert/*',
			'sae/*',
			'postgrad/mystudent/*',
			'postgrad/mycommittee/*',
			'firewall/*',
			'ticket/default/*',
			//'application/*',
            //'some-controller/some-action',
            // The actions listed here will be allowed to everyone including guests.
            // So, 'admin/*' should not appear here in the production, of course.
            // But in the earlier stages of your development, you may probably want to
            // add a lot of actions here until you finally completed setting up rbac,
            // otherwise you may not even take a first step.
        ]
    ],
	
    'params' => $params,
];
