<?php
/**
 * Created by PhpStorm.
 * User: ks
 * Date: 24/6/2561
 * Time: 1:54 น.
 */
namespace student\assets;

use yii\web\AssetBundle;

class AdminleAsset extends AssetBundle
{
    public $sourcePath = '@student/assets/adminlte';
    public $css = [
		'plugins/fontawesome-free/css/all.min.css',
		"plugins/toastr/toastr.min.css",
        'dist/css/adminlte.min.css',
    ];

    public $js = [
        'dist/js/adminlte.js',
        //'plugins/bootstrap/js/bootstrap.min.js',
		'plugins/toastr/toastr.min.js'
		
    ];

    public $publishOptions = [
        "only" => [
            "dist/js/*",
            "dist/css/*",
			"dist/img/*",
            //"plugins/bootstrap/js/*",
			"plugins/fontawesome-free/css/*",
			"plugins/fontawesome-free/webfonts/*",
			"plugins/toastr/*",
        ],

    ];

    public $depends = [
        'yii\web\YiiAsset',
		'djabiev\yii\assets\AutosizeTextareaAsset',
        //'yii\jui\JuiAsset',
        'yii\bootstrap4\BootstrapAsset',
        //'student\assets\FontAwesomeAsset'
    ];
}