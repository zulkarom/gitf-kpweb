<?php
namespace backend\modules\erpd\models;

class DatePickerAsset extends \yii\web\AssetBundle
{
    public $sourcePath = '@backend/views/myasset';
    public $css = [
		'css/bootstrap-datepicker.min.css',
    ];
	public $js = [
		'js/bootstrap-datepicker.min.js',
	];

    public $depends = [
        //'rmrevin\yii\fontawesome\AssetBundle',
        'yii\web\YiiAsset',
        //'yii\bootstrap\BootstrapAsset',
        //'yii\bootstrap\BootstrapPluginAsset',
    ];

}
