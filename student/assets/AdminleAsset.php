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
        'plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css',
        'plugins/icheck-bootstrap/icheck-bootstrap.min.css',
        'plugins/jqvmap/jqvmap.min.css',
        'dist/css/adminlte.min.css',
        'plugins/overlayScrollbars/css/OverlayScrollbars.min.css',
        'plugins/daterangepicker/daterangepicker.css',
        'plugins/summernote/summernote-bs4.min.css',

    ];

    public $js = [

        /*jQuery */
        // 'plugins/jquery/jquery.min.js',

        /*jQuery UI 1.11.4*/
        'plugins/jquery-ui/jquery-ui.min.js',

        /*Bootstrap 4*/
        // 'plugins/bootstrap/js/bootstrap.bundle.min.js',

        /*ChartJS */
        'plugins/chart.js/Chart.min.js',

        /*Sparkline*/
        'plugins/sparklines/sparkline.js',

        /*JQVMap*/
        'plugins/jqvmap/jquery.vmap.min.js',

        /*jQuery Knob Chart*/
        'plugins/jqvmap/maps/jquery.vmap.usa.js',
        'plugins/jquery-knob/jquery.knob.min.js',

        /*daterangepicker*/ 
        'plugins/moment/moment.min.js',
        'plugins/daterangepicker/daterangepicker.js',

        /*Tempusdominus Bootstrap 4*/
        // 'plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js',

        /*Summernote */
        'plugins/summernote/summernote-bs4.min.js',

        /*overlayScrollbars*/ 
        'plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js',

        /*AdminLTE App*/
        'dist/js/adminlte.js',
        // 'dist/js/demo.js',
        // 'dist/js/pages/dashboard.js',
		
    ];

   //  public $publishOptions = [
   //      "only" => [
   //          "dist/js/*",
   //          "dist/css/*",
			// "dist/img/*",
   //          //"plugins/bootstrap/js/*",
			// "plugins/fontawesome-free/css/*",
			// "plugins/fontawesome-free/webfonts/*",
			// "plugins/toastr/*",
   //      ],

   //  ];

    public $depends = [
        'yii\web\YiiAsset',
		'djabiev\yii\assets\AutosizeTextareaAsset',
        //'yii\jui\JuiAsset',
        'yii\bootstrap4\BootstrapAsset',
        //'student\assets\FontAwesomeAsset'
    ];
}