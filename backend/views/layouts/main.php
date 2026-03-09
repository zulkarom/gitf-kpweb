<?php
use yii\helpers\Html;

/* @var $this \yii\web\View */
/* @var $content string */


    backend\assets\AppAsset::register($this);

    backend\assets\AdminLteAsset::register($this);

    $directoryAsset = Yii::$app->assetManager->getPublishedUrl('@vendor/almasaeed2010/adminlte/dist');
    ?>
    <?php $this->beginPage() ?>
    <!DOCTYPE html>
    <html lang="<?= Yii::$app->language ?>">
    <head>
        <meta charset="<?= Yii::$app->charset ?>"/>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <?= Html::csrfMetaTags() ?>
        <link rel="icon" type="image/png" href="<?= Yii::getAlias('@web/images/favicon.png') ?>">
        <title><?= Html::encode($this->title) ?></title>
        <?php $this->head() ?>
        <style>
            /* === Custom Font (self-hosted) ===
               Place font files in: backend/web/fonts/
               Suggested files: Inter-Variable.woff2 (or Inter-Regular.woff2/woff)
            */
            @font-face {
                font-family: 'Inter';
                src: url('<?= Yii::$app->request->baseUrl ?>/fonts/Inter-Variable.woff2') format('woff2');
                font-weight: 100 900;
                font-style: normal;
                font-display: swap;
            }
            @font-face {
                font-family: 'Inter';
                src: url('<?= Yii::$app->request->baseUrl ?>/fonts/Inter-Regular.woff2') format('woff2'),
                     url('<?= Yii::$app->request->baseUrl ?>/fonts/Inter-Regular.woff') format('woff');
                font-weight: 400;
                font-style: normal;
                font-display: swap;
            }

            html, body, .wrapper { font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif; }
            body { -webkit-font-smoothing: antialiased; -moz-osx-font-smoothing: grayscale; background: #f3f4f6; }
            .content-wrapper, .right-side, .content, .wrapper { background: #f3f4f6; }

            .skin-blue .main-header .logo {
                background:#ffffff;
                height: 60px;
                display:flex;
                align-items:center;
                justify-content:center;
                border-right: 1px solid rgba(15, 23, 42, 0.08);
                box-shadow: 0 1px 6px rgba(15, 23, 42, 0.04);
            }
            .skin-blue .main-header .logo:hover {
                background:#ffffff;
            }
            .skin-blue .main-header .navbar {
                background:#ffffff;
                border-bottom: 1px solid rgba(15, 23, 42, 0.08);
                box-shadow: 0 1px 4px rgba(15, 23, 42, 0.05);
            }
            .skin-blue .main-header .navbar .sidebar-toggle,
            .skin-blue .main-header .navbar .sidebar-toggle:before { color:#334155; }
            .skin-blue .main-header .navbar .sidebar-toggle:hover { background-color: #f3f4f6; }
            .skin-blue .main-header .navbar .nav>li>a { color:#334155; }

            .main-header .logo { font-weight:700; letter-spacing:.5px; padding: 0 14px; }
            .main-header .logo .logo-lg { font-size:22px; }
            .main-header .navbar { min-height:60px; height:60px; }
            .main-header .navbar .sidebar-toggle { height:60px; padding: 20px 18px; color: #334155; }
            .main-header .navbar .nav>li>a { height:60px; padding-top:20px; padding-bottom:20px; padding-left:14px; padding-right:14px; font-size:14px; transition: background-color 0.2s ease, color 0.2s ease; }
            .navbar-custom-menu .user-menu>.dropdown-toggle .hidden-xs { font-size:14px; font-weight:600; }
            .navbar-custom-menu>.navbar-nav>li>.dropdown-toggle { display:flex; align-items:center; gap:10px; }
            .navbar-nav>.user-menu>.dropdown-menu { border-radius: 10px; overflow: hidden; }
            .navbar-custom-menu .user-menu>.dropdown-toggle .fa-chevron-down,
            .navbar-custom-menu .navbar-nav>li>a>.fa,
            .navbar-custom-menu .navbar-nav>li>a>.glyphicon,
            .navbar-custom-menu .navbar-nav>li>a>.ion { color:#64748b; }

            .main-sidebar { font-size:15px; background:#020031; box-shadow: 4px 0 18px rgba(2, 0, 49, 0.18); }
            .main-sidebar, .main-sidebar .sidebar { background:#020031; }
            .sidebar { padding-top: 10px; }
            .sidebar .user-panel { border-bottom: 1px solid rgba(255,255,255,0.06); margin: 0 12px 14px; padding: 14px 12px 16px; background: rgba(255,255,255,0.03); border-radius: 10px; }
            .sidebar .user-panel .info p,
            .sidebar .user-panel .info>a { color:#ffffff; }
            .sidebar .user-panel .info p { font-size:14px; font-weight:600; margin-bottom:2px; }
            .sidebar-menu { padding: 0 10px 14px; }
            .sidebar-menu>li { margin-bottom: 4px; }
            .sidebar-menu>li.header { color:#A5A9C3; font-weight:700; font-size:11px; letter-spacing:1px; padding: 16px 10px 8px; background: transparent !important; }
            .sidebar-menu>li>a { padding:12px 16px; font-size:14px; color:#C2C7D0; border-radius:6px; transition: all 0.2s ease; }
            .sidebar-menu>li>a>.fa, .sidebar-menu>li>a>.glyphicon, .sidebar-menu>li>a>.ion { width:22px; margin-right:10px; font-size:16px; color:#A7B1C2; transition: all 0.2s ease; }
            .sidebar-menu .treeview-menu { padding-left: 0; margin-top: 4px; background: transparent !important; }
            .sidebar-menu .treeview-menu>li { margin-bottom: 4px; }
            .sidebar-menu .treeview-menu>li>a { padding:11px 16px 11px 20px; font-size:14px; color:#C2C7D0; border-radius:6px; transition: all 0.2s ease; }
            .sidebar-menu .treeview-menu>li>a>.fa,
            .sidebar-menu .treeview-menu>li>a>.glyphicon,
            .sidebar-menu .treeview-menu>li>a>.ion { width:22px; margin-right:10px; font-size:16px; color:#A7B1C2; transition: all 0.2s ease; }
            .sidebar-menu > li.treeview,
            .sidebar-menu > li.treeview > .treeview-menu,
            .sidebar-menu > li.active.treeview > .treeview-menu { background: transparent !important; }
            .sidebar-menu>li:hover>a,
            .sidebar-menu .treeview-menu>li>a:hover { background:#23224D; color:#FFFFFF; }
            .sidebar-menu>li:hover>a>.fa,
            .sidebar-menu>li:hover>a>.glyphicon,
            .sidebar-menu>li:hover>a>.ion,
            .sidebar-menu .treeview-menu>li>a:hover>.fa,
            .sidebar-menu .treeview-menu>li>a:hover>.glyphicon,
            .sidebar-menu .treeview-menu>li>a:hover>.ion { color:#FFFFFF; }
            .sidebar-menu>li.active>a,
            .sidebar-menu .treeview-menu>li.active>a { background:linear-gradient(90deg, #1E88E5, #1976D2); color:#FFFFFF; border-radius:6px; box-shadow: 0 8px 18px rgba(25, 118, 210, 0.28); }
            .sidebar-menu>li.active>a>.fa,
            .sidebar-menu>li.active>a>.glyphicon,
            .sidebar-menu>li.active>a>.ion,
            .sidebar-menu .treeview-menu>li.active>a>.fa,
            .sidebar-menu .treeview-menu>li.active>a>.glyphicon,
            .sidebar-menu .treeview-menu>li.active>a>.ion { color:#FFFFFF; }

            .navbar-nav>.user-menu .dropdown-menu { box-shadow:0 6px 18px rgba(0,0,0,.15); }

            .label-outline {
                display: inline-block;
                padding: 3px 9px;
                border-radius: 12px;
                border: 1px solid transparent;
                font-size: 12px;
                font-weight: 600;
                background: transparent;
                line-height: 1.4;
            }
            .label-outline--blue { color: #337ab7; border-color: #337ab7; }
            .label-outline--green { color: #00a65a; border-color: #00a65a; }
            .label-outline--yellow { color: #f39c12; border-color: #f39c12; }
            .label-outline--aqua { color: #00c0ef; border-color: #00c0ef; }
            .label-outline--red { color: #dd4b39; border-color: #dd4b39; }
            .label-outline--purple { color: #605ca8; border-color: #605ca8; }
            .label-outline--gray { color: #777; border-color: #bbb; }

            @media (max-width: 767px){
                .main-header .logo .logo-lg { font-size:20px; }
                .main-header .navbar { min-height:50px; }
                .main-header .navbar .nav>li>a { padding-top:14px; padding-bottom:14px; }
            }
        </style>
    </head>
    <body class="hold-transition skin-blue sidebar-mini">
    <?php $this->beginBody() ?>
    <div class="wrapper">

        <?= $this->render(
            'header.php',
				['directoryAsset' => $directoryAsset]
        ) ?>

        <?= $this->render(
            'left.php',
            ['directoryAsset' => $directoryAsset]
        )
        ?>

        <?= $this->render(
            'content.php',
            ['content' => $content, 'directoryAsset' => $directoryAsset]
        ) ?>

    </div>

    <?php $this->endBody() ?>
    </body>
    </html>
    <?php $this->endPage() ?>
