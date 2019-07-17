<?php

namespace frontend\assets;

use yii\web\AssetBundle;

/**
 * Main frontend application asset bundle.
 */
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
	
    public $baseUrl = '@web';
	
    public $css = [
        "css/bootstrap.min.css",
		"css/font-awesome.min.css",
		"css/themify-icons.css",
		"css/magnific-popup.css",
		"css/animate.css",
		"css/owl.carousel.css",
		"css/style.css",	
		"css/nav-core.min.css",
		"css/nav-layout.css"
    ];
	

	
    public $js = [
		"js/rem.min.js",
		"js/jssor.slider.min.js",
		"js/jquery-3.2.1.min.js",
		"js/owl.carousel.min.js",
		"js/jquery.countdown.js",
		"js/masonry.pkgd.min.js",
		"js/magnific-popup.min.js",
		"js/main.js",
		"js/nav.jquery.min.js"
		
		
    ];
	
	
    public $depends = [
        'yii\web\YiiAsset',
        //'yii\bootstrap\BootstrapAsset',
    ];
}
