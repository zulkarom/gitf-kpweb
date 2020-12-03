<?php

namespace backend\assets;

use yii\web\AssetBundle;

/**
 * Main backend application asset bundle.
 */
class ExcelAsset extends AssetBundle
{
    public $sourcePath = '@backend/views/sheetjs';
    
    public $js = [
        'shim.js',
        'dist/xlsx.full.min.js',
        'jszip.js',
        
    ];
  
}
