<?php
namespace frontend\models;

class MainAsset extends \yii\web\AssetBundle
{
    public $sourcePath = '@frontend/views/myasset';
	
    public $css = [
        "css/bootstrap.min.css",
		"css/font-awesome.min.css",
		"css/themify-icons.css",
		"css/magnific-popup.css",
		"css/animate.css",
		"css/owl.carousel.css",
		"css/style.css",	
		"css/nav-core.min.css",
		"css/nav-layout.css",
		
    ];
	

	
    public $js = [
		//"js/rem.min.js",
		//"js/jssor.slider.min.js",
		"js/jquery-3.2.1.min.js",
		"js/owl.carousel.min.js",
		"js/jquery.countdown.js",
		"js/masonry.pkgd.min.js",
		"js/magnific-popup.min.js",
		"js/main.js",
		"js/nav.jquery.min.js"
		
		
    ];

    public $depends = [
        //'rmrevin\yii\fontawesome\AssetBundle',
        //'yii\web\YiiAsset',
        //'yii\bootstrap\BootstrapAsset',
        //'yii\bootstrap\BootstrapPluginAsset',
    ];

}
