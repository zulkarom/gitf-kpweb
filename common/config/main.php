<?php
return [
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
		'@upload' => '@upload',
		'@img' => '@upload/images',
    ],
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
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
