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
            body { -webkit-font-smoothing: antialiased; -moz-osx-font-smoothing: grayscale; }

            /* Professional header + sidebar refinements */
            /* Header color customization with gradient */
            .skin-blue .main-header .logo {
                background: linear-gradient(135deg, #0b1220 0%, #111f3a 50%, #17355d 100%);
                color:#fff;
            }
            .skin-blue .main-header .logo:hover {
                background: linear-gradient(135deg, #0f172a 0%, #14284a 60%, #1b416f 100%);
            }
            .skin-blue .main-header .navbar {
                background: linear-gradient(135deg, #24406f 0%, #2a5d9a 60%, #2f73c4 100%);
                border-bottom: 0;
            }
            .skin-blue .main-header .navbar .sidebar-toggle:hover { background-color: rgba(255,255,255,0.08); }
            .skin-blue .main-header .navbar .nav>li>a { color:#e9eef5; }

            .main-header .logo { font-weight:700; letter-spacing:.5px; }
            .main-header .logo .logo-lg { font-size:22px; }
            .main-header .navbar { min-height:54px; }
            .main-header .navbar .nav>li>a { padding-top:16px; padding-bottom:16px; font-size:14px; }
            .navbar-custom-menu .user-menu>.dropdown-toggle .hidden-xs { font-size:14px; font-weight:600; }

            .main-sidebar { font-size:15px; }
            .sidebar .user-panel .info p { font-size:14px; font-weight:600; margin-bottom:2px; }
            .sidebar-menu>li.header { color:#98a1b3; font-weight:700; font-size:12px; letter-spacing:.7px; }
            .sidebar-menu>li>a { padding:13px 16px; font-size:15px; }
            .sidebar-menu>li>a>.fa, .sidebar-menu>li>a>.glyphicon, .sidebar-menu>li>a>.ion { width:22px; font-size:18px; }
            /* Align child (tree) items with parent items */
            .sidebar-menu .treeview-menu { padding-left: 0; }
            .sidebar-menu .treeview-menu>li>a { padding:11px 16px; font-size:15px; }
            .sidebar-menu .treeview-menu>li>a>.fa,
            .sidebar-menu .treeview-menu>li>a>.glyphicon,
            .sidebar-menu .treeview-menu>li>a>.ion { width:22px; font-size:18px; }
            .sidebar-menu>li.active>a, .sidebar-menu>li:hover>a { background:#f4f6f9; color:#111; }

            /* Slightly softer shadows for dropdowns */
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
