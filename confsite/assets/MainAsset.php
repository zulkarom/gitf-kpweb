<?php
namespace confsite\assets;

class MainAsset extends \yii\web\AssetBundle
{
    public $sourcePath = '@confsite/views/myasset';
    public $css = [
	'vendor/bootstrap/css/bootstrap.min.css',
	'fonts/font-awesome-4.7.0/css/font-awesome.min.css',
	'fonts/themify/themify-icons.css',
	'fonts/Linearicons-Free-v1.0.0/icon-font.min.css',
	'fonts/elegant-font/html-css/style.css',
	'vendor/animate/animate.css',
	'vendor/css-hamburgers/hamburgers.min.css',
	'vendor/animsition/css/animsition.min.css',
	'vendor/slick/slick.css',
	'css/util.css',
	'css/main.css',

    ];
	public $js = [
	//'vendor/jquery/jquery-3.2.1.min.js',
	'vendor/animsition/js/animsition.min.js',
	'vendor/bootstrap/js/popper.js',
	'vendor/bootstrap/js/bootstrap.min.js',
	'js/main.js',
		
	];

    public $depends = [
        //'rmrevin\yii\fontawesome\AssetBundle',
        'yii\web\YiiAsset',
		'djabiev\yii\assets\AutosizeTextareaAsset',
        //'yii\bootstrap\BootstrapAsset',
        //'yii\bootstrap\BootstrapPluginAsset',
    ];

}
