<?php

namespace backend\assets;

use yii\web\AssetBundle;

/**
 * Main backend application asset bundle.
 */
class AppAsset extends AssetBundle
{
    public $sourcePath = '@backend/views/myasset';
    public $css = [
        //'css/site.css',
    ];
    public $js = [
    ];
   public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
		'djabiev\yii\assets\AutosizeTextareaAsset',
    ];
}
