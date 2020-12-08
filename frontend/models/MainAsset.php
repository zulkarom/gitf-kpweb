<?php
namespace frontend\models;

class MainAsset extends \yii\web\AssetBundle
{
    public $sourcePath = '@frontend/views/myasset';
	
    public $css = [
        "css/bootstrap.min.css",
		"css/font-awesome.min.css",
		"css/themify-icons.css",
		"css/style3.css",	
		
    ];
	

	
    public $js = [
		//"js/rem.min.js",
		//"js/jssor.slider.min.js",
		//"js/jquery-3.2.1.min.js",
		"js/main.js",
		
		
    ];

    public $depends = [
        //'rmrevin\yii\fontawesome\AssetBundle',
        //'yii\web\YiiAsset',
        //'yii\bootstrap\BootstrapAsset',
        //'yii\bootstrap\BootstrapPluginAsset',
    ];

}
