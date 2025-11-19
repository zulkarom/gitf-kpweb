<?php
return [
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
		'@upload' => '@upload',
		'@img' => '@upload/images',
    ],
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'timeZone' => 'Asia/Kuala_Lumpur',
    'components' => [
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
		'formatter' => [
			'dateFormat' => 'php:d M Y',
			'datetimeFormat' => 'php:D d M Y h:i a',
			'decimalSeparator' => '.',
			'thousandSeparator' => ', ',
			'currencyCode' => 'RM',
            'timeZone' => 'Asia/Kuala_Lumpur',
            'defaultTimeZone' => 'UTC', // if you store in UTC (optional)
		],
		
		'workflowSource' => [
          'class' => 'raoul2000\workflow\source\file\WorkflowFileSource',
          'definitionLoader' => [
              'class' => 'raoul2000\workflow\source\file\PhpClassLoader',
              'namespace'  => 'common\models\workflows'
           ]
		],
    ],
];
