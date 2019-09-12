<?php

namespace backend\assets;

use yii\web\AssetBundle;

/**
 * Main backend application asset bundle.
 */
class AppAsset extends AssetBundle
{
    public $sourcePath = '@confvalley/views/myasset';
    public $css = [
        //'css/site.css',
    ];
    public $js = [
    ];
   /*  public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ]; */
}
