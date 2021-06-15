<?php
namespace confsite\assets;

class MainAsset extends \yii\web\AssetBundle
{
    public $sourcePath = '@confsite/views/myasset';
    public $css = [
	'vendo/bootstrap/css/bootstrap.min.css',
	'fonts/font-awesome-4.7.0/css/font-awesome.min.css',
	'fonts/themify/themify-icons.css',
	'fonts/Linearicons-Free-v1.0.0/icon-font.min.css',
	'fonts/elegant-font/html-css/style.css',
	'vendo/animate/animate.css',
	'vendo/css-hamburgers/hamburgers.min.css',
	'vendo/animsition/css/animsition.min.css',
	'vendo/slick/slick.css',
	'css/util.css',
	'css/main.css',

    ];
	public $js = [
	//'vendor/jquery/jquery-3.2.1.min.js',
	'vendo/animsition/js/animsition.min.js',
	'vendo/bootstrap/js/popper.js',
	'vendo/bootstrap/js/bootstrap.min.js',
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
