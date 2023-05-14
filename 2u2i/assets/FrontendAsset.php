<?php
/**
 * Created by PhpStorm.
 * User: ks
 * Date: 24/6/2561
 * Time: 1:54 น.
 */
namespace frontend\assets;

use yii\web\AssetBundle;

class FrontendAsset extends AssetBundle
{
    public $sourcePath = '@frontend/assets/frontendAssets';
    public $css = [
        'css/style2.css',
        'bootstrap/css/bootstrap.css',

    ];

    public $js = [
        'js/jquery/jquery.plugin.js',
        'js/jquery/jquery.countdown.js',
        // 'js/jquery/core/jquery.min.js',
        'excel/dist/xlsx.core.min.js',
        'excel/dist/FileSaver.js',
        'js/jquery/timer.jquery.min.js',
    ];


    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap4\BootstrapAsset',
    ];
}